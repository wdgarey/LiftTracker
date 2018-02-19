<?php
require_once("repository.php");
require_once("user.php");

class DefaultRepository extends Repository {
  public function authenticate($username, $pwd) {
    $user = null;
    $conn = $this->createConnection ();
    $query = "SELECT *" 
      . " FROM lifttracker.enduser"
      . " WHERE username = :username"
      . " AND pwd = Sha1(:pwd)"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':pwd', $pwd, PDO::PARAM_STR);
    $stmt->execute();
    $users = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($users) == 1) {
      $user = new User();
      $user->initialize($users[0]);
    }
    return $user;
  }
}
?>

