<?php
require_once("lift.php");

class LiftValidator {
  private static $sInst;
  public static function getInstance() {
    if (LiftValidator::$sInst == null) {
      LiftValidator::$sInst = new LiftValidator ();
    }
    return LiftValidator::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function validate($lift) {
    $msgList = array();
    $msgList = array_merge($msgList, $this->validateId($lift->getId()));
    $msgList = array_merge($msgList, $this->validateTitle($lift->getTitle()));
    $msgList = array_merge($msgList, $this->validateTrainingWeight($lift->getTrainingWeight()));
    return $msgList;
  }
  public function validateId($liftId) {
    if (is_numeric($liftId)
        && $liftId > -1
        && $liftId == (int)$liftId) {
      $msgList = array();
    } else {
      $msgList[] = "The lift ID is not an integer.";
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
  public function validateTrainingWeight($weight) {
    if (is_numeric($weight)
        && $weight > 0) {
      $msgList = array();
    } else {
      $msgList[] = "The training weight must be a numeric value greater than 0.";
    }
    return $msgList;
  }
}
?>

