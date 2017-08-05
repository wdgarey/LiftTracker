<?php

class Utils {
  public const VALID_EMAIL_PATTERN = "/^[^@]*@[^@]*\.[^@]*$/";
  public const VALID_PHONE_PATTERN = "/^[0-9]{10}$/";
  public static function getArg($name) {
    $arg = NULL;
    if (isset($_GET[$name])) {
      $arg = $_GET[$name];
    } else if (isset($_POST[$name])) {
      $arg = $_POST[$name];
    }
    return $arg;
  }
  public static function getRequestedUri() {
    $uri = urlencode($_SERVER['REQUEST_URI']);
    return $uri;
  }
  public static function redirect($url) {
    header("Location:" . $url);
    exit();
  }
  public static function secureConnection() {
    if ( !isset( $_SERVER['HTTPS'] ) ) {
      $url = 'https://' . $_SERVER['HTTP_HOST'] . $this->getRequestedUri();
      $this->redirect($url);
    }
  }
  public static function startSession() {
    if (!isset($_SESSION)) {
      session_start();
    }
  }
  public static function stopSession() {
    if (isset($_SESSION)) {
      $_SESSION = array();
      session_destroy();
    }
  }
  public static function stripSlashes_Gpc(&$value) {
    $value = stripslashes($value);
  }
  public static function toDisplayDate($date) {
    $phpDate = strtotime($date);
    if ($phpDate == FALSE) {
      return "";
    } else {
      return date('m/d/Y', $phpDate);
    }
  }
  public static function toMySqlDate($date) {
    $phpDate = strtotime($date);
    if ($phpDate == FALSE) {
      return "";
    } else {
      return date('Y-m-d', $phpDate);
    }
  }
  function unsecureConnection($requestedPage = "") {
    if (isset($_SERVER['HTTPS'])) {
      $url = "";
      if(empty($requestedPage)) {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $this->getRequestedUri();
      } else {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $requestedPage;
      }
      $this->redirect($url);
    }
  }
}

?>

