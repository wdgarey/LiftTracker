<?php
require_once("set.php");
require_once("repository.php");
require_once("utils.php");

class SetRepository extends Repository {
  private static $sInst;
  public static function getInstance() {
    if (SetRepository::$sInst == null) {
      SetRepository::$sInst = new SetRepository ();
    }
    return SetRepository::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function addSet($userId, $set) {
    $conn = $this->createConnection();
    $query = "INSERT INTO lifttracker.exerciseset (exerciseid, title, reps, percent)"
      . " SELECT e.id, :title, :reps, :percent"
      . " FROM lifttracker.plan p"
      . " INNER JOIN lifttracker.week w ON w.planid = p.id"
      . " INNER JOIN lifttracker.day d ON d.weekid = w.id"
      . " INNER JOIN lifttracker.exercise e ON e.dayid = d.id"
      . " WHERE p.enduserid = :enduserid"
      . " AND e.id = :exerciseid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':title', $set->getTitle(), PDO::PARAM_STR);
    $stmt->bindValue(':exerciseid', $set->getExerciseId(), PDO::PARAM_INT);
    $stmt->bindValue(':reps', $set->getReps(), PDO::PARAM_INT);
    $stmt->bindValue(':percent', $set->getPercent(), PDO::PARAM_STR);
    $stmt->execute();
    $lastId = null;
    if ($stmt->rowCount() == 1) {
      $lastId = $conn->lastInsertId();
    }
    $stmt->closeCursor();
    return $lastId;
  }
  public function deleteSets($userId, $setIds) {
    if (count($setIds) < 1) {
      return 0;
    }
    $conn = $this->createConnection();
    $query = "DELETE es.*"
      . " FROM lifttracker.exerciseset es"
      . " INNER JOIN lifttracker.exercise e ON e.id = es.exerciseid"
      . " INNER JOIN lifttracker.day d ON d.id = e.dayid"
      . " INNER JOIN lifttracker.week w ON w.id = d.weekid"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " WHERE p.enduserid = :enduserid"
      . " AND es.id IN (";
    $setCount = 1;
    foreach ($setIds as $setId) {
      if ($setCount == 1) {
        $query .= ":setid" . $setCount;
      } else {
        $query .= ", :setid" . $setCount;
      }
      $setCount += 1;
    }
    $query .= ");";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $setCount = 1;
    foreach ($setIds as $setId) {
      $stmt->bindValue(':setid' . $setCount, $setId, PDO::PARAM_INT);
      $setCount += 1;
    }
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
  public function getSet($userId, $setId) {
    $set = null;
    $conn = $this->createConnection ();
    $query = "SELECT es.*" 
      . " FROM lifttracker.exerciseset es"
      . " INNER JOIN lifttracker.exercise e ON e.id = es.exerciseid"
      . " INNER JOIN lifttracker.day d ON d.id = e.dayid"
      . " INNER JOIN lifttracker.week w ON w.id = d.weekid"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " WHERE p.enduserid = :enduserid"
      . " AND es.id = :setid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':setid', $setId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $sets = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($sets) == 1) {
      $set = new Set();
      $set->initialize($sets[0]);
    }
    return $set;
  }
  public function getSets($userId, $exerciseId) {
    $sets = array();
    $conn = $this->createConnection ();
    $query = "SELECT es.*" 
      . " FROM lifttracker.exerciseset es"
      . " INNER JOIN lifttracker.exercise e ON e.id = es.exerciseid"
      . " INNER JOIN lifttracker.day d ON d.id = e.dayid"
      . " INNER JOIN lifttracker.week w ON w.id = d.weekid"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " WHERE p.enduserid = :enduserid"
      . " AND e.id = :exerciseid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':exerciseid', $exerciseId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $table = $stmt->fetchAll();
    foreach ($table as $row) {
      $set = new Set();
      $set->initialize($row);
      $sets[] = $set;
    }
    $stmt->closeCursor();
    return $sets;
  }
  public function getPlanId($userId, $setId) {
    $planId = null;
    $conn = $this->createConnection ();
    $query = "SELECT p.id" 
      . " FROM lifttracker.plan p"
      . " INNER JOIN lifttracker.week w ON w.planid = p.id"
      . " INNER JOIN lifttracker.day d ON d.weekid = w.id"
      . " INNER JOIN lifttracker.exercise e ON e.dayid = d.id"
      . " INNER JOIN lifttracker.exerciseset es ON es.exerciseid = e.id"
      . " WHERE p.enduserid = :enduserid"
      . " AND es.id = :setid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':setid', $setId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $planIds = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($planIds) == 1) {
      $planId = $planIds[0]["id"];
    }
    return $planId;
  }
  public function updateSet($userId, $set) {
    $conn = $this->createConnection();
    $query = "UPDATE lifttracker.exerciseset es"
      . " INNER JOIN lifttracker.exercise e ON e.id = es.exerciseid"
      . " INNER JOIN lifttracker.day d ON d.id = e.dayid"
      . " INNER JOIN lifttracker.week w ON w.id = d.weekid"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " SET es.title = :title, es.exerciseid = :exerciseid, es.reps = :reps, es.percent = :percent"
      . " WHERE es.id = :setid"
      . " AND p.enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':setid', $set->getId(), PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':exerciseid', $set->getExerciseId(), PDO::PARAM_INT);
    $stmt->bindValue(':title', $set->getTitle(), PDO::PARAM_STR);
    $stmt->bindValue(':reps', $set->getReps(), PDO::PARAM_INT);
    $stmt->bindValue(':percent', $set->getPercent(), PDO::PARAM_STR);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
}
?>

