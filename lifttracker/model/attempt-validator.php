<?php
require_once("attempt.php");
require_once("utils.php");

class AttemptValidator {
  private static $sInst;
  public static function getInstance() {
    if (AttemptValidator::$sInst == null) {
      AttemptValidator::$sInst = new AttemptValidator ();
    }
    return AttemptValidator::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function validate($attempt) {
    $msgList = array();
    $msgList = array_merge($msgList, $this->validateId($attempt->getId()));
    $msgList = array_merge($msgList, $this->validateId($attempt->getLiftId()));
    $msgList = array_merge($msgList, $this->validateOccurrence($attempt->getOccurrence()));
    $msgList = array_merge($msgList, $this->validateWeight($attempt->getWeight()));
    $msgList = array_merge($msgList, $this->validateReps($attempt->getReps()));
    return $msgList;
  }
  public function validateId($attemptId) {
    if (is_numeric($attemptId)
        && $attemptId > -1
        && $attemptId == (int)$attemptId) {
      $msgList = array();
    } else {
      $msgList[] = "The attempt ID is not an integer.";
    }
    return $msgList;
  }
  public function validateOccurrence($occurrence) {
    if (is_string($occurrence)
        && strlen(Utils::toMySqlDate($occurrence)) > 0) {
      $msgList = array();
    } else {
      $msgList[] = "The occurrence of the attempt is not a valid date.";
    }
    return $msgList;
  }
  public function validateWeight($weight) {
    if (is_numeric($weight)
        && $weight > 0) {
      $msgList = array();
    } else {
      $msgList[] = "The training weight must be a numeric value greater than 0.";
    }
    return $msgList;
  }
  public function validateReps($reps) {
    if (is_numeric($reps)
        && $reps > -1
        && $reps == (int)$reps) {
      $msgList = array();
    } else {
      $msgList[] = "The training reps must be a numeric value greater than 0.";
    }
    return $msgList;
  }
}
?>

