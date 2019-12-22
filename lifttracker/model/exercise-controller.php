<?php
require_once("controller.php");
require_once("controller-registry.php");
require_once("exercise.php");
require_once("exercise-repository.php");
require_once("exercise-validator.php");
require_once("day-repository.php");
require_once("lift-repository.php");
require_once("user.php");
require_once("utils.php");

class ExerciseController implements Controller {
  private static $sInst;
  public static function getInstance() {
    if (ExerciseController::$sInst == null) {
      ExerciseController::$sInst = new ExerciseController ();
    }
    return ExerciseController::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function getName() {
    return "exercise";
  }
  public function handleRequest() {
    $action = Utils::getArg("action");
    if (!DefaultController::getInstance()->isLoggedIn()) {
      $url = "index.php?controller=default&action=login";
      Utils::redirect($url);
    } else {
      switch ($action) {
        case "exerciseadd":
          $this->exerciseAdd();
          break;
        case "exercisedelete":
          $this->exerciseDelete();
          break;
        case "exerciseedit":
          $this->exerciseEdit();
          break;
        case "exerciseprocessaddedit":
          $this->exerciseProcessAddEdit();
          break;
        default:
          $url = "index.php?controller=default";
          Utils::redirect($url);
          break;
      }
    }
  }
  protected function exerciseAdd() {
    $liftId = "";
    $dayId = Utils::getArg("dayid");
    $user = DefaultController::getInstance()->getUser();
    $title = "";
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    if ($dayId == null) {
      $msg = "No day ID given.";
    }
    require ("../view/exercise-add-edit.php");
  }
  protected function exerciseDelete() {
    $exerciseId = Utils::getArg("exerciseid");
    $user = DefaultController::getInstance()->getUser();
    if ($exerciseId != null) {
      $exercise = ExerciseRepository::getInstance()->getExercise($user->getId(), $exerciseId);
      if ($exercise != null) {
        $planId = ExerciseRepository::getInstance()->getPlanId($user->getId(), $exerciseId);
        ExerciseRepository::getInstance()->deleteExercises($user->getId(), array($exerciseId));
        Utils::redirect("index.php?controller=plan&action=planview&planid=" . $planId);
      } else {
        $msg = "Exercise not found.";
      }
    } else {
      $msg = "No exercise ID given.";
    }
    require ("../view/message.php");
  }
  protected function exerciseEdit() {
    $liftId = "";
    $exerciseId = Utils::getArg("exerciseid");
    $user = DefaultController::getInstance()->getUser();
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    if ($exerciseId != null) {
      $exercise = ExerciseRepository::getInstance()->getExercise($user->getId(), $exerciseId);
      if ($exercise != null) {
        $title = $exercise->getTitle();
        $liftId = $exercise->getLiftId();
      } else {
        $msg = "Exercise not found.";
      }
    } else {
      $msg = "No exercise ID given.";
    }
    require("../view/exercise-add-edit.php");
  }
  protected function exerciseProcessAddEdit() {
    $msgList = array();
    $dayId = Utils::getArg("dayid");
    $liftId = Utils::getArg("liftid");
    $exerciseId = Utils::getArg("exerciseid");
    $title = Utils::getArg("title");
    $user = DefaultController::getInstance()->getUser();
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    if ($exerciseId == null) { //Adding
      $exercise = new Exercise();
      $exercise->setId(0);
      if ($dayId != null) {
        $exercise->setDayId($dayId);
      } else {
        $msgList[] = "No day ID given.";
      }
    } else { //Updating
      $exercise = ExerciseRepository::getInstance()->getExercise($user->getId(), $exerciseId);
      if ($exercise == null) {
        $msgList[] = "Exercise not found.";
      }
    }
    if ($liftId != ""
      && LiftRepository::getInstance()->getLift($user->getId(), $liftId) == null) {
      $msgList[] = "The lift does not exist.";
    }
    if (count($msgList) == 0) {
      $exercise->setTitle($title);
      $exercise->setLiftId($liftId);
      $msgList = array_merge($msgList, ExerciseValidator::getInstance()->validate($exercise));
    }
    if (count($msgList) > 0) {
      if ($exerciseId == null) {
        $msg = "Could not add exercise";
      } else {
        $msg = "Could not update exercise";
      }
    } else {
      if ($exerciseId == null) {
        $planId = DayRepository::getInstance()->getPlanId($user->getId(), $dayId);
        if (ExerciseRepository::getInstance()->addExercise($user->getId(), $exercise) == null) {
          $msg = "Could not add exercise";
        } else {
          $title = "";
        }
      } else {
        $rows = ExerciseRepository::getInstance()->updateExercise($user->getId(), $exercise);
        if ($rows == 0) {
          $msg = "Could not update exercise";
        } else {
          $planId = ExerciseRepository::getInstance()->getPlanId($user->getId(), $exerciseId);
          Utils::redirect("index.php?controller=plan&action=planview&planid=" . $planId);
        }
      }
    }
    require("../view/exercise-add-edit.php");
  }
}

if (!ControllerRegistry::getInstance()->isRegistered(ExerciseController::getInstance()->getName())) {
  ControllerRegistry::getInstance()->register(ExerciseController::getInstance());
}
?>

