<?php
class Exercise{
  private $mId;
  private $mTitle;
  private $mDayId;
  private $mLiftId;
  private $mLift;
  private $mSets;
  public function getId() {
    return $this->mId;
  }
  public function getTitle() {
    return $this->mTitle;
  }
  public function getDayId() {
    return $this->mDayId;
  }
  public function getLiftId() {
    return $this->mLiftId;
  }
  public function getLift() {
    return $this->mLift;
  }
  public function getSets() {
    return $this->mSets;
  }
  public function setId($id) {
    $this->mId = $id;
  }
  public function setTitle($title) {
    $this->mTitle = $title;
  }
  public function setDayId($dayId) {
    $this->mDayId = $dayId;
  }
  public function setLiftId($liftId) {
    $this->mLiftId = ($liftId == "" ? null : $liftId);
  }
  public function setLift($lift) {
    $this->mLift = $lift;
  }
  public function setSets($exercises) {
    $this->mSets = $exercises;
  }
  public function __construct() {
    $this->mId = null;
    $this->mTitle = null;
    $this->mDayId = null;
    $this->mLiftId = null;
    $this->mLift = null;
    $this->mSets = null;
  }
  public function initialize($array) {
    $this->setId($array["id"]);
    $this->setTitle($array["title"]);
    $this->setDayId($array["dayid"]);
    $this->setLiftId($array["liftid"]);
    $this->mLift = null;
    $this->mSets = null;
  }
  public function hasLift() {
    return ($this->mLift != null);
  }
  public function hasSets() {
    return ($this->mSets != null);
  }
}
?>

