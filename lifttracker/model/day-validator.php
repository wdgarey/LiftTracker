<?php
require_once("day.php");
require_once("utils.php");

class DayValidator {
  private static $sInst;
  public static function getInstance() {
    if (DayValidator::$sInst == null) {
      DayValidator::$sInst = new DayValidator ();
    }
    return DayValidator::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function validate($day) {
    $msgList = array();
    $msgList = array_merge($msgList, $this->validateId($day->getId()));
    $msgList = array_merge($msgList, $this->validateTitle($day->getTitle()));
    $msgList = array_merge($msgList, $this->validateWeekId($day->getWeekId()));
    return $msgList;
  }
  public function validateId($dayId) {
    if (is_numeric($dayId)
        && $dayId > -1
        && $dayId == (int)$dayId) {
      $msgList = array();
    } else {
      $msgList[] = "The day ID is not an integer.";
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
  public function validateWeekId($weekId) {
    if (is_numeric($weekId)
        && $weekId > -1
        && $weekId == (int)$weekId) {
      $msgList = array();
    } else {
      $msgList[] = "The week ID is not an integer.";
    }
    return $msgList;
  }
}
?>

