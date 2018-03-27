<?php
require_once("../model/controller-registry.php");
require_once("../model/default-controller.php");
require_once("../model/lift-controller.php");
require_once("../model/utils.php");

error_reporting(E_ALL);

Utils::adjustQuotes();
Utils::startSession();
Utils::secureConnection();

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

