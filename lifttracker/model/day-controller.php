<?php
require_once("controller.php");
require_once("controller-registry.php");
require_once("day.php");
require_once("day-repository.php");
require_once("week-repository.php");
require_once("day-validator.php");
require_once("user.php");
require_once("utils.php");

class DayController implements Controller {
  private static $sInst;
  public static function getInstance() {
    if (DayController::$sInst == null) {
      DayController::$sInst = new DayController ();
    }
    return DayController::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function getName() {
    return "day";
  }
  public function handleRequest() {
    $action = Utils::getArg("action");
    if (!DefaultController::getInstance()->isLoggedIn()) {
      $url = "index.php?controller=default&action=login";
      Utils::redirect($url);
    } else {
      switch ($action) {
        case "dayadd":
          $this->dayAdd();
          break;
        case "daydelete":
          $this->dayDelete();
          break;
        case "dayedit":
          $this->dayEdit();
          break;
        case "dayprocessaddedit":
          $this->dayProcessAddEdit();
          break;
        default:
          $url = "index.php?controller=default";
          Utils::redirect($url);
          break;
      }
    }
  }
  protected function dayAdd() {
    $weekId = Utils::getArg("weekid");
    $user = DefaultController::getInstance()->getUser();
    $title = "";
    if ($weekId == null) {
      $msg = "No week ID given.";
    }
    require ("../view/day-add-edit.php");
  }
  protected function dayDelete() {
    $dayId = Utils::getArg("dayid");
    $user = DefaultController::getInstance()->getUser();
    if ($dayId != null) {
      $day = DayRepository::getInstance()->getDay($user->getId(), $dayId);
      if ($day != null) {
        $planId = DayRepository::getInstance()->getPlanId($user->getId(), $dayId);
        DayRepository::getInstance()->deleteDays($user->getId(), array($dayId));
        Utils::redirect("index.php?controller=plan&action=planview&planid=" . $planId);
      } else {
        $msg = "Day not found.";
      }
    } else {
      $msg = "No day ID given.";
    }
    require ("../view/message.php");
  }
  protected function dayEdit() {
    $dayId = Utils::getArg("dayid");
    $user = DefaultController::getInstance()->getUser();
    if ($dayId != null) {
      $day = DayRepository::getInstance()->getDay($user->getId(), $dayId);
      if ($day != null) {
        $title = $day->getTitle();
      } else {
        $msg = "Day not found.";
      }
    } else {
      $msg = "No day ID given.";
    }
    require("../view/day-add-edit.php");
  }
  protected function dayProcessAddEdit() {
    $msgList = array();
    $weekId = Utils::getArg("weekid");
    $dayId = Utils::getArg("dayid");
    $title = Utils::getArg("title");
    $user = DefaultController::getInstance()->getUser();
    if ($dayId == null) { //Adding
      $day = new Day();
      $day->setId(0);
      if ($weekId != null) {
        $day->setWeekId($weekId);
      } else {
        $msgList[] = "No week ID given.";
      }
    } else { //Updating
      $day = DayRepository::getInstance()->getDay($user->getId(), $dayId);
      if ($day == null) {
        $msgList[] = "Day not found.";
      }
    }
    if (count($msgList) == 0) {
      $day->setTitle($title);
      $msgList = array_merge($msgList, DayValidator::getInstance()->validate($day));
    }
    if (count($msgList) > 0) {
      if ($dayId == null) {
        $msg = "Could not add day";
      } else {
        $msg = "Could not update day";
      }
    } else {
      $week = WeekRepository::getInstance()->getWeek($user->getId(), $weekId);
      if ($week != null) {
        $planId = $week->getPlanId();
      }
      if ($dayId == null) {
        if (DayRepository::getInstance()->addDay($user->getId(), $day) == null) {
          $msg = "Could not add day";
        } else {
          $title = "";
        }
      } else {
        $rows = DayRepository::getInstance()->updateDay($user->getId(), $day);
        if ($rows == 0) {
          $msg = "Could not update day";
        } else {
          Utils::redirect("index.php?controller=plan&action=planview&planid=" . $planId);
        }
      }
    }
    require("../view/day-add-edit.php");
  }
}

if (!ControllerRegistry::getInstance()->isRegistered(DayController::getInstance()->getName())) {
  ControllerRegistry::getInstance()->register(DayController::getInstance());
}
?>

