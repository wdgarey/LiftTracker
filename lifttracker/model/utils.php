<?php
class Utils {
  public static function adjustQuotes() {
    if (get_magic_quotes_gpc() == true) {
      array_walk_recursive($_GET, array('Utils', 'stripSlashes_Gpc'));
      array_walk_recursive($_POST, array('Utils', 'stripSlashes_Gpc'));
      array_walk_recursive($_COOKIE, array('Utils', 'stripSlashes_Gpc'));
      array_walk_recursive($_REQUEST, array('Utils', 'stripSlashes_Gpc'));
    }
  }
  public static function getArg($name) {
    $arg = null;
    if (isset($_GET[$name])) {
      $arg = $_GET[$name];
    } else if (isset($_POST[$name])) {
      $arg = $_POST[$name];
    }
    return $arg;
  }
  public static function getRequestedUri() {
    $uri = $_SERVER['REQUEST_URI'];
    return $uri;
  }
  public static function redirect($url) {
    header("Location:" . $url);
    exit();
  }
  public static function secureConnection() {
    if (!isset($_SERVER['HTTPS'])) {
      $url = 'https://' . $_SERVER['HTTP_HOST'] . Utils::getRequestedUri();
      Utils::redirect($url);
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
  public static function unsecureConnection($requestedPage = "") {
    if (isset($_SERVER['HTTPS'])) {
      $url = "";
      if(empty($requestedPage)) {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . Utils::getRequestedUri();
      } else {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $requestedPage;
      }
      Utils::redirect($url);
    }
  }
}
?>

