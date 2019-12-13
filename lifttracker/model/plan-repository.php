<?php
require_once("plan.php");
require_once("repository.php");
require_once("utils.php");

class PlanRepository extends Repository {
  private static $sInst;
  public static function getInstance() {
    if (PlanRepository::$sInst == null) {
      PlanRepository::$sInst = new PlanRepository ();
    }
    return PlanRepository::$sInst;
  }
  private function __construct() {
  }
  private function __clone() {
  }
  private function __wakeup() {
  }
  public function addPlan($userId, $plan) {
    $conn = $this->createConnection();
    $query = "INSERT INTO lifttracker.plan (enduserid, title)"
      . " VALUES (:enduserid, :title)"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':title', $plan->getTitle(), PDO::PARAM_STR);
    $stmt->execute();
    $lastId = null;
    if ($stmt->rowCount() == 1) {
      $lastId = $conn->lastInsertId();
    }
    $stmt->closeCursor();
    return $lastId;
  }
  public function deletePlans($userId, $planIds) {
    if (count($planIds) < 1) {
      return 0;
    }
    $conn = $this->createConnection();
    $query = "DELETE p.*"
      . " FROM lifttracker.plan p"
      . " WHERE p.enduserid = :enduserid"
      . " AND p.id IN (";
    $planCount = 1;
    foreach ($planIds as $planId) {
      if ($planCount == 1) {
        $query .= ":planid" . $planCount;
      } else {
        $query .= ", :planid" . $planCount;
      }
      $planCount += 1;
    }
    $query .= ");";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $planCount = 1;
    foreach ($planIds as $planId) {
      $stmt->bindValue(':planid' . $planCount, $planId, PDO::PARAM_INT);
      $planCount += 1;
    }
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
  public function getPlan($userId, $planId) {
    $plan = null;
    $conn = $this->createConnection ();
    $query = "SELECT p.*" 
      . " FROM lifttracker.plan p"
      . " WHERE p.id = :planid"
      . " AND p.enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':planid', $planId, PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $plans = $stmt->fetchAll();
    $stmt->closeCursor();
    if (count($plans) == 1) {
      $plan = new Plan();
      $plan->initialize($plans[0]);
    }
    return $plan;
  }
  public function getPlansUser($userId) {
    $plans = array();
    $conn = $this->createConnection ();
    $query = "SELECT p.*" 
      . " FROM lifttracker.plan p"
      . " WHERE p.enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $table = $stmt->fetchAll();
    foreach ($table as $row) {
      $plan = new Plan();
      $plan->initialize($row);
      $plans[] = $plan;
    }
    $stmt->closeCursor();
    return $plans;
  }
  public function updatePlan($userId, $plan) {
    $conn = $this->createConnection();
    $query = "UPDATE lifttracker.plan p"
      . " SET p.title = :title"
      . " WHERE p.id = :planid"
      . "   AND p.enduserid = :enduserid"
      . ";";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':planid', $plan->getId(), PDO::PARAM_INT);
    $stmt->bindValue(':enduserid', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':title', $plan->getTitle(), PDO::PARAM_STR);
    $stmt->execute();
    $rowCount = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowCount;
  }
}
?>

