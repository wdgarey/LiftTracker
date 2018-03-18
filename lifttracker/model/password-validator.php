<?php

class PasswordValidator {
  private static $sInst;
  public static function getInstance() {
    if (PasswordValidator::$sInst == null) {
      PasswordValidator::$sInst = new PasswordValidator ();
    }
    return PasswordValidator::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function validate($password, $passwordRetype) {
    if (is_string($password)
        && strlen($password) > 0) {
      if ($password == $passwordRetype) {
        $msgList = array();
      } else {
        $msgList[] = "The given password was not retyped correctly.";
      }
    } else {
      $msgList[] = "The password and must not be blank.";
    }
    return $msgList;
  }
}
?>

