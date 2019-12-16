<?php
require_once("day.php");
require_once("repository.php");
require_once("utils.php");

class DayRepository extends Repository {
  private static $sInst;
  public static function getInstance() {
    if (DayRepository::$sInst == null) {
      DayRepository::$sInst = new DayRepository ();
    }
    return DayRepository::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function addDay($userId, $day) {
    $conn = $this->createConnection();
    $query = "INSERT INTO lifttracker.day (weekid, title)"
      . " SELECT w.id, :title"
      . " FROM lifttracker.plan p"
      . " INNER JOIN lifttracker.week w ON w.planid = p.id"
      . " WHERE p.enduserid = :enduserid"
      . " AND w.id = :weekid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':title', $day->getTitle(), PDO::PARAM_STR);
    $stmt->bindValue(':weekid', $day->getWeekId(), PDO::PARAM_INT);
    $stmt->execute();
    $lastId = null;
    if ($stmt->rowCount() == 1) {
      $lastId = $conn->lastInsertId();
    }
    $stmt->closeCursor();
    return $lastId;
  }
  public function deleteDays($userId, $dayIds) {
    if (count($dayIds) < 1) {
      return 0;
    }
    $conn = $this->createConnection();
    $query = "DELETE d.*"
      . " FROM lifttracker.day d"
      . " INNER JOIN lifttracker.week w ON w.id = d.weekid"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " WHERE p.enduserid = :enduserid"
      . " AND d.id IN (";
    $dayCount = 1;
    foreach ($dayIds as $dayId) {
      if ($dayCount == 1) {
        $query .= ":dayid" . $dayCount;
      } else {
        $query .= ", :dayid" . $dayCount;
      }
      $dayCount += 1;
    }
    $query .= ");";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $dayCount = 1;
    foreach ($dayIds as $dayId) {
      $stmt->bindValue(':dayid' . $dayCount, $dayId, PDO::PARAM_INT);
      $dayCount += 1;
    }
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
  public function getDay($userId, $dayId) {
    $day = null;
    $conn = $this->createConnection ();
    $query = "SELECT d.*" 
      . " FROM lifttracker.day d"
      . " INNER JOIN lifttracker.week w ON w.id = d.weekid"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " WHERE p.enduserid = :enduserid"
      . " AND d.id = :dayid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':dayid', $dayId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $days = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($days) == 1) {
      $day = new Day();
      $day->initialize($days[0]);
    }
    return $day;
  }
  public function getDays($userId, $weekId) {
    $days = array();
    $conn = $this->createConnection ();
    $query = "SELECT d.*" 
      . " FROM lifttracker.day d"
      . " INNER JOIN lifttracker.week w ON w.id = d.weekid"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " WHERE p.enduserid = :enduserid"
      . " AND d.weekid = :weekid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':weekid', $weekId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $table = $stmt->fetchAll();
    foreach ($table as $row) {
      $day = new Day();
      $day->initialize($row);
      $days[] = $day;
    }
    $stmt->closeCursor();
    return $days;
  }
  public function getPlanId($userId, $dayId) {
    $planId = null;
    $conn = $this->createConnection ();
    $query = "SELECT p.id" 
      . " FROM lifttracker.plan p"
      . " INNER JOIN lifttracker.week w ON w.planid = p.id"
      . " INNER JOIN lifttracker.day d ON d.weekid = w.id"
      . " WHERE p.enduserid = :enduserid"
      . " AND d.id = :dayid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':dayid', $dayId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $planIds = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($planIds) == 1) {
      $planId = $planIds[0]["id"];
    }
    return $planId;
  }
  public function updateDay($userId, $day) {
    $conn = $this->createConnection();
    $query = "UPDATE lifttracker.day d"
      . " INNER JOIN lifttracker.week w ON w.id = d.weekid"
      . " INNER JOIN lifttracker.plan p ON p.id = w.planid"
      . " SET d.title = :title, d.weekid = :weekid"
      . " WHERE d.id = :dayid"
      . " AND p.enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':dayid', $day->getId(), PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':weekid', $day->getWeekId(), PDO::PARAM_INT);
    $stmt->bindValue(':title', $day->getTitle(), PDO::PARAM_STR);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
}
?>

