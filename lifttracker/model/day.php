<?php
class Day {
  private $mId;
  private $mTitle;
  private $mWeekId;
  private $mExercies;
  public function getId() {
    return $this->mId;
  }
  public function getTitle() {
    return $this->mTitle;
  }
  public function getWeekId() {
    return $this->mWeekId;
  }
  public function getExercises() {
    return $this->mExercies;
  }
  public function setId($id) {
    $this->mId = $id;
  }
  public function setTitle($title) {
    $this->mTitle = $title;
  }
  public function setWeekId($weekId) {
    $this->mWeekId = $weekId;
  }
  public function setExercises($days) {
    $this->mExercies = $days;
  }
  public function __construct() {
    $this->mId = null;
    $this->mTitle = null;
    $this->mWeekId = null;
    $this->mExercies = null;
  }
  public function initialize($array) {
    $this->setId($array["id"]);
    $this->setTitle($array["title"]);
    $this->setWeekId($array["weekid"]);
    $this->mExercies = null;
  }
  public function hasExercies() {
    return ($this->mExercies != null);
  }
}
?>

