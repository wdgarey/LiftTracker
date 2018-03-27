<?php
require_once("controller.php");

class ControllerRegistry {
  private static $sRegistry = array();
  public static function getInstance() {
    static $inst = null;
    if ($inst == null) {
      $inst = new ControllerRegistry();
    }
    return $inst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function isRegistered($name) {
    $registered = array_key_exists($name, ControllerRegistry::$sRegistry);
    return $registered;
  }
  public function register($controller) {
    $name = $controller->getName();
    if ($this->isRegistered($name)) {
      throw new Exception("The controller '$name' is already registered.");
    } else {
      ControllerRegistry::$sRegistry[$name] = $controller;
    }
  }
  public function get($name) {
    $controller = null;
    if ($this->isRegistered($name)) {
      $controller = ControllerRegistry::$sRegistry[$name];
    }
    return $controller;
  }
}
?>

