<?php

namespace Drupal\blazy\Dejavu;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Render\Markup;
use Drupal\image\Plugin\Field\FieldType\ImageItem;
use Drupal\blazy\Blazy;
use Drupal\blazy\BlazyDefault;

/**
 * A Trait common for optional views style plugins.
 */
trait BlazyStyleBaseTrait {

  /**
   * The first Blazy formatter found to get data from for lightbox gallery, etc.
   *
   * @var array
   */
  protected $firstImage;

  /**
   * The dynamic html settings.
   *
   * @var array
   */
  protected $htmlSettings = [];

  /**
   * The blazy manager service.
   *
   * @var \Drupal\blazy\BlazyManagerInterface
   */
  protected $blazyManager;

  /**
   * Returns the blazy manager.
   */
  public function blazyManager() {
    return $this->blazyManager;
  }

  /**
   * Provides commons settings for the style plugins.
   */
  protected function buildSettings() {
    $view      = $this->view;
    $count     = count($view->result);
    $settings  = $this->options;
    $view_name = $view->storage->id();
    $view_mode = $view->current_display;
    $plugin_id = $this->getPluginId();
    $instance  = str_replace('_', '-', "{$view_name}-{$view_mode}");
    $id        = empty($settings['id']) ? '' : $settings['id'];
    $id        = Blazy::getHtmlId("{$plugin_id}-views-{$instance}", $id);
    $settings += [
      'cache_metadata' => [
        'keys' => [$id, $view_mode, $count],
      ],
    ] + BlazyDefault::lazySettings();

    // Prepare needed settings to work with.
    $settings['check_blazy']       = TRUE;
    $settings['id']                = $id;
    $settings['cache_tags']        = $view->getCacheTags();
    $settings['count']             = $count;
    $settings['current_view_mode'] = $view_mode;
    $settings['instance_id']       = $instance;
    $settings['multiple']          = TRUE;
    $settings['plugin_id']         = $plugin_id;
    $settings['use_ajax']          = $view->ajaxEnabled();
    $settings['view_name']         = $view_name;
    $settings['view_display']      = $view->style_plugin->displayHandler->getPluginId();
    $settings['_views']            = TRUE;

    if (!empty($this->htmlSettings)) {
      $settings = NestedArray::mergeDeep($settings, $this->htmlSettings);
    }

    $this->blazyManager()->getModuleHandler()->alter('blazy_settings_views', $settings, $view);
    return $settings;
  }

  /**
   * Sets dynamic html settings.
   */
  protected function setHtmlSettings(array $settings = []) {
    $this->htmlSettings = $settings;
    return $this;
  }

  /**
   * Returns the first Blazy formatter found.
   */
  public function getFirstImage($row) {
    if (!isset($this->firstImage)) {
      $rendered = [];
      if ($row && isset($row->_entity) && $fields = $row->_entity->getFields(FALSE)) {
        foreach ($fields as $field) {
          if ($field->getFieldDefinition()->getFieldStorageDefinition()->getSetting('target_type') == 'media') {
            $name = $field->getName();
            break;
          }
          if ($field->first() instanceof ImageItem) {
            $name = $field->getName();
            break;
          }
        }

        if (isset($name) && $rendered = $this->getFieldRenderable($row, 0, $name)) {
          if (is_array($rendered) && isset($rendered['rendered']) && !($rendered['rendered'] instanceof Markup)) {
            $rendered = isset($rendered['rendered']['#build']) ? $rendered['rendered']['#build'] : [];
          }
        }
      }
      $this->firstImage = $rendered;
    }
    return $this->firstImage;
  }

  /**
   * Returns the renderable array of field containing rendered and raw data.
   */
  public function getFieldRenderable($row, $index, $field_name = '', $multiple = FALSE) {
    if (empty($field_name)) {
      return FALSE;
    }

    // Be sure to not check "Use field template" under "Style settings" to have
    // renderable array to work with, otherwise flattened string!
    $result = isset($this->view->field[$field_name]) ? $this->view->field[$field_name]->getItems($row) : [];
    return empty($result) ? [] : ($multiple ? $result : $result[0]);
  }

}
