<?php
require_once("repository.php");
require_once("lift.php");

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
  public function addLift($userId, $lift) {
    $conn = $this->createConnection();
    $query = "INSERT INTO lifttracker.lift (enduserid, title, trainingweight)"
      . " VALUES (:enduserid, :title, :trainingweight)"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':title', $lift->getTitle(), PDO::PARAM_STR);
    $stmt->bindValue(':trainingweight', $lift->getTrainingWeight(), PDO::PARAM_STR);
    $stmt->execute();
    $lastId = null;
    if ($stmt->rowCount() == 1) {
      $lastId = $conn->lastInsertId();
    }
    $stmt->closeCursor();
    return $lastId;
  }
  public function deleteLifts($userId, $liftIds) {
    if (count($liftIds) < 1) {
      return 0;
    }
    $conn = $this->createConnection();
    $query = "DELETE FROM lifttracker.lift "
      . " WHERE enduserid = :enduserid";
      . " AND id IN (";
    $liftCount = 1;
    foreach ($liftIds as $liftId) {
      if (liftCount == 1) {
        $query .= ":liftid" . $liftCount
      } else {
        $query .= ", :liftid" . $liftCount
      }
      $liftCount += 1;
    }
    $query .= ");";
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $liftCount = 1;
    foreach ($liftIds as $liftId) {
      $stmt->bindValue(':liftid' . $liftCount, $liftId, PDO::PARAM_INT);
      $liftCount += 1;
    }
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
  public function getLift($userId, $liftId) {
    $lift = null;
    $conn = $this->createConnection ();
    $query = "SELECT *" 
      . " FROM lifttracker.lift"
      . " WHERE id = :liftid"
      . " AND enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':liftid', $liftId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $lifts = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($lifts) == 1) {
      $lift = new Lift();
      $lift->initialize($lifts[0]);
    }
    return $lift;
  }
  public function getLifts($userId) {
    $lifts = array();
    $conn = $this->createConnection ();
    $query = "SELECT *" 
      . " FROM lifttracker.lift"
      . " WHERE id = :userid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':userid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $table = $stmt->fetchAll();
    foreach ($table as $row) {
      $lift = new Lift();
      $lift->initialize($row);
      $lifts[] = $lift;
    }
    $stmt->closeCursor();
    return $lifts;
  }
  public function isExistingLift($userId, $title) {
    $isExisting = false;
    $conn = $this->createConnection ();
    $query = "SELECT *" 
      . " FROM lifttracker.lift"
      . " WHERE enduserid = :enduserid"
      . " AND title = :title"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->execute();
    $lifts = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($lifts) == 1) {
      $isExisting = true;
    }
    return $isExisting;
  }
  public function updateLift($userId, $lift) {
    $conn = $this->createConnection();
    $query = "UPDATE lifttracker.lift "
      . " SET title = :title, trainingweight = :traningweight"
      . " WHERE id = :liftid"
      . " AND enduserid = :enduserid"
      . ";";
    $stmt->bindValue(':liftid', $lift->getId(), PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':title', $lift->getTitle(), PDO::PARAM_STR);
    $stmt->bindValue(':trainingweight', $lift->getTrainingWeight(), PDO::PARAM_STR);
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
}
?>

