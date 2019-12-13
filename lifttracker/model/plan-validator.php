<?php
require_once("plan.php");
require_once("utils.php");

class PlanValidator {
  private static $sInst;
  public static function getInstance() {
    if (PlanValidator::$sInst == null) {
      PlanValidator::$sInst = new PlanValidator ();
    }
    return PlanValidator::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function validate($plan) {
    $msgList = array();
    $msgList = array_merge($msgList, $this->validateId($plan->getId()));
    $msgList = array_merge($msgList, $this->validateTitle($plan->getTitle()));
    return $msgList;
  }
  public function validateId($planId) {
    if (is_numeric($planId)
        && $planId > -1
        && $planId == (int)$planId) {
      $msgList = array();
    } else {
      $msgList[] = "The plan ID is not an integer.";
    }
    return $msgList;
  }
  public function validateTitle($title) {
    if (is_string($title)
        && strlen($title) > 0
        && strlen($title) < 33) {
      $msgList = array();
    } else {
      $msgList[] = "The title must be between 1 and 32 characters in length.";
    }
    return $msgList;
  }
}
?>

