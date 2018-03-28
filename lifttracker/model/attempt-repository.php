<?php
require_once("attempt.php");
require_once("repository.php");
require_once("utils.php");

class AttemptRepository extends Repository {
  private static $sInst;
  public static function getInstance() {
    if (AttemptRepository::$sInst == null) {
      AttemptRepository::$sInst = new AttemptRepository ();
    }
    return AttemptRepository::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function addAttempt($attempt) {
    $conn = $this->createConnection();
    $query = "INSERT INTO lifttracker.liftrec (liftid, occurrence, weight, reps)"
      . " VALUES (:liftid, :occurrence, :weight, :reps)"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':liftid', $attempt->getLiftId(), PDO::PARAM_INT);
    $stmt->bindValue(':occurrence', Utils::toMySqlDate($attempt->getOccurrence()), PDO::PARAM_STR);
    $stmt->bindValue(':weight', $attempt->getWeight(), PDO::PARAM_STR);
    $stmt->bindValue(':reps', $attempt->getReps(), PDO::PARAM_INT);
    $stmt->execute();
    $lastId = null;
    if ($stmt->rowCount() == 1) {
      $lastId = $conn->lastInsertId();
    }
    $stmt->closeCursor();
    return $lastId;
  }
  public function deleteAttempts($userId, $attemptIds) {
    if (count($attemptIds) < 1) {
      return 0;
    }
    $conn = $this->createConnection();
    $query = "DELETE a.*"
      . " FROM lifttracker.liftrec a"
      . " INNER JOIN lifttracker.lift l ON l.id = a.liftid"
      . " WHERE l.enduserid = :enduserid"
      . " AND a.id IN (";
    $attemptCount = 1;
    foreach ($attemptIds as $attemptId) {
      if ($attemptCount == 1) {
        $query .= ":attemptid" . $attemptCount;
      } else {
        $query .= ", :attemptid" . $attemptCount;
      }
      $attemptCount += 1;
    }
    $query .= ");";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $attemptCount = 1;
    foreach ($attemptIds as $attemptId) {
      $stmt->bindValue(':attemptid' . $attemptCount, $attemptId, PDO::PARAM_INT);
      $attemptCount += 1;
    }
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
  public function getAttempt($userId, $attemptId) {
    $attempt = null;
    $conn = $this->createConnection ();
    $query = "SELECT a.*" 
      . " FROM lifttracker.liftrec a"
      . " INNER JOIN lifttracker.lift l ON l.id = a.liftid"
      . " WHERE a.id = :attemptid"
      . " AND l.enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':attemptid', $attemptId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $attempts = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($attempts) == 1) {
      $attempt = new Attempt();
      $attempt->initialize($attempts[0]);
    }
    return $attempt;
  }
  public function getAttemptsUser($userId) {
    $attempts = array();
    $conn = $this->createConnection ();
    $query = "SELECT a.*" 
      . " FROM lifttracker.liftrec a"
      . "   INNER JOIN lifttracker.lift l ON l.id = a.liftid"
      . " WHERE l.enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $table = $stmt->fetchAll();
    foreach ($table as $row) {
      $attempt = new Attempt();
      $attempt->initialize($row);
      $attempts[] = $attempt;
    }
    $stmt->closeCursor();
    return $attempts;
  }
  public function getAttemptsLift($userId, $liftId) {
    $attempts = array();
    $conn = $this->createConnection ();
    $query = "SELECT a.*" 
      . " FROM lifttracker.liftrec a"
      . "   INNER JOIN lifttracker.lift l ON l.id = a.liftid"
      . " WHERE l.enduserid = :enduserid"
      . "   AND l.id = :liftid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':liftid', $liftId, PDO::PARAM_INT);
    $stmt->execute();
    $table = $stmt->fetchAll();
    foreach ($table as $row) {
      $attempt = new Attempt();
      $attempt->initialize($row);
      $attempts[] = $attempt;
    }
    $stmt->closeCursor();
    return $attempts;
  }
  public function updateAttempt($userId, $attempt) {
    $conn = $this->createConnection();
    $query = "UPDATE lifttracker.liftrec a"
      . "   INNER JOIN lifttracker.lift l ON l.id = a.liftid"
      . " SET a.liftid = :liftid, a.occurrence = :occurrence, a.weight = :weight, a.reps = :reps"
      . " WHERE a.id = :attemptid"
      . "   AND l.enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':attemptid', $attempt->getId(), PDO::PARAM_INT);
    $stmt->bindValue(':liftid', $attempt->getLiftId(), PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':occurrence', Utils::toMySqlDate($attempt->getOccurrence()), PDO::PARAM_STR);
    $stmt->bindValue(':weight', $attempt->getWeight(), PDO::PARAM_STR);
    $stmt->bindValue(':reps', $attempt->getReps(), PDO::PARAM_INT);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
}
?>

