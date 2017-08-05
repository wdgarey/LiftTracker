<?php

require_once("controller.php");
require_once("controller-registry.php");
require_once("utils.php");

class DefaultController implements Controller {
  private static $sInst;
  public function getInstance() {
    if ($sInst == null) {
      $sInst = new DefaultController ();
    }
    return $sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function getName() {
    return "DefaultController";
  }
  public function handleRequest() {
    $action = "";
    Utils::adjustQuotes();
    if ($this->getArg("action") != NULL) {
      $action = $this->getArg("action");
    }
    if(!$this->isLoggedIn() && $action != "login" && $action != "loginprocess") {
      $url = "index.php?action=login";
      Utils::redirect($url);
    } else {
      switch ($action) {
      case "login" :
        $this->loginView();
        break;
      case "loginprocess":
        $this->loginProcess();
        break;
      case "logout":
        $this->logout();
        break;
      default:
        Utils::redirect("../index.php");
        break;
      }
    }
  }
  public function isLoggedIn() {
  }
}

if (!ControllerRegistry::getInstance()->isRegistered(DefaultController::getInstance()->getName())) {
  ControllerRegistry::getInstance()->register(DefaultController::getInstance());
}

?>

