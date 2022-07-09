<?php
namespace Model;
class User extends ActiveRecord {
  // DATABASE
  protected static $table = 'users';
  protected static $columnsDB = ['id', 'display', 'email', 'password', 'admin', 'confirmed', 'token', 'created'];
  // ATTRIBUTES
  public $id;
  public $display;
  public $email;
  public $password;
  public $admin;
  public $confirmed;
  public $token;
  public $created;
  // CONSTRUCTOR
  public function __construct($args=[]) {
    $this->id = $args['id'] ?? null;
    $this->display = $args['display'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->admin = $args['admin'] ?? null;
    $this->confirmed = $args['confirmed'] ?? null;
    $this->token = $args['token'] ?? '';
    $this->created = $args['created'] ?? '';
  }
  // VALIDATIONS MESSAGES
  public function validateNewAccount() {
    if(!$this->display) {
      self::$alerts['error'][] = 'Display name is required';
    }
    return self::$alerts;
  }
}