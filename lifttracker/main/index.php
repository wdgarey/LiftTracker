<?php
require_once("../model/controller-registry.php");
require_once("../model/default-controller.php");
require_once("../model/utils.php");

error_reporting(E_ALL);

$controller = null;
$name = Utils::getArg("controller");
if ($name != null) {
  $controller = ControllerRegistry::getInstance()->get($name);
}
if ($controller == null) {
  $controller = DefaultController::getInstance();
}
$controller->handleRequest();
?>

