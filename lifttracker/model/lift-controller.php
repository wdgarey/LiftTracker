<?php
require_once("controller.php");
require_once("controller-registry.php");
require_once("lift-repository.php");
require_once("password-validator.php");
require_once("user.php");
require_once("user-validator.php");
require_once("utils.php");

class LiftController implements Controller {
  private static $sInst;
  public static function getInstance() {
    if (LiftController::$sInst == null) {
      LiftController::$sInst = new LiftController ();
    }
    return LiftController::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function getName() {
    return "lift";
  }
  public function handleRequest() {
    $action = Utils::getArg("action");
    if (!$this->isLoggedIn()) {
      $url = "index.php?controller=default&action=login";
      Utils::redirect($url);
    } else {
      switch ($action) {
      case "liftadd":
        $this->liftAdd();
        break;
      case "liftdelete":
        $this->liftDelete();
        break;
      case "liftedit":
        $this->liftEdit();
        break;
      case "liftprocessaddedit":
        $this->liftProcessAddEdit();
        break;
      case "liftview":
        $this->liftView();
        break;
      case "liftsview":
        $this->liftsView();
        break;
      default:
        $url = "index.php?controller=default";
        Utils::redirect($url);
        break;
      }
    }
  }
  protected function liftAdd() {
    $title = "";
    $trainingWeight = "";
    require ("../view/lift-add-edit.php");
  }
  protected function liftDelete() {
    $liftId = Utils::getArg("liftid");
    $liftIds = Utils::getArg("liftids");
    $user = DefaultController::getInstance()->getUser();
    if ($liftid != null) {
      LiftRepository::getInstance()->deleteLifts($user->getId(), array($liftId));
    } else if ($liftIds != null) {
      LiftRepository::getInstance()->deleteLifts($user->getId(), $lifIds);
    } else {
      $msg = "No lift ID given.";
    }
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    require ("../view/lifts-view.php");
  }
  protected function liftEdit() {
    // Get the lift, and then update the variables
    $title = "";
    $trainingWeight = "";
    $liftId = Utils::getArg("liftid");
    $user = DefaultController::getInstance()->getUser();
    if ($liftId != null) {
      $lift = LiftRepository::getInstance()->getLift($user->getId(), $liftId);
      if ($lift != null) {
        $title = $lift->getTitle();
        $traningWeight = $lift->getTrainingWeight();
      } else {
        $msg = "Lift not found.";
      }
    } else {
      $msg = "No lift ID given.";
    }
    require("../view/lift-add-edit.php");
  }
  protected function liftProcessAddEdit() {
    $liftId = Utils::getArg("liftid");
    $title = Utils::getArg("title");
    $trainingWeight = Utils::getArg("trainingweight");
    if ($liftId == null) { //Adding
      if (LiftRepository::getInstance->isExistingLift($user->getId(), $title)) {
        $msgList[] = "The lift, \"$title\", already exists."
      } else {
        $lift = new Lift();
        $lift->setId(0);
      }
    } else { //Updating
      $lift = LiftRepository::getInstance->getLift($user->getId(), $liftId);
    }
    $lift->setTitle($title);
    $lift->setTrainingWeight($trainingWeight);
    if (count($msgList) == 0) {
      $msgList = array_merge($msgList, LiftValidator::getInstance->validate($lift));
    }
    if (count($msgList) > 0) {
      if ($liftId == null) {
        $msg = "Could not add lift";
      } else {
        $msg = "Could not upate lift";
      }
    } else {
      if ($liftId == null) {
        $liftId = LiftRepository::getInstance()->addLift($user->getId(), $lift);
        if ($liftId == null) {
          $msg = "Could not add lift - try again later";
        } else {
          Utils::redirect("index.php?controller=lift&action=liftview&liftid=$lift->getId()");
        }
      } else {
        $updatedLifts = LiftRepository::getInstance()->updateLift($user->getId(), $lift);
        if (updatedLifts != 1) {
          $msg = "Could not upate lift - try again later";
        } else {
          Utils::redirect("index.php?controller=lift&action=liftview&liftid=$lift->getId()");
        }
      }
    }
    require("../view/lift-add-edit.php");
  }
  public function liftView() {
    $title = "";
    $trainingWeight = "";
    $liftId = Utils::getArg("liftid");
    $user = DefaultController::getInstance()->getUser();
    if ($liftId != null) {
      $lift = LiftRepository::getInstance()->getLift($user->getId(), $liftId);
      if ($lift != null) {
        $title = $lift->getTitle();
        $traningWeight = $lift->getTrainingWeight();
      } else {
        $msg = "Lift not found.";
      }
    } else {
      $msg = "No lift ID given.";
    }
    require("../view/lift-view.php");
  }
  public function liftsView() {
    $user = DefaultController::getInstance()->getUser();
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    require ("../view/lifts-view.php");
  }
}

if (!ControllerRegistry::getInstance()->isRegistered(LiftController::getInstance()->getName())) {
  ControllerRegistry::getInstance()->register(LiftController::getInstance());
}
?>

