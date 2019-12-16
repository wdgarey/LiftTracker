<?php
require_once("exercise.php");
require_once("utils.php");

class ExerciseValidator {
  private static $sInst;
  public static function getInstance() {
    if (ExerciseValidator::$sInst == null) {
      ExerciseValidator::$sInst = new ExerciseValidator ();
    }
    return ExerciseValidator::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function validate($exercise) {
    $msgList = array();
    $msgList = array_merge($msgList, $this->validateId($exercise->getId()));
    $msgList = array_merge($msgList, $this->validateLiftId($exercise->getLiftId()));
    $msgList = array_merge($msgList, $this->validateTitle($exercise->getTitle()));
    $msgList = array_merge($msgList, $this->validateDayId($exercise->getDayId()));
    return $msgList;
  }
  public function validateId($exerciseId) {
    if (is_numeric($exerciseId)
        && $exerciseId > -1
        && $exerciseId == (int)$exerciseId) {
      $msgList = array();
    } else {
      $msgList[] = "The exercise ID is not an integer.";
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
  public function validateDayId($dayId) {
    if (is_numeric($dayId)
        && $dayId > -1
        && $dayId == (int)$dayId) {
      $msgList = array();
    } else {
      $msgList[] = "The day ID is not an integer.";
    }
    return $msgList;
  }
  public function validateLiftId($liftId) {
    if ($liftId == null
        || (is_numeric($liftId)
        && $liftId > -1
        && $liftId == (int)$liftId)) {
      $msgList = array();
    } else {
      $msgList[] = "The lift ID is not an integer.";
    }
    return $msgList;
  }
}
?>

