<?php
require_once("controller.php");
require_once("controller-registry.php");
require_once("set.php");
require_once("set-repository.php");
require_once("set-validator.php");
require_once("exercise-repository.php");
require_once("user.php");
require_once("utils.php");

class SetController implements Controller {
  private static $sInst;
  public static function getInstance() {
    if (SetController::$sInst == null) {
      SetController::$sInst = new SetController ();
    }
    return SetController::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function getName() {
    return "set";
  }
  public function handleRequest() {
    $action = Utils::getArg("action");
    if (!DefaultController::getInstance()->isLoggedIn()) {
      $url = "index.php?controller=default&action=login";
      Utils::redirect($url);
    } else {
      switch ($action) {
        case "setadd":
          $this->setAdd();
          break;
        case "setdelete":
          $this->setDelete();
          break;
        case "setedit":
          $this->setEdit();
          break;
        case "setprocessaddedit":
          $this->setProcessAddEdit();
          break;
        default:
          $url = "index.php?controller=default";
          Utils::redirect($url);
          break;
      }
    }
  }
  protected function setAdd() {
    $exerciseId = Utils::getArg("exerciseid");
    $user = DefaultController::getInstance()->getUser();
    $title = "";
    $reps = "";
    $percent = "";
    if ($exerciseId == null) {
      $msg = "No exercise ID given.";
    }
    require ("../view/set-add-edit.php");
  }
  protected function setDelete() {
    $setId = Utils::getArg("setid");
    $user = DefaultController::getInstance()->getUser();
    if ($setId != null) {
      $set = SetRepository::getInstance()->getSet($user->getId(), $setId);
      if ($set != null) {
        $planId = SetRepository::getInstance()->getPlanId($user->getId(), $setId);
        SetRepository::getInstance()->deleteSets($user->getId(), array($setId));
        Utils::redirect("index.php?controller=plan&action=planview&planid=" . $planId);
      } else {
        $msg = "Set not found.";
      }
    } else {
      $msg = "No set ID given.";
    }
    require ("../view/message.php");
  }
  protected function setEdit() {
    $setId = Utils::getArg("setid");
    $user = DefaultController::getInstance()->getUser();
    $title = "";
    $reps = "";
    $percent = "";
    if ($setId != null) {
      $set = SetRepository::getInstance()->getSet($user->getId(), $setId);
      if ($set != null) {
        $title = $set->getTitle();
        $reps = $set->getReps();
        $percent = $set->getPercent() * 100.0;
      } else {
        $msg = "Set not found.";
      }
    } else {
      $msg = "No set ID given.";
    }
    require("../view/set-add-edit.php");
  }
  protected function setProcessAddEdit() {
    $msgList = array();
    $exerciseId = Utils::getArg("exerciseid");
    $setId = Utils::getArg("setid");
    $title = Utils::getArg("title");
    $reps = Utils::getArg("reps");
    $percent = Utils::getArg("percent");
    $user = DefaultController::getInstance()->getUser();
    if ($setId == null) { //Adding
      $set = new Set();
      $set->setId(0);
      if ($exerciseId != null) {
        $set->setExerciseId($exerciseId);
      } else {
        $msgList[] = "No exercise ID given.";
      }
    } else { //Updating
      $set = SetRepository::getInstance()->getSet($user->getId(), $setId);
      if ($set == null) {
        $msgList[] = "Set not found.";
      }
    }
    if (count($msgList) == 0) {
      $set->setTitle($title);
      $set->setReps($reps);
      $set->setPercent($percent / 100.0);
      $msgList = array_merge($msgList, SetValidator::getInstance()->validate($set));
    }
    if (count($msgList) > 0) {
      if ($setId == null) {
        $msg = "Could not add set";
      } else {
        $msg = "Could not update set";
      }
    } else {
      $planId = ExerciseRepository::getInstance()->getPlanId($user->getId(), $exerciseId);
      if ($setId == null) {
        if (SetRepository::getInstance()->addSet($user->getId(), $set) == null) {
          $msg = "Could not add set";
        } else {
          $title = "";
          $reps = "";
          $percent = "";
        }
      } else {
        $rows = SetRepository::getInstance()->updateSet($user->getId(), $set);
        if ($rows == 0) {
          $msg = "Could not update set";
        } else {
          Utils::redirect("index.php?controller=plan&action=planview&planid=" . $planId);
        }
      }
    }
    require("../view/set-add-edit.php");
  }
}

if (!ControllerRegistry::getInstance()->isRegistered(SetController::getInstance()->getName())) {
  ControllerRegistry::getInstance()->register(SetController::getInstance());
}
?>

