<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * BreakType Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class BreakType implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'id' => 'string',
        'location_id' => 'string',
        'break_name' => 'string',
        'expected_duration' => 'string',
        'is_paid' => 'bool',
        'version' => 'int',
        'created_at' => 'string',
        'updated_at' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'id' => 'id',
        'location_id' => 'location_id',
        'break_name' => 'break_name',
        'expected_duration' => 'expected_duration',
        'is_paid' => 'is_paid',
        'version' => 'version',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'id' => 'setId',
        'location_id' => 'setLocationId',
        'break_name' => 'setBreakName',
        'expected_duration' => 'setExpectedDuration',
        'is_paid' => 'setIsPaid',
        'version' => 'setVersion',
        'created_at' => 'setCreatedAt',
        'updated_at' => 'setUpdatedAt'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'id' => 'getId',
        'location_id' => 'getLocationId',
        'break_name' => 'getBreakName',
        'expected_duration' => 'getExpectedDuration',
        'is_paid' => 'getIsPaid',
        'version' => 'getVersion',
        'created_at' => 'getCreatedAt',
        'updated_at' => 'getUpdatedAt'
    );
  
    /**
      * $id UUID for this object.
      * @var string
      */
    protected $id;
    /**
      * $location_id The ID of the business location this type of break applies to.
      * @var string
      */
    protected $location_id;
    /**
      * $break_name A human-readable name for this type of break. Will be displayed to employees in Square products.
      * @var string
      */
    protected $break_name;
    /**
      * $expected_duration Format: RFC-3339 P[n]Y[n]M[n]DT[n]H[n]M[n]S. The expected length of this break. Precision below minutes is truncated.
      * @var string
      */
    protected $expected_duration;
    /**
      * $is_paid Whether this break counts towards time worked for compensation purposes.
      * @var bool
      */
    protected $is_paid;
    /**
      * $version Used for resolving concurrency issues; request will fail if version provided does not match server version at time of request. If a value is not provided, Square's servers execute a \"blind\" write; potentially  overwriting another writer's data.
      * @var int
      */
    protected $version;
    /**
      * $created_at A read-only timestamp in RFC 3339 format.
      * @var string
      */
    protected $created_at;
    /**
      * $updated_at A read-only timestamp in RFC 3339 format.
      * @var string
      */
    protected $updated_at;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initializing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            if (isset($data["id"])) {
              $this->id = $data["id"];
            } else {
              $this->id = null;
            }
            if (isset($data["location_id"])) {
              $this->location_id = $data["location_id"];
            } else {
              $this->location_id = null;
            }
            if (isset($data["break_name"])) {
              $this->break_name = $data["break_name"];
            } else {
              $this->break_name = null;
            }
            if (isset($data["expected_duration"])) {
              $this->expected_duration = $data["expected_duration"];
            } else {
              $this->expected_duration = null;
            }
            if (isset($data["is_paid"])) {
              $this->is_paid = $data["is_paid"];
            } else {
              $this->is_paid = null;
            }
            if (isset($data["version"])) {
              $this->version = $data["version"];
            } else {
              $this->version = null;
            }
            if (isset($data["created_at"])) {
              $this->created_at = $data["created_at"];
            } else {
              $this->created_at = null;
            }
            if (isset($data["updated_at"])) {
              $this->updated_at = $data["updated_at"];
            } else {
              $this->updated_at = null;
            }
        }
    }
    /**
     * Gets id
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
  
    /**
     * Sets id
     * @param string $id UUID for this object.
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * Gets location_id
     * @return string
     */
    public function getLocationId()
    {
        return $this->location_id;
    }
  
    /**
     * Sets location_id
     * @param string $location_id The ID of the business location this type of break applies to.
     * @return $this
     */
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
        return $this;
    }
    /**
     * Gets break_name
     * @return string
     */
    public function getBreakName()
    {
        return $this->break_name;
    }
  
    /**
     * Sets break_name
     * @param string $break_name A human-readable name for this type of break. Will be displayed to employees in Square products.
     * @return $this
     */
    public function setBreakName($break_name)
    {
        $this->break_name = $break_name;
        return $this;
    }
    /**
     * Gets expected_duration
     * @return string
     */
    public function getExpectedDuration()
    {
        return $this->expected_duration;
    }
  
    /**
     * Sets expected_duration
     * @param string $expected_duration Format: RFC-3339 P[n]Y[n]M[n]DT[n]H[n]M[n]S. The expected length of this break. Precision below minutes is truncated.
     * @return $this
     */
    public function setExpectedDuration($expected_duration)
    {
        $this->expected_duration = $expected_duration;
        return $this;
    }
    /**
     * Gets is_paid
     * @return bool
     */
    public function getIsPaid()
    {
        return $this->is_paid;
    }
  
    /**
     * Sets is_paid
     * @param bool $is_paid Whether this break counts towards time worked for compensation purposes.
     * @return $this
     */
    public function setIsPaid($is_paid)
    {
        $this->is_paid = $is_paid;
        return $this;
    }
    /**
     * Gets version
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }
  
    /**
     * Sets version
     * @param int $version Used for resolving concurrency issues; request will fail if version provided does not match server version at time of request. If a value is not provided, Square's servers execute a \"blind\" write; potentially  overwriting another writer's data.
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }
    /**
     * Gets created_at
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
  
    /**
     * Sets created_at
     * @param string $created_at A read-only timestamp in RFC 3339 format.
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }
    /**
     * Gets updated_at
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
  
    /**
     * Sets updated_at
     * @param string $updated_at A read-only timestamp in RFC 3339 format.
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset 
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }
  
    /**
     * Gets offset.
     * @param  integer $offset Offset 
     * @return mixed 
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }
  
    /**
     * Sets value based on offset.
     * @param  integer $offset Offset 
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }
  
    /**
     * Unsets offset.
     * @param  integer $offset Offset 
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
  
    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        } else {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this));
        }
    }
}
