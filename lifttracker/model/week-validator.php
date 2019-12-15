<?php
require_once("week.php");
require_once("utils.php");

class WeekValidator {
  private static $sInst;
  public static function getInstance() {
    if (WeekValidator::$sInst == null) {
      WeekValidator::$sInst = new WeekValidator ();
    }
    return WeekValidator::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function validate($week) {
    $msgList = array();
    $msgList = array_merge($msgList, $this->validateId($week->getId()));
    $msgList = array_merge($msgList, $this->validateTitle($week->getTitle()));
    $msgList = array_merge($msgList, $this->validatePlanId($week->getPlanId()));
    return $msgList;
  }
  public function validateId($weekId) {
    if (is_numeric($weekId)
        && $weekId > -1
        && $weekId == (int)$weekId) {
      $msgList = array();
    } else {
      $msgList[] = "The week ID is not an integer.";
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
  public function validatePlanId($planId) {
    if (is_numeric($planId)
        && $planId > -1
        && $planId == (int)$planId) {
      $msgList = array();
    } else {
      $msgList[] = "The plan ID is not an integer.";
    }
    return $msgList;
  }
}
?>

