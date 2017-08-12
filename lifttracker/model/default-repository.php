<?php
require_once("repository.php");
require_once("user.php");

class DefaultRepository extends Repository {
  public function authenticate($username, $password) {
    $user = null;
    $conn = $this->createConnection ();
    $query = "SELECT *" 
      . " FROM lifttracker.enduser"
      . " WHERE username = :username"
      . " AND password = Sha1(:password)"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $users = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($users) == 1) {
      $user = new User();
      $user->initialize($array);
    }
    return $user;
  }
}
?>

