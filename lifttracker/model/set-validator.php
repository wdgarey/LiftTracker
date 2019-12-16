<?php
require_once("set.php");
require_once("utils.php");

class SetValidator {
  private static $sInst;
  public static function getInstance() {
    if (SetValidator::$sInst == null) {
      SetValidator::$sInst = new SetValidator ();
    }
    return SetValidator::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function validate($set) {
    $msgList = array();
    $msgList = array_merge($msgList, $this->validateId($set->getId()));
    $msgList = array_merge($msgList, $this->validateTitle($set->getTitle()));
    $msgList = array_merge($msgList, $this->validateExerciseId($set->getExerciseId()));
    $msgList = array_merge($msgList, $this->validateReps($set->getReps()));
    $msgList = array_merge($msgList, $this->validatePercent($set->getPercent()));
    return $msgList;
  }
  public function validateId($setId) {
    if (is_numeric($setId)
        && $setId > -1
        && $setId == (int)$setId) {
      $msgList = array();
    } else {
      $msgList[] = "The set ID is not an integer.";
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
  public function validateExerciseId($exerciseId) {
    if (is_numeric($exerciseId)
        && $exerciseId > -1
        && $exerciseId == (int)$exerciseId) {
      $msgList = array();
    } else {
      $msgList[] = "The exercise ID is not an integer.";
    }
    return $msgList;
  }
  public function validateReps($reps) {
    if (is_numeric($reps)
        && $reps > -1
        && $reps == (int)$reps) {
      $msgList = array();
    } else {
      $msgList[] = "The number of reps is not an integer.";
    }
    return $msgList;
  }
  public function validatePercent($percent) {
    if (is_numeric($percent)
        && $percent >= 0.0
        && $percent <= 2.0
        && $percent == (float)$percent) {
      $msgList = array();
    } else {
      $msgList[] = "The percentage of weight is not a decimal number type.";
    }
    return $msgList;
  }
}
?>

