<?php
require_once("controller.php");

class ControllerRegistry {
  private static $sInst = null;
  public static function getInstance() {
    if (ControllerRegistry::$sInst == null) {
      ControllerRegistry::$sInst = new ControllerRegistry();
    }
    return ControllerRegistry::$sInst;
  }
  private $mRegistry;
  protected function getRegistry() {
    return $this->mRegistry;
  }
  protected function setRegistry($registry) {
    $this->mRegistry = $registry;
  }
  private function __construct() {
    $this->mRegistry = array();
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function isRegistered($name) {
    $registry = $this->getRegistry ();
    $registered = array_key_exists($name, $registry);
    return $registered;
  }
  public function register($controller) {
    $name = $controller->getName ();
    $registry = $this->getRegistry ();
    if ($this->isRegistered($name)) {
      throw new Exception("The controller '$name' is already registered.");
    } else {
      $registry[$name] = $controller;
    }
  }
  public function get($name) {
    $controller = null;
    if ($this->isRegistered($name)) {
      $registry = $this->getRegistry ();
      $controller = $registry[$name];
    }
    return $controller;
  }
}
?>

