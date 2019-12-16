<?php
class Day {
  private $mId;
  private $mTitle;
  private $mWeekId;
  private $mExercises;
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
    return $this->mExercises;
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
  public function setExercises($exercises) {
    $this->mExercises = $exercises;
  }
  public function __construct() {
    $this->mId = null;
    $this->mTitle = null;
    $this->mWeekId = null;
    $this->mExercises = null;
  }
  public function initialize($array) {
    $this->setId($array["id"]);
    $this->setTitle($array["title"]);
    $this->setWeekId($array["weekid"]);
    $this->mExercises = null;
  }
  public function hasExercises() {
    return ($this->mExercises != null);
  }
}
?>

