<?php
require_once("controller.php");
require_once("controller-registry.php");
require_once("week-repository.php");
require_once("day-repository.php");
require_once("exercise-repository.php");
require_once("lift-repository.php");
require_once("plan.php");
require_once("plan-repository.php");
require_once("plan-validator.php");
require_once("user.php");
require_once("utils.php");

class PlanController implements Controller {
  private static $sInst;
  public static function getInstance() {
    if (PlanController::$sInst == null) {
      PlanController::$sInst = new PlanController ();
    }
    return PlanController::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function getName() {
    return "plan";
  }
  public function handleRequest() {
    $action = Utils::getArg("action");
    if (!DefaultController::getInstance()->isLoggedIn()) {
      $url = "index.php?controller=default&action=login";
      Utils::redirect($url);
    } else {
      switch ($action) {
        case "planadd":
          $this->planAdd();
          break;
        case "plandelete":
          $this->planDelete();
          break;
        case "planedit":
          $this->planEdit();
          break;
        case "planprocessaddedit":
          $this->planProcessAddEdit();
          break;
        case "planview":
          $this->planView();
          break;
        case "plansview":
          $this->plansView();
          break;
        default:
          $url = "index.php?controller=default";
          Utils::redirect($url);
          break;
      }
    }
  }
  protected function planAdd() {
    $user = DefaultController::getInstance()->getUser();
    $title = "";
    require ("../view/plan-add-edit.php");
  }
  protected function planDelete() {
    $planId = Utils::getArg("planid");
    $planIds = Utils::getArg("planids");
    $user = DefaultController::getInstance()->getUser();
    if ($planId != null) {
      PlanRepository::getInstance()->deletePlans($user->getId(), array($planId));
    } else if ($planIds != null) {
      PlanRepository::getInstance()->deletePlans($user->getId(), $planIds);
    } else {
      $msg = "No plan ID given.";
    }
    $plans = PlanRepository::getInstance()->getPlansUser($user->getId());
    require ("../view/plans-view.php");
  }
  protected function planEdit() {
    $planId = Utils::getArg("planid");
    $user = DefaultController::getInstance()->getUser();
    if ($planId != null) {
      $plan = PlanRepository::getInstance()->getPlan($user->getId(), $planId);
      if ($plan != null) {
        $title = $plan->getTitle();
      } else {
        $msg = "Plan not found.";
      }
    } else {
      $msg = "No plan ID given.";
    }
    require("../view/plan-add-edit.php");
  }
  protected function planProcessAddEdit() {
    $msgList = array();
    $planId = Utils::getArg("planid");
    $title = Utils::getArg("title");
    $user = DefaultController::getInstance()->getUser();
    if ($planId == null) { //Adding
      $plan = new Plan();
      $plan->setId(0);
    } else { //Updating
      $plan = PlanRepository::getInstance()->getPlan($user->getId(), $planId);
      if ($plan == null) {
        $msgList[] = "Plan not found.";
      }
    }
    if (count($msgList) == 0) {
      $plan->setTitle($title);
      $msgList = array_merge($msgList, PlanValidator::getInstance()->validate($plan));
    }
    if (count($msgList) > 0) {
      if ($planId == null) {
        $msg = "Could not add plan";
      } else {
        $msg = "Could not upate plan";
      }
    } else {
      if ($planId == null) {
        $planId = PlanRepository::getInstance()->addPlan($user->getId(), $plan);
        Utils::redirect("index.php?controller=plan&action=planview&planid=" . $planId);
      } else {
        PlanRepository::getInstance()->updatePlan($user->getId(), $plan);
        Utils::redirect("index.php?controller=plan&action=planview&planid=" . $plan->getId());
      }
    }
    require("../view/plan-add-edit.php");
  }
  public function planView() {
    $title = "";
    $planId = Utils::getArg("planid");
    $user = DefaultController::getInstance()->getUser();
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    if ($planId != null) {
      $plan = PlanRepository::getInstance()->getPlan($user->getId(), $planId);
      if ($plan != null) {
        $title = $plan->getTitle();
        $weeks = WeekRepository::getInstance()->getWeeks($user->getId(), $planId);
        foreach ($weeks as $week) {
          $days = DayRepository::getInstance()->getDays($user->getId(), $week->getId());
          $week->setDays($days);
          foreach ($days as $day) {
            $exercises = ExerciseRepository::getInstance()->getExercises($user->getId(), $day->getId());
            $day->setExercises($exercises);
            foreach ($exercises as $exercise) {
              $found = false;
              for ($i = 0; $i < count($lifts) && $found == false; $i++) {
                if ($exercise->getLiftId() == $lifts[$i]->getId()) {
                  $exercise->setLiftTitle($lifts[$i]->getTitle());
                }
              }
            }
          }
        }
      } else {
        $msg = "Plan not found.";
      }
    } else {
      $msg = "No plan ID given.";
    }
    require("../view/plan-view.php");
  }
  public function plansView() {
    $user = DefaultController::getInstance()->getUser();
    $plans = PlanRepository::getInstance()->getPlansUser($user->getId());
    require ("../view/plans-view.php");
  }
}

if (!ControllerRegistry::getInstance()->isRegistered(PlanController::getInstance()->getName())) {
  ControllerRegistry::getInstance()->register(PlanController::getInstance());
}
?>

