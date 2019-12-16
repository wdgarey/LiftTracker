<?php
require_once("exercise.php");
require_once("repository.php");
require_once("utils.php");

class ExerciseRepository extends Repository {
  private static $sInst;
  public static function getInstance() {
    if (ExerciseRepository::$sInst == null) {
      ExerciseRepository::$sInst = new ExerciseRepository ();
    }
    return ExerciseRepository::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function addExercise($userId, $exercise) {
    $conn = $this->createConnection();
    $query = "INSERT INTO lifttracker.exercise (dayid, title, liftid)"
      . " SELECT d.id, :title, :liftid"
      . " FROM lifttracker.plan p"
      . " INNER JOIN lifttracker.week w ON w.planid = p.id"
      . " INNER JOIN lifttracker.day d ON d.weekid = w.id"
      . " WHERE p.enduserid = :enduserid"
      . " AND d.id = :dayid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':title', $exercise->getTitle(), PDO::PARAM_STR);
    $stmt->bindValue(':dayid', $exercise->getDayId(), PDO::PARAM_INT);
    $stmt->bindValue(':liftid', $exercise->getLiftId(), PDO::PARAM_INT);
    $stmt->execute();
    $lastId = null;
    if ($stmt->rowCount() == 1) {
      $lastId = $conn->lastInsertId();
    }
    $stmt->closeCursor();
    return $lastId;
  }
  public function deleteExercises($userId, $exerciseIds) {
    if (count($exerciseIds) < 1) {
      return 0;
    }
    $conn = $this->createConnection();
    $query = "DELETE e.*"
      . " FROM lifttracker.exercise e"
      . " INNER JOIN lifttracker.day d ON d.id = e.dayid"
      . " INNER JOIN lifttracker.week w ON w.id = d.weekid"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " WHERE p.enduserid = :enduserid"
      . " AND e.id IN (";
    $exerciseCount = 1;
    foreach ($exerciseIds as $exerciseId) {
      if ($exerciseCount == 1) {
        $query .= ":exerciseid" . $exerciseCount;
      } else {
        $query .= ", :exerciseid" . $exerciseCount;
      }
      $exerciseCount += 1;
    }
    $query .= ");";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $exerciseCount = 1;
    foreach ($exerciseIds as $exerciseId) {
      $stmt->bindValue(':exerciseid' . $exerciseCount, $exerciseId, PDO::PARAM_INT);
      $exerciseCount += 1;
    }
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
  public function getExercise($userId, $exerciseId) {
    $exercise = null;
    $conn = $this->createConnection ();
    $query = "SELECT e.*" 
      . " FROM lifttracker.exercise e"
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
    $exercises = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($exercises) == 1) {
      $exercise = new Exercise();
      $exercise->initialize($exercises[0]);
    }
    return $exercise;
  }
  public function getExercises($userId, $dayId) {
    $exercises = array();
    $conn = $this->createConnection ();
    $query = "SELECT e.*" 
      . " FROM lifttracker.exercise e"
      . " INNER JOIN lifttracker.day d ON d.id = e.dayid"
      . " INNER JOIN lifttracker.week w ON w.id = d.weekid"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " WHERE p.enduserid = :enduserid"
      . " AND e.dayid = :dayid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':dayid', $dayId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $table = $stmt->fetchAll();
    foreach ($table as $row) {
      $exercise = new Exercise();
      $exercise->initialize($row);
      $exercises[] = $exercise;
    }
    $stmt->closeCursor();
    return $exercises;
  }
  public function getPlanId($userId, $exerciseId) {
    $planId = null;
    $conn = $this->createConnection ();
    $query = "SELECT p.id" 
      . " FROM lifttracker.plan p"
      . " INNER JOIN lifttracker.week w ON w.planid = p.id"
      . " INNER JOIN lifttracker.day d ON d.weekid = w.id"
      . " INNER JOIN lifttracker.exercise e ON e.dayid = d.id"
      . " WHERE p.enduserid = :enduserid"
      . " AND e.id = :exerciseid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':exerciseid', $exerciseId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $planIds = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($planIds) == 1) {
      $planId = $planIds[0]["id"];
    }
    return $planId;
  }
  public function updateExercise($userId, $exercise) {
    $conn = $this->createConnection();
    $query = "UPDATE lifttracker.exercise e"
      . " INNER JOIN lifttracker.day d ON d.id = e.dayid"
      . " INNER JOIN lifttracker.week w ON w.id = d.weekid"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " SET e.title = :title, e.dayid = :dayid, e.liftid = :liftid"
      . " WHERE e.id = :exerciseid"
      . " AND p.enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':exerciseid', $exercise->getId(), PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':dayid', $exercise->getDayId(), PDO::PARAM_INT);
    $stmt->bindValue(':title', $exercise->getTitle(), PDO::PARAM_STR);
    $stmt->bindValue(':liftid', $exercise->getLiftId(), PDO::PARAM_INT);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
}
?>

