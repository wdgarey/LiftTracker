<?php
require_once("controller.php");
require_once("controller-registry.php");
require_once("default-repository.php");
require_once("password-validator.php");
require_once("user.php");
require_once("user-validator.php");
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
    if (DefaultController::getInstance()->isLoggedIn()) {
      $user = $_SESSION["user"];
    }
    return $user;
  }
  public function handleRequest() {
    $action = Utils::getArg("action");
    Utils::adjustQuotes();
    Utils::startSession();
    if ($action == "login"
        || $action == "loginprocess") {
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
      $user = DefaultRepository::getInstance()->authenticate($username, $password);
      if ($user == null) {
        $msg = "Invalid username and/or password.";
      } else {
        $this->setUser($user);
        Utils::redirect("../index.php");
      }
    }
    $password = "";
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
  protected function setUser($user) {
    $_SESSION["user"] = $user;
  }
  protected function signupView() {
    $userName = "";
    $firstName = "";
    $lastName = "";
    $height = "";
    $weight = "";
    $email = "";
    $password = "";
    $passwordRetype = "";

    require("../view/selfaddedit.php");
  }
  protected function signupProcess() {
    $user = null;
    $username = Utils::getArg("username");
    $firstName = Utils::getArg("firstname");
    $lastName = Utils::getArg("lastname");
    $height = Utils::getArg("height");
    $weight = Utils::getArg("weight");
    $email = Utils::getArg("email");
    $password = Utils::getArg("password");
    $passwordRetype = Utils::getArg("passwordretype");
    $isLoggedIn = $this->isLoggedIn();
    //Check to see if this an update or a create.
    if ($isLoggedIn) {
      $userId = $this->getUser()->getId();
      $user = DefaultRepository::getInstance()->getUser($userId);
      if ($user == null) {
        $msgList[] = "User not found.";
      } else {
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setHeight($height);
        $user->setWeight($weight);
        $user->setEmail($email);
      }
    } else {
      //This is a create. 
      $user = new User();
      $user->setUserId(0);
      $user->setUsername($username);
      $user->setFirstName($firstName);
      $user->setLastName($lastName);
      $user->setHeight($height);
      $user->setWeight($weight);
      $user->setEmail($email);
      $user->SetVital(false);
      //Make sure the username is not taken.
      if (DefaultRepository::getInstance()->isExsitingUser($username)) {
        //The user name is taken.
        $msgList[] = "The username is already taken.";
      }
    }
    $msgList = array_merge($msgList, UserValidator::getInstance()->validate($user));
    if (!$isLoggedIn
        || (isset($password)
            && strlen($password) > 0)) {
      $msgList = array_merge($msgList, PasswordValidator::getInstance()->validate($password, $passwordRetype));
    }
    //Check to see if there were any invalid inputs.
    if (isset($msgList)
        && count($msgList) > 0) {
      //There were invalid inputs.
      if ($isLoggedIn) {
        $msg = "Could not update account.";
      } else {
        $msg = "Could not create account.";
      }
    } else {
      //There were no invalid inputs.
      if ($isLoggedIn) {
        //Update account.
        //View profile.
        $user = DefaultRepository::getInstance()->updateUser($user);
        if (isset($password)
            && strlen($password) > 0) {
            DefaultRepository::getInstance()->updatePassword($user->getId(), $password);
        }
        $this->setUser($user);
        Utils::redirect("index.php?controller=default&action=selfview");
      } else {
        //Create account.
        //Login.
        //Home page.
        $user = DefaultRepository::getInstance()->createUser($user, $password);
        $this->setUser($user);
        Utils::redirect("index.php?controller=default&action=home");
      }
    }
    $password = "";
    $passwordRetype = "";
    require("../view/selfaddedit.php");
  }
}

if (!ControllerRegistry::getInstance()->isRegistered(DefaultController::getInstance()->getName())) {
  ControllerRegistry::getInstance()->register(DefaultController::getInstance());
}
?>

