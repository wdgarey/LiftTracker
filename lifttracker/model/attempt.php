<?php
class Attempt {
  private $mId;
  private $mLiftId;
  private $mOccurrence;
  private $mWeight;
  private $mReps;
  public function getId() {
    return $this->mId;
  }
  public function getLiftId() {
    return $this->mLiftId;
  }
  public function getOccurrence() {
    return $this->mOccurrence;
  }
  public function getWeight() {
    return $this->mWeight;
  }
  public function getReps() {
    return $this->mReps;
  }
  public function setId($id) {
    $this->mId = $id;
  }
  public function setLiftId($liftId) {
    $this->mLiftId = $liftId;
  }
  public function setOccurrence($occurrence) {
    $this->mOccurrence = $occurrence;
  }
  public function setWeight($weight) {
    $this->mWeight = $weight;
  }
  public function setReps($reps) {
    $this->mReps = $reps;
  }
  public function __construct() {
    $this->mId = null;
    $this->mLiftId = null;
    $this->mOccurrence = null;
    $this->mWeight = null;
    $this->mReps = null;
  }
  public function initialize($array) {
    $this->setId($array["id"]);
    $this->setLiftId($array["liftid"]);
    $this->setOccurrence($array["occurrence"]);
    $this->setWeight($array["weight"]);
    $this->setReps($array["reps"]);
  }
}
?>

