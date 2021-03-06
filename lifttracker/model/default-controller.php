<?php
require_once("controller.php");
require_once("controller-registry.php");
require_once("default-repository.php");
require_once("plan-repository.php");
require_once("lift-repository.php");
require_once("password-validator.php");
require_once("user.php");
require_once("user-validator.php");
require_once("utils.php");

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
    if (!$this->isLoggedIn()
        && $action != "login"
        && $action != "loginprocess"
        && $action != "selfadd"
        && $action != "selfprocessaddedit") {
      $url = "index.php?controller=default&action=login&uri=" . urlencode(Utils::getRequestedUri());
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
        case "selfadd":
          $this->selfAdd();
          break;
        case "selfedit":
          $this->selfEdit();
          break;
        case "selfprocessaddedit":
          $this->selfProcessAddEdit();
          break;
        default:
          $this->home();
          break;
      }
    }
  }
  public function home() {
    $user = DefaultController::getInstance()->getUser();
    $lifts = LiftRepository::getInstance()->getLifts($user->getId());
    $plans = PlanRepository::getInstance()->getPlansUser($user->getId());
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
    $uri = Utils::getArg("uri");
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
        if ($uri == null) {
          Utils::redirect("../index.php");
        } else {
          Utils::redirect($uri);
        }
      }
    }
    $password = "";
    require ("../view/login.php");
  }
  protected function loginView() {
    if ($this->isLoggedIn ()) {
      Utils::redirect("../index.php");
    }
    $uri = Utils::getArg("uri");
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
  protected function selfAdd() {
    $username = "";
    $firstName = "";
    $lastName = "";
    $height = "";
    $weight = "";
    $email = "";
    $password = "";
    $passwordRetype = "";

    if ($this->isLoggedIn()) {
      Utils::redirect("index.php?controller=default&action=selfedit");
    }

    require("../view/self-add-edit.php");
  }
  protected function selfEdit() {
    $user = $this->getUser();
    $username = $user->getUsername();
    $firstName = $user->getFirstName();
    $lastName = $user->getLastName();
    $height = $user->getHeight();
    $weight = $user->getWeight();
    $email = $user->getEmail();
    $password = "";
    $passwordRetype = "";

    require("../view/self-add-edit.php");
  }
  protected function selfProcessAddEdit() {
    $user = null;
    $msgList = array();
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
        Utils::redirect("index.php?controller=default&action=logout");
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
      $user->setId(0);
      $user->setUsername($username);
      $user->setFirstName($firstName);
      $user->setLastName($lastName);
      $user->setHeight($height);
      $user->setWeight($weight);
      $user->setEmail($email);
      $user->setVital(false);
      //Make sure the username is not taken.
      if (DefaultRepository::getInstance()->isExistingUser($username)) {
        //The user name is taken.
        $msgList[] = "The username is already taken.";
      }
    }
    if (count($msgList) == 0) {
      $msgList = array_merge($msgList, UserValidator::getInstance()->validate($user));
    }
    if (!$isLoggedIn
        || (isset($password)
            && strlen($password) > 0)) {
      $msgList = array_merge($msgList, PasswordValidator::getInstance()->validate($password, $passwordRetype));
    }
    //Check to see if there were any invalid inputs.
    if (count($msgList) > 0) {
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
        $user = DefaultRepository::getInstance()->updateUser($user);
        if (isset($password)
            && strlen($password) > 0) {
          DefaultRepository::getInstance()->updatePassword($user->getId(), $password);
        }
        $this->setUser($user);
        $msg = "Profile updated successfully.";
        //View profile.
        Utils::redirect("index.php?controller=default&action=selfedit");
      } else {
        //Create account.
        $user = DefaultRepository::getInstance()->createUser($user, $password);
        //Login.
        $this->setUser($user);
        //Home page.
        Utils::redirect("index.php?controller=default&action=home");
      }
    }
    $password = "";
    $passwordRetype = "";
    require("../view/self-add-edit.php");
  }
}

if (!ControllerRegistry::getInstance()->isRegistered(DefaultController::getInstance()->getName())) {
  ControllerRegistry::getInstance()->register(DefaultController::getInstance());
}
?>

