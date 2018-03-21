<?php
class Lift {
  private $mId;
  private $mTitle;
  private $mTrainingWeight;
  public function getId() {
    return $this->mId;
  }
  public function getTitle() {
    return $this->mTitle;
  }
  public function getTrainingWeight() {
    return $this->mWeight;
  }
  public function setId($id) {
    $this->mId = $id;
  }
  public function setTitle($title) {
    $this->mTitle = $title;
  }
  public function setTrainingWeight($weight) {
    $this->mWeight = $weight;
  }
  public function __construct() {
    $this->mId = null;
    $this->mTitle = null;
    $this->mTrainingWeight = null;
  }
  public function initialize($array) {
    $this->setId($array["id"]);
    $this->setTitle($array["title"]);
    $this->setTrainingWeight($array["trainingweight"]);
  }
}
?>
