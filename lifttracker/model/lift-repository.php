<?php
require_once("repository.php");
require_once("user.php");

class LiftRepository extends Repository {
  private static $sInst;
  public static function getInstance() {
    if (LiftRepository::$sInst == null) {
      LiftRepository::$sInst = new LiftRepository ();
    }
    return LiftRepository::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function authenticate($username, $password) {
    $user = null;
    $conn = $this->createConnection ();
    $query = "SELECT *" 
      . " FROM lifttracker.enduser"
      . " WHERE username = :username"
      . " AND pwd = Sha1(:password)"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $users = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($users) == 1) {
      $user = new User();
      $user->initialize($users[0]);
    }
    return $user;
  }
  public function createUser($user, $password) {
    $conn = $this->createConnection();
    $query = "INSERT INTO lifttracker.enduser (username, email, pwd, vital, firstname, lastname, height, weight)"
      . " VALUES (:username, :email, Sha1(:password), :vital, :firstname, :lastname, :height, :weight)"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
    $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->bindValue(':vital', $user->getVital(), PDO::PARAM_BOOL);
    $stmt->bindValue(':firstname', $user->getFirstName(), PDO::PARAM_STR);
    $stmt->bindValue(':lastname', $user->getLastName(), PDO::PARAM_STR);
    $stmt->bindValue(':height', $user->getHeight(), PDO::PARAM_STR);
    $stmt->bindValue(':weight', $user->getWeight(), PDO::PARAM_STR);
    $stmt->execute();
    $user = null;
    if ($stmt->rowCount() == 1) {
      $lastId = $conn->lastInsertId();
      $user = $this->getUser($lastId);
    }
    $stmt->closeCursor();
    return $user;
  }
  public function getUser($userId) {
    $user = null;
    $conn = $this->createConnection ();
    $query = "SELECT *" 
      . " FROM lifttracker.enduser"
      . " WHERE id = :userid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':userid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $users = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($users) == 1) {
      $user = new User();
      $user->initialize($users[0]);
    }
    return $user;
  }
  public function isExistingUser($username) {
    $user = null;
    $isExisting = false;
    $conn = $this->createConnection ();
    $query = "SELECT *" 
      . " FROM lifttracker.enduser"
      . " WHERE username = :username"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $users = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($users) > 0) {
      $isExisting = true;
    }
    return $isExisting;
  }
  public function updatePassword($userId, $password) {
    $conn = $this->createConnection();
    $query = "UPDATE lifttracker.enduser "
      . " SET pwd = Sha1(:password)"
      . " WHERE id = :userid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':userid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
  public function updateUser($user) {
    $conn = $this->createConnection();
    $query = "UPDATE lifttracker.enduser"
      . " SET username = :username, email = :email, vital = :vital, firstname = :firstname, lastname = :lastname, height = :height, weight = :weight"
      . " WHERE id = :userid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
    $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
    $stmt->bindValue(':vital', $user->getVital(), PDO::PARAM_BOOL);
    $stmt->bindValue(':firstname', $user->getFirstName(), PDO::PARAM_STR);
    $stmt->bindValue(':lastname', $user->getLastName(), PDO::PARAM_STR);
    $stmt->bindValue(':height', $user->getHeight(), PDO::PARAM_STR);
    $stmt->bindValue(':weight', $user->getWeight(), PDO::PARAM_STR);
    $stmt->bindValue(':userid', $user->getId(), PDO::PARAM_INT);
    $stmt->execute();
    $lastId = $user->getId();
    $user = $this->getUser($lastId);
    $stmt->closeCursor();
    return $user;
  }
}
?>

