<?php
require_once("controller.php");
require_once("controller-registry.php");
require_once("attempt.php");
require_once("attempt-repository.php");
require_once("attempt-validator.php");
require_once("user.php");
require_once("utils.php");

class AttemptController implements Controller {
  private static $sInst;
  public static function getInstance() {
    if (AttemptController::$sInst == null) {
      AttemptController::$sInst = new AttemptController ();
    }
    return AttemptController::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function getName() {
    return "attempt";
  }
  public function handleRequest() {
    $action = Utils::getArg("action");
    if (!DefaultController::getInstance()->isLoggedIn()) {
      $url = "index.php?controller=default&action=login";
      Utils::redirect($url);
    } else {
      switch ($action) {
        case "attemptadd":
          $this->attemptAdd();
          break;
        case "attemptdelete":
          $this->attemptDelete();
          break;
        case "attemptedit":
          $this->attemptEdit();
          break;
        case "attemptprocessaddedit":
          $this->attemptProcessAddEdit();
          break;
        case "attemptview":
          $this->attemptView();
          break;
        case "attemptsview":
          $this->attemptsView();
          break;
        default:
          $url = "index.php?controller=default";
          Utils::redirect($url);
          break;
      }
    }
  }
  protected function attemptAdd() {
    $liftId = Utils::getArg("liftid");
    $occurrence = date("Y-m-d");
    $weight = "";
    $reps = "";
    $user = DefaultController::getInstance()->getUser();
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    require ("../view/attempt-add-edit.php");
  }
  protected function attemptDelete() {
    $liftTitles = array();
    $attemptId = Utils::getArg("attemptid");
    $attemptIds = Utils::getArg("attemptids");
    $user = DefaultController::getInstance()->getUser();
    if ($attemptId != null) {
      AttemptRepository::getInstance()->deleteAttempts($user->getId(), array($attemptId));
    } else if ($attemptIds != null) {
      AttemptRepository::getInstance()->deleteAttempts($user->getId(), $attemptIds);
    } else {
      $msg = "No attempt ID given.";
    }
    $attempts = AttemptRepository::getInstance()->getAttemptsUser($user->getId());
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    foreach ($lifts as $lift) {
      $liftId = $lift->getId();
      $liftTitles["$liftId"] = $lift->getTitle();
    }
    require ("../view/attempts-view.php");
  }
  protected function attemptEdit() {
    $liftId = "";
    $occurrence = "";
    $weight = "";
    $reps = "";
    $attemptId = Utils::getArg("attemptid");
    $user = DefaultController::getInstance()->getUser();
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    if ($attemptId != null) {
      $attempt = AttemptRepository::getInstance()->getAttempt($user->getId(), $attemptId);
      if ($attempt != null) {
        $liftId = $attempt->getLiftId();
        $occurrence = $attempt->getOccurrence();
        $weight = $attempt->getWeight();
        $reps = $attempt->getReps();
      } else {
        $msg = "Attempt not found.";
      }
    } else {
      $msg = "No attempt ID given.";
    }
    require("../view/attempt-add-edit.php");
  }
  protected function attemptProcessAddEdit() {
    $msgList = array();
    $attemptId = Utils::getArg("attemptid");
    $liftId = Utils::getArg("liftid");
    $occurrence = Utils::getArg("occurrence");
    $weight = Utils::getArg("weight");
    $reps = Utils::getArg("reps");
    $user = DefaultController::getInstance()->getUser();
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    if ($attemptId == null) { //Adding
      $attempt = new Attempt();
      $attempt->setId(0);
    } else { //Updating
      $attempt = AttemptRepository::getInstance()->getAttempt($user->getId(), $attemptId);
      if ($attempt == null) {
        $msgList[] = "Attempt not found.";
      }
    }
    if ($liftId == null) {
      $msgList[] = "No lift ID given.";
    } else if (LiftRepository::getInstance()->getLift($user->getId(), $liftId) == null) {
      $msgList[] = "The lift does not exist.";
    }
    if (count($msgList) == 0) {
      $attempt->setLiftId($liftId);
      $attempt->setOccurrence($occurrence);
      $attempt->setWeight($weight);
      $attempt->setReps($reps);
      $msgList = array_merge($msgList, AttemptValidator::getInstance()->validate($attempt));
    }
    if (count($msgList) > 0) {
      if ($attemptId == null) {
        $msg = "Could not add attempt";
      } else {
        $msg = "Could not upate attempt";
      }
    } else {
      if ($attemptId == null) {
        $attemptId = AttemptRepository::getInstance()->addAttempt($attempt);
        Utils::redirect("index.php?controller=attempt&action=attemptview&attemptid=" . $attemptId);
      } else {
        AttemptRepository::getInstance()->updateAttempt($user->getId(), $attempt);
        Utils::redirect("index.php?controller=attempt&action=attemptview&attemptid=" . $attempt->getId());
      }
    }
    require("../view/attempt-add-edit.php");
  }
  public function attemptView() {
    $liftId = "";
    $liftTitle = "";
    $occurrence = "";
    $weight = "";
    $reps = "";
    $attemptId = Utils::getArg("attemptid");
    $user = DefaultController::getInstance()->getUser();
    if ($attemptId != null) {
      $attempt = AttemptRepository::getInstance()->getAttempt($user->getId(), $attemptId);
      if ($attempt != null) {
        $liftId = $attempt->getLiftId();
        $lift = LiftRepository::getInstance()->getLift($user->getId(), $liftId);
        if ($lift == null) {
          $msg = "The associated lift was not found.";
        } else {
          $liftId = $lift->getId();
          $liftTitle = $lift->getTitle();
          $occurrence = $attempt->getOccurrence();
          $weight = $attempt->getWeight();
          $reps = $attempt->getReps();
        }
      } else {
        $msg = "Attempt not found.";
      }
    } else {
      $msg = "No attempt ID given.";
    }
    require("../view/attempt-view.php");
  }
  public function attemptsView() {
    $liftTitles = array();
    $user = DefaultController::getInstance()->getUser();
    $attempts = AttemptRepository::getInstance()->getAttemptsUser($user->getId());
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    foreach ($lifts as $lift) {
      $lift->setAttempts(AttemptRepository::getInstance()->getAttemptsLift($user->getId(), $lift->getId()));
      $liftId = $lift->getId();
      $liftTitles["$liftId"] = $lift->getTitle();
    }
    require ("../view/attempts-view.php");
  }
}

if (!ControllerRegistry::getInstance()->isRegistered(AttemptController::getInstance()->getName())) {
  ControllerRegistry::getInstance()->register(AttemptController::getInstance());
}
?>

