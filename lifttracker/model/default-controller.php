<?php
require_once("controller.php");
require_once("controller-registry.php");
require_once("default-repository.php");
require_once("utils.php");

error_reporting (E_ALL);

class DefaultController implements Controller {
  private static $sInst;
  public static function getInstance() {
    if (DefaultController::$sInst == null) {
      DefaultController::$sInst = new DefaultController ();
    }
    return DefaultController::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function getName() {
    return "default";
  }
  public function getUser() {
    $user = new User();
    if ($this->isLoggedIn()) {
      $user = $_SESSION["user"];
    }
    return $user;
  }
  public function handleRequest() {
    $action = Utils::getArg("action");
    Utils::adjustQuotes();
    Utils::startSession();
    if ($action == "login" || $action == "loginprocess") {
      Utils::secureConnection();
    } else {
      Utils::unsecureConnection();
    }
    if (!$this->isLoggedIn()
        && $action != "login"
        && $action != "loginprocess"
        && $action != "signup"
        && $action != "signupprocess") {
      $url = "index.php?controller=default&action=login";
      Utils::redirect($url);
    } else {
      switch ($action) {
      case "login" :
        $this->loginView();
        break;
      case "loginprocess":
        $this->loginProcess();
        break;
      case "logout":
        $this->logout();
        break;
      case "signup":
        $this->signupView();
        break;
      case "signupprocess":
        $this->signupProcess();
        break;
      default:
        $this->home();
        break;
      }
    }
  }
  public function home() {
    include("../view/home.php");
  }
  public function isLoggedIn() {
    $isLoggedIn = (isset($_SESSION) && isset($_SESSION["user"]));
    return $isLoggedIn;
  }
  protected function logout() {
    if ($this->isLoggedIn()) {
      unset($_SESSION["user"]);
    }
    Utils::redirect("../index.php");
  }
  protected function loginProcess() {
    $msg = "";
    if ($this->isLoggedIn ()) {
      Utils::redirect("../index.php");
    }
    $username = Utils::getArg("username");
    $password = Utils::getArg("password");

    if ($username == null) {
      $msg .= "No username given.";
    }
    if ($password == null) {
      $msg .= "No password given.";
    }
    if (strlen($msg) == 0) {
      $repository = new DefaultRepository();
      $user = $repository->authenticate($username, $password);
      if ($user == null) {
        $msg = "Invalid username and/or password.";
      } else {
        $_SESSION["user"] = $user;
        Utils::redirect("../index.php");
      }
    }

    require ("../view/login.php");
  }
  protected function loginView() {
    if ($this->isLoggedIn ()) {
      Utils::redirect("../index.php");
    }
    $username = Utils::getArg("username");
    $password = "";
    if ($username == null) {
      $username = "";
    }
    require ("../view/login.php");
  }
  protected function signupView() {
    $userName = "";
    $firstName = "";
    $lastName = "";
    $email = "";
    $password = "";
    $passwordRetype = "";

    require("../view/selfaddedit.php");
  }
  protected function signupProcess() {
    $userId = Utils::getArg("userid");
    $username = Utils::getArg("username");
    $firstName = Utils::getArg("firstname");
    $lastName = Utils::getArg("lastname");
    $height = Utils::getArg("height");
    $weight = Utils::getArg("weight");
    $email = Utils::getArg("email");
    $password = Utils::getArg("password");
    $passwordRetype = Utils::getArg("passwordretype");


    if (count($msgList) > 0) {
      if ($userId == null) {
        $msg = "Could not create account.";
      } else {
        $msg = "Could not update account.";
      }
    }

    require("../view/selfaddedit.php");
  }
}

if (!ControllerRegistry::getInstance()->isRegistered(DefaultController::getInstance()->getName())) {
  ControllerRegistry::getInstance()->register(DefaultController::getInstance());
}
?>

