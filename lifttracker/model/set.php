<?php
class Set {
  private $mId;
  private $mTitle;
  private $mExerciseId;
  private $mReps;
  private $mPercent;
  public function getId() {
    return $this->mId;
  }
  public function getTitle() {
    return $this->mTitle;
  }
  public function getExerciseId() {
    return $this->mExerciseId;
  }
  public function getReps() {
    return $this->mReps;
  }
  public function getPercent() {
    return $this->mPercent;
  }
  public function setId($id) {
    $this->mId = $id;
  }
  public function setTitle($title) {
    $this->mTitle = $title;
  }
  public function setExerciseId($exerciseId) {
    $this->mExerciseId = $exerciseId;
  }
  public function setReps($reps) {
    $this->mReps = $reps;
  }
  public function setPercent($percent) {
    $this->mPercent = $percent;
  }
  public function __construct() {
    $this->mId = null;
    $this->mTitle = null;
    $this->mExerciseId = null;
    $this->mReps = null;
    $this->mPercent = null;
  }
  public function initialize($array) {
    $this->setId($array["id"]);
    $this->setTitle($array["title"]);
    $this->setExerciseId($array["exerciseid"]);
    $this->setReps($array["reps"]);
    $this->setPercent($array["percent"]);
  }
}
?>

