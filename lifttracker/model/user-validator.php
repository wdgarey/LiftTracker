<?php
require_once("user.php");

class UserValidator {
  private static $sInst;
  public static function getInstance() {
    if (UserValidator::$sInst == null) {
      UserValidator::$sInst = new UserValidator ();
    }
    return UserValidator::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function validate($user) {
    $msgList = array();
    $msgList = array_merge($msgList, $this->validateId($user->getId()));
    $msgList = array_merge($msgList, $this->validateUsername($user->getUsername()));
    $msgList = array_merge($msgList, $this->validateEmail($user->getEmail()));
    $msgList = array_merge($msgList, $this->validateVital($user->getVital()));
    $msgList = array_merge($msgList, $this->validateFirstName($user->getFirstName()));
    $msgList = array_merge($msgList, $this->validateLastName($user->getLastName()));
    $msgList = array_merge($msgList, $this->validateHeight($user->getHeight()));
    $msgList = array_merge($msgList, $this->validateWeight($user->getWeight()));
  }
  public function validateId($userId) {
    if ($userId != null
        && is_numeric($userId)
        && $userId > -1
        && $userId == round($userId, 0)) {
      $msgList = array();
    } else {
      $msgList[] = "The user ID is not an integer.";
    }
    return $msgList;
  }
  public function validateUsername($username) {
    if ($username != null
        && is_string($username)
        && strlen($username) > 0
        && strlen($username) < 33) {
      $msgList = array();
    } else {
      $msgList[] = "The username must be between 1 and 32 characters in length.";
    }
    return $msgList;
  }
  public function validateEmail($email) {
    if ($email != null
        && is_string($email)
        && strlen($email) > 0
        && strlen($email) < 101) {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msgList = array();
      } else {
        $msgList[] = "Invalid email address given.";
      }
    } else {
      $msgList[] = "The email address must be between 1 and 100 characters in length."; 
    }
    return $msgList;
  }
  public function validateVital($vital) {
    if ($vital != null
        && is_bool($vital)) {
      $msgList = array();
    } else {
      $msgList[] = "Invalid vital property given.";
    }
    return $msgList;
  }
  public function validateFirstName($firstName) {
    if ($firstName != null
        && is_string($firstName)
        && strlen($firstName) > 0
        && strlen($firstName) < 41) {
      $msgList = array();
    } else {
      $msgList[] = "The first name must be between 1 and 40 characters in length."; 
    }
    return $msgList;
  }
  public function validateLastName($lastName) {
    if ($lastName != null
        && is_string($lastName)
        && strlen($lastName) > 0
        && strlen($lastName) < 41) {
      $msgList = array();
    } else {
      $msgList[] = "The first name must be between 1 and 40 characters in length."; 
    }
    return $msgList;  }
  public function validateHeight($height) {
    if ($height != null
        && is_numeric($height)
        && $height > 0) {
      $msgList = array();
    } else {
      $msgList[] = "The height must be a numeric value greater than 0.";
    }
    return $msgList;
  }
  public function validateWeight($weight) {
    if ($weight != null
        && is_numeric($weight)
        && $weight > 0) {
      $msgList = array();
    } else {
      $msgList[] = "The weight must be a numeric value greater than 0.";
    }
    return $msgList;
  }
}
?>

