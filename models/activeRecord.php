<?php
namespace Model;
class ActiveRecord {
  protected static $db;
  protected static $table = '';
  protected static $columnsDB = [];
  protected static $alerts = [];
  public static function setDB($database) {
    self::$db = $database;
  }
  public static function setAlert($type, $message) {
    static::$alerts[$type][] = $message;
  }
  public static function getAlerts() {
    return static::$alerts;
  }
  public function validate() {
    static::$alerts = [];
    return static::$alerts;
  }
  public static function consultSQL($query) {
    $result = self::$db->query($query);
    $array = [];
    while($record = $result->fetch_assoc()) {
      $array[] = static::createObject($record);
    }
    $result->free();
    return $array;
  }
  protected static function createObject($record) {
    $object = new static;
    foreach($record as $key => $value ) {
      if(property_exists( $object, $key  )) {
        $object->$key = $value;
      }
    }
    return $object;
  }
  public function attributes() {
    $attributes = [];
    foreach(static::$columnsDB as $column) {
      if($column === 'id') continue;
      $attributes[$column] = $this->$column;
    }
    return $attributes;
  }
  public function sanitizeAttributes() {
    $attributes = $this->attributes();
    $sanitized = [];
    foreach($attributes as $key => $value ) {
      $sanitized[$key] = self::$db->escape_string($value);
    }
    return $sanitized;
  }
  public function sync($args=[]) { 
    foreach($args as $key => $value) {
      if(property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }
  public function save() {
    $result = '';
    if(!is_null($this->id)) {
      $result = $this->update();
    } else {
      $result = $this->create();
    }
    return $result;
  }
  public static function all() {
    $query = "SELECT * FROM " . static::$table;
    $result = self::consultSQL($query);
    return $result;
  }
  public static function find($id) {
    $query = "SELECT * FROM " . static::$table  ." WHERE id = ${id}";
    $result = self::consultSQL($query);
    return array_shift($result) ;
  }
  public static function get($limit) {
    $query = "SELECT * FROM " . static::$table . " LIMIT ${limit}";
    $result = self::consultSQL($query);
    return array_shift($result) ;
  }
  public static function where($column, $value) {
    $query = "SELECT * FROM " . static::$table  ." WHERE ${column} = '${value}'";
    $result = self::consultSQL($query);
    return array_shift($result) ;
  }
  public static function SQL($query) {
    $result = self::consultSQL($query);
    return $result;
  }
  public function create() {
    $attributes = $this->sanitizeAttributes();
    $query = " INSERT INTO " . static::$table . " ( ";
    $query .= join(', ', array_keys($attributes));
    $query .= " ) VALUES (' "; 
    $query .= join("', '", array_values($attributes));
    $query .= " ') ";
    $result = self::$db->query($query);
    return [
      'result' =>  $result,
      'id' => self::$db->insert_id
    ];
  }
  public function update() {
    $atributos = $this->sanitizeAttributes();
    $values = [];
    foreach($attributes as $key => $value) {
      $values[] = "{$key}='{$value}'";
    }
    $query = "UPDATE " . static::$table ." SET ";
    $query .=  join(', ', $values );
    $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
    $query .= " LIMIT 1 "; 
    $result = self::$db->query($query);
    return $result;
  }
  public function delete() {
    $query = "DELETE FROM " . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
    $result = self::$db->query($query);
    return $result;
  }
}