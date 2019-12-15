<?php
class Week {
  private $mId;
  private $mTitle;
  private $mPlanId;
  public function getId() {
    return $this->mId;
  }
  public function getTitle() {
    return $this->mTitle;
  }
  public function getPlanId() {
    return $this->mPlanId;
  }
  public function setId($id) {
    $this->mId = $id;
  }
  public function setTitle($title) {
    $this->mTitle = $title;
  }
  public function setPlanId($planId) {
    $this->mPlanId = $planId;
  }
  public function __construct() {
    $this->mId = null;
    $this->mTitle = null;
    $this->mPlanId = null;
  }
  public function initialize($array) {
    $this->setId($array["id"]);
    $this->setTitle($array["title"]);
    $this->setPlanId($array["planid"]);
  }
}
?>

