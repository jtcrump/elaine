<?php

namespace Drupal\Tests\feeds\FunctionalJavascript\Form;

use Drupal\filter\Entity\FilterFormat;
use Drupal\Tests\feeds\FunctionalJavascript\FeedsJavascriptTestBase;

/**
 * @coversDefaultClass \Drupal\feeds\Form\MappingForm
 * @group feeds
 */
class MappingFormTest extends FeedsJavascriptTestBase {

  /**
   * Tests that multiple new CSV sources can be defined without errors.
   */
  public function testSetMultipleMappingsWithCustomSources() {
    // Create a feed type with no mappings.
    $feed_type = $this->createFeedTypeForCsv([], [
      'mappings' => [],
    ]);

    // Add body field.
    node_add_body_field($this->nodeType);

    // Create a filter format.
    $format = FilterFormat::create([
      'format' => 'empty_format',
      'name' => 'Empty format',
    ]);
    $format->save();

    // Allow admin user to use this format.
    $rid = $this->createRole([$format->getPermissionName()]);
    $this->adminUser->addRole($rid);
    $this->adminUser->save();

    // Go to the mapping form.
    $this->drupalGet('/admin/structure/feeds/manage/' . $feed_type->id() . '/mapping');

    $session = $this->getSession();
    $assert_session = $this->assertSession();
    $page = $session->getPage();

    // Prepare mappings to add.
    $mappings = [
      [
        'target' => 'body',
        'map' => [
          'value' => [
            'value' => 'body',
            'machine_name' => 'body_',
          ],
        ],
        'settings' => ['format' => $format->id()],
      ],
      [
        'target' => 'title',
        'map' => [
          'value' => [
            'value' => 'title',
            'machine_name' => 'title_',
          ],
        ],
      ],
    ];
    $edit = $this->mappingGetEditValues($mappings);

    foreach ($mappings as $i => $mapping) {
      // Add target.
      $assert_session->fieldExists('add_target');
      $page->selectFieldOption('add_target', $mapping['target']);
      $assert_session->assertWaitOnAjaxRequest();

      // Select sources.
      foreach ($mapping['map'] as $key => $source) {
        if (is_array($source)) {
          // Custom source.
          $assert_session->fieldExists("mappings[$i][map][$key][select]");
          $page->selectFieldOption("mappings[$i][map][$key][select]", '__new');
        }
      }
    }

    // Set the form values, including machine name.
    $this->mappingSetMappings($edit);

    // Now set target configuration.
    foreach ($mappings as $i => $mapping) {
      if (!empty($mapping['settings'])) {
        $this->mappingSetTargetConfiguration($i, $mapping['settings']);
      }
    }

    // And submit.
    $submit_button = $assert_session->buttonExists('Save');
    $form = $assert_session->elementExists('xpath', './ancestor::form', $submit_button);
    $this->prepareRequest();
    $submit_button->press();

    // Ensure that any changes to variables in the other thread are picked up.
    $this->refreshVariables();

    // Assert that the mappings and custom sources were successfully added.
    $feed_type = $this->reloadEntity($feed_type);
    $this->assertMappings($mappings, $feed_type);
  }

  /**
   * Tests that custom source names are unique for unsaved mappings.
   */
  public function testCustomSourceUniqueForUnsavedMappings() {
    // Create a feed type with no mappings.
    $feed_type = $this->createFeedTypeForCsv([], [
      'mappings' => [],
    ]);

    // Create a text field called 'alpha'.
    $this->createFieldWithStorage('field_alpha');

    // Create mappings to title, alpha.
    $mappings = [
      [
        'target' => 'title',
        'map' => [
          'value' => [
            'value' => 'title',
            'machine_name' => 'source_1',
          ],
        ],
      ],
      [
        'target' => 'field_alpha',
        'map' => [
          'value' => [
            'value' => 'alpha',
            // Give second source the same name (which is not allowed).
            'machine_name' => 'source_1',
          ],
        ],
      ],
    ];
    $edit = $this->mappingGetEditValues($mappings);

    // Go to the mapping form.
    $this->drupalGet('/admin/structure/feeds/manage/' . $feed_type->id() . '/mapping');

    $session = $this->getSession();
    $assert_session = $this->assertSession();
    $page = $session->getPage();

    foreach ($mappings as $i => $mapping) {
      // Add target.
      $assert_session->fieldExists('add_target');
      $page->selectFieldOption('add_target', $mapping['target']);
      $assert_session->assertWaitOnAjaxRequest();

      // Select sources.
      foreach ($mapping['map'] as $key => $source) {
        if (is_array($source)) {
          // Custom source.
          $assert_session->fieldExists("mappings[$i][map][$key][select]");
          $page->selectFieldOption("mappings[$i][map][$key][select]", '__new');
        }
      }
    }

    // Set the form values, including machine name.
    $this->mappingSetMappings($edit);

    // Try to save the form.
    $this->submitForm($edit, 'Save');

    // Assert that the double source name is detected.
    $assert_session->pageTextContains('The machine-readable name is already in use. It must be unique.');
  }

}
