<?php
require_once("week.php");
require_once("repository.php");
require_once("utils.php");

class WeekRepository extends Repository {
  private static $sInst;
  public static function getInstance() {
    if (WeekRepository::$sInst == null) {
      WeekRepository::$sInst = new WeekRepository ();
    }
    return WeekRepository::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function addWeek($userId, $week) {
    $conn = $this->createConnection();
    $query = "INSERT INTO lifttracker.week (planid, title)"
      . " SELECT p.id, :title"
      . " FROM lifttracker.plan p"
      . " WHERE p.enduserid = :enduserid"
      . " AND p.id = :planid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':title', $week->getTitle(), PDO::PARAM_STR);
    $stmt->bindValue(':planid', $week->getPlanId(), PDO::PARAM_INT);
    $stmt->execute();
    $lastId = null;
    if ($stmt->rowCount() == 1) {
      $lastId = $conn->lastInsertId();
    }
    $stmt->closeCursor();
    return $lastId;
  }
  public function deleteWeeks($userId, $weekIds) {
    if (count($weekIds) < 1) {
      return 0;
    }
    $conn = $this->createConnection();
    $query = "DELETE w.*"
      . " FROM lifttracker.week w"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " WHERE p.enduserid = :enduserid"
      . " AND w.id IN (";
    $weekCount = 1;
    foreach ($weekIds as $weekId) {
      if ($weekCount == 1) {
        $query .= ":weekid" . $weekCount;
      } else {
        $query .= ", :weekid" . $weekCount;
      }
      $weekCount += 1;
    }
    $query .= ");";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $weekCount = 1;
    foreach ($weekIds as $weekId) {
      $stmt->bindValue(':weekid' . $weekCount, $weekId, PDO::PARAM_INT);
      $weekCount += 1;
    }
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
  public function getWeek($userId, $weekId) {
    $week = null;
    $conn = $this->createConnection ();
    $query = "SELECT w.*" 
      . " FROM lifttracker.week w"
      . " INNER JOIN lifttracker.plan p ON w.planid = p.id"
      . " WHERE w.id = :weekid"
      . " AND p.enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':weekid', $weekId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $weeks = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($weeks) == 1) {
      $week = new Week();
      $week->initialize($weeks[0]);
    }
    return $week;
  }
  public function getWeeks($userId, $planId) {
    $weeks = array();
    $conn = $this->createConnection ();
    $query = "SELECT w.*" 
      . " FROM lifttracker.week w"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " WHERE w.planid = :planid"
      . " AND p.enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':planid', $planId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $table = $stmt->fetchAll();
    foreach ($table as $row) {
      $week = new Week();
      $week->initialize($row);
      $weeks[] = $week;
    }
    $stmt->closeCursor();
    return $weeks;
  }
  public function updateWeek($userId, $week) {
    $conn = $this->createConnection();
    $query = "UPDATE lifttracker.week w"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " SET w.title = :title, w.planid = :planid"
      . " WHERE w.id = :weekid"
      . " AND p.enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':weekid', $week->getId(), PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':planid', $week->getPlanId(), PDO::PARAM_INT);
    $stmt->bindValue(':title', $week->getTitle(), PDO::PARAM_STR);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
}
?>

