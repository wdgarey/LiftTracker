<?php
class Exercise {
  private $mId;
  private $mTitle;
  private $mDayId;
  private $mLiftId;
  private $mLiftTitle;
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
  public function getLiftTitle() {
    return $this->mLiftTitle;
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
  public function setLiftTitle($liftName) {
    $this->mLiftTitle = $liftName;
  }
  public function __construct() {
    $this->mId = null;
    $this->mTitle = null;
    $this->mDayId = null;
    $this->mLiftId = null;
    $this->mLiftTitle = null;
  }
  public function initialize($array) {
    $this->setId($array["id"]);
    $this->setTitle($array["title"]);
    $this->setDayId($array["dayid"]);
    $this->setLiftId($array["liftid"]);
    $this->mLiftTitle = null;
  }
  public function hasLiftTitle() {
    return ($this->mLiftTitle != null);
  }
}
?>

