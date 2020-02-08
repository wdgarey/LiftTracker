<?php
require_once("controller.php");
require_once("controller-registry.php");
require_once("lift.php");
require_once("lift-repository.php");
require_once("lift-validator.php");
require_once("user.php");
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
    if (!DefaultController::getInstance()->isLoggedIn()) {
      $url = "index.php?controller=default&action=login&uri=" . urlencode(Utils::getRequestedUri());
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
        case "liftsedit":
          $this->liftsEdit();
          break;
        case "liftsprocessedit":
          $this->liftsProcessEdit();
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
    if ($liftId != null) {
      LiftRepository::getInstance()->deleteLifts($user->getId(), array($liftId));
    } else if ($liftIds != null) {
      LiftRepository::getInstance()->deleteLifts($user->getId(), $liftIds);
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
        $trainingWeight = $lift->getTrainingWeight();
      } else {
        $msg = "Lift not found.";
      }
    } else {
      $msg = "No lift ID given.";
    }
    require("../view/lift-add-edit.php");
  }
  protected function liftProcessAddEdit() {
    $msgList = array();
    $liftId = Utils::getArg("liftid");
    $title = Utils::getArg("title");
    $trainingWeight = Utils::getArg("trainingweight");
    $user = DefaultController::getInstance()->getUser();
    if ($liftId == null) { //Adding
      if (LiftRepository::getInstance()->isExistingLift($user->getId(), $title)) {
        $msgList[] = "The lift, \"$title\", already exists.";
      } else {
        $lift = new Lift();
        $lift->setId(0);
      }
    } else { //Updating
      $lift = LiftRepository::getInstance()->getLift($user->getId(), $liftId);
    }
    $lift->setTitle($title);
    $lift->setTrainingWeight($trainingWeight);
    if (count($msgList) == 0) {
      $msgList = array_merge($msgList, LiftValidator::getInstance()->validate($lift));
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
        Utils::redirect("index.php?controller=lift&action=liftview&liftid=" . $liftId);
      } else {
        LiftRepository::getInstance()->updateLift($user->getId(), $lift);
        Utils::redirect("index.php?controller=lift&action=liftview&liftid=" . $lift->getId());
      }
    }
    require("../view/lift-add-edit.php");
  }
  public function liftView() {
    $title = "";
    $attempts = array();
    $trainingWeight = "";
    $liftId = Utils::getArg("liftid");
    $user = DefaultController::getInstance()->getUser();
    if ($liftId != null) {
      $lift = LiftRepository::getInstance()->getLift($user->getId(), $liftId);
      if ($lift != null) {
        $title = $lift->getTitle();
        $trainingWeight = $lift->getTrainingWeight();
        $attempts = AttemptRepository::getInstance()->getAttemptsLift($user->getId(), $liftId);
        $liftTitles["$liftId"] = $title;
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
  public function liftsEdit() {
    $user = DefaultController::getInstance()->getUser();
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    require ("../view/lifts-edit.php");
  }
  public function liftsProcessEdit() {
    $msgList = array();
    $val = Utils::getArg("val");
    $user = DefaultController::getInstance()->getUser();
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    foreach ($lifts as $lift) {
      if (Utils::getArg("lift" . $lift->getId()) != null) {
        if (Utils::getArg("add") != null) {
          $lift->setTrainingWeight($lift->getTrainingWeight() + $val);
          $msgList = array_merge($msgList, LiftValidator::getInstance()->validate($lift));
          if (count($msgList) > 0) {
            break;
          }
          LiftRepository::getInstance()->updateLift($user->getId(), $lift);
        } else if (Utils::getArg("subtract") != null) {
          $lift->setTrainingWeight($lift->getTrainingWeight() - $val);
          $msgList = array_merge($msgList, LiftValidator::getInstance()->validate($lift));
          if (count($msgList) > 0) {
            break;
          }
          LiftRepository::getInstance()->updateLift($user->getId(), $lift);
        } else if (Utils::getArg("multiply") != null) {
          $lift->setTrainingWeight($lift->getTrainingWeight() * $val);
          $msgList = array_merge($msgList, LiftValidator::getInstance()->validate($lift));
          if (count($msgList) > 0) {
            break;
          }
          LiftRepository::getInstance()->updateLift($user->getId(), $lift);
        } else {
          $msgList[] = "No action given";
          break;
        }
      }
    }
    if (count($msgList) > 0) {
      $msg = "Could not update lifts";
    } else {
      Utils::redirect("index.php?controller=lift&action=liftsedit");
    }
    require ("../view/lifts-edit.php");
  }
}

if (!ControllerRegistry::getInstance()->isRegistered(LiftController::getInstance()->getName())) {
  ControllerRegistry::getInstance()->register(LiftController::getInstance());
}
?>

