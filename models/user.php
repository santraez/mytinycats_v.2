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
  public $confirmPassword;
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
    $this->confirmPassword = $args['confirmPassword'] ?? '';
    $this->admin = $args['admin'] ?? '0';
    $this->confirmed = $args['confirmed'] ?? '0';
    $this->token = $args['token'] ?? '';
    $this->created = $args['created'] ?? '';
  }
  // VALIDATIONS MESSAGES
  public function validateNewAccount() {
    if(!$this->display) {
      self::$alerts['error'][] = 'Display name is required';
    }
    if(!$this->email) {
      self::$alerts['error'][] = 'Email is required';
    }
    if(!$this->password) {
      self::$alerts['error'][] = 'Password is required';
    }
    if($this->password) {
      if(strlen($this->password) < 8) {
        self::$alerts['error'][] = 'Password must be at least 8 characters';
      }
    }
    if($this->password && !$this->confirmPassword && (strlen($this->password) >= 8)) {
      self::$alerts['error'][] = 'Confirm password is required';
    }
    if($this->password && $this->confirmPassword && (strlen($this->password) >= 8))  {
      if($this->password !== $this->confirmPassword) {
        self::$alerts['error'][] = 'Passwords do not match';
      }
    }
    return self::$alerts;
  }
  // VALIDATE LOGIN
  public function validateLogin() {
    if(!$this->email) {
      self::$alerts['error'][] = 'email is required';
    }
    if(!$this->password) {
      self::$alerts['error'][] = 'password is required';
    }
    return self::$alerts;
  }
  // VALIDATE EMAIL
  public function validateEmail() {
    if(!$this->email) {
      self::$alerts['error'][] = 'email is required';
    }
    return self::$alerts;
  }
  public function validatePassword() {
    if(!$this->password) {
      self::$alerts['error'][] = 'Password is required';
    }
    if($this->password && strlen($this->password) < 8) {
      self::$alerts['error'][] = 'Password must be at least 8 characters';
    }
    return self::$alerts;
  }
  // CHECK IF USER EXISTS
  public function validateUser() {
    $query = "SELECT * FROM " . self::$table . " WHERE email = '" . $this->email . "' LIMIT 1";
    $result = self::$db->query($query);
    if ($result->num_rows) {
      self::$alerts['error'][] = 'EMAIL ALREADY EXIST';
    }
    return $result;
  }
  public function hashPassword() {
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }
  public function createToken() {
    $this->token = uniqid();
  }
  public function checkPasswordAndVerified($password) {
    $result = password_verify($password, $this->password);
    if(!$result || !$this->confirmed) {
      self::$alerts['error'][] = 'Incorrect Password or your account is not confirmed';
    } else {
      return true;
    }
  }
}