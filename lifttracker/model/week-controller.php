<?php
require_once("controller.php");
require_once("controller-registry.php");
require_once("week.php");
require_once("week-repository.php");
require_once("week-validator.php");
require_once("user.php");
require_once("utils.php");

class WeekController implements Controller {
  private static $sInst;
  public static function getInstance() {
    if (WeekController::$sInst == null) {
      WeekController::$sInst = new WeekController ();
    }
    return WeekController::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function getName() {
    return "week";
  }
  public function handleRequest() {
    $action = Utils::getArg("action");
    if (!DefaultController::getInstance()->isLoggedIn()) {
      $url = "index.php?controller=default&action=login";
      Utils::redirect($url);
    } else {
      switch ($action) {
        case "weekadd":
          $this->weekAdd();
          break;
        case "weekdelete":
          $this->weekDelete();
          break;
        case "weekedit":
          $this->weekEdit();
          break;
        case "weekprocessaddedit":
          $this->weekProcessAddEdit();
          break;
        default:
          $url = "index.php?controller=default";
          Utils::redirect($url);
          break;
      }
    }
  }
  protected function weekAdd() {
    $planId = Utils::getArg("planid");
    $user = DefaultController::getInstance()->getUser();
    $title = "";
    if ($planId == null) {
      $msg = "No plan ID given.";
    }
    require ("../view/week-add-edit.php");
  }
  protected function weekDelete() {
    $weekId = Utils::getArg("weekid");
    $user = DefaultController::getInstance()->getUser();
    if ($weekId != null) {
      $week = WeekRepository::getInstance()->getWeek($user->getId(), $weekId);
      if ($week != null) {
        WeekRepository::getInstance()->deleteWeeks($user->getId(), array($weekId));
        Utils::redirect("index.php?controller=plan&action=planview&planid=" . $week->getPlanId());
      } else {
        $msg = "Week not found.";
      }
    } else {
      $msg = "No week ID given.";
    }
    require ("../view/message.php");
  }
  protected function weekEdit() {
    $weekId = Utils::getArg("weekid");
    $user = DefaultController::getInstance()->getUser();
    if ($weekId != null) {
      $week = WeekRepository::getInstance()->getWeek($user->getId(), $weekId);
      if ($week != null) {
        $title = $week->getTitle();
      } else {
        $msg = "Week not found.";
      }
    } else {
      $msg = "No week ID given.";
    }
    require("../view/week-add-edit.php");
  }
  protected function weekProcessAddEdit() {
    $msgList = array();
    $planId = Utils::getArg("planid");
    $weekId = Utils::getArg("weekid");
    $title = Utils::getArg("title");
    $user = DefaultController::getInstance()->getUser();
    if ($weekId == null) { //Adding
      $week = new Week();
      $week->setId(0);
      if ($planId != null) {
        $week->setPlanId($planId);
      } else {
        $msgList[] = "No plan ID given.";
      }
    } else { //Updating
      $week = WeekRepository::getInstance()->getWeek($user->getId(), $weekId);
      if ($week == null) {
        $msgList[] = "Week not found.";
      }
    }
    if (count($msgList) == 0) {
      $week->setTitle($title);
      $msgList = array_merge($msgList, WeekValidator::getInstance()->validate($week));
    }
    if (count($msgList) > 0) {
      if ($weekId == null) {
        $msg = "Could not add week";
      } else {
        $msg = "Could not upate week";
      }
    } else {
      if ($weekId == null) {
        if (WeekRepository::getInstance()->addWeek($user->getId(), $week) == null) {
          $msg = "Could not add week";
        } else {
          $title = "";
        }
      } else {
        $rows = WeekRepository::getInstance()->updateWeek($user->getId(), $week);
        if ($rows == 0) {
          $msg = "Could not update week";
        } else {
          Utils::redirect("index.php?controller=plan&action=planview&planid=" . $week->getPlanId());
        }
      }
    }
    require("../view/week-add-edit.php");
  }
}

if (!ControllerRegistry::getInstance()->isRegistered(WeekController::getInstance()->getName())) {
  ControllerRegistry::getInstance()->register(WeekController::getInstance());
}
?>

