<?php

class ControllerRegistry {
  private static $sInst = null;
  public static function getInstance() {
    if ($sInst == null) {
      $sInst = new ControllerRegistry() {
    }
    return $sInst;
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
    $registered = array_key_exists($key, $registry);
    return $registered;
  }
  public function register($controller) {
    $key = $controller->getName ();
    $registry = $this->getRegistry ();
    if ($this->isRegistered($key)) {
      throw new Exception("The controller '$key' is already registered.");
    } else {
      $registry[$key] = $controller;
    }
  }
}

?>

