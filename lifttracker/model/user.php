<?php
class User {
  private $mId;
  private $mUsername;
  private $mVital;
  public function getId() {
    return $this->mId;
  }
  public function getUsername() {
    return $this->mUsername;
  }
  public function getVital() {
    return $this->mVital;
  }
  public function setId($id) {
    $this->mId = $id;
  }
  public function setUsername($username) {
    $this->mUsername = $username;
  }
  public function setVital($vital) {
    $this->vital = $vital;
  }
  public function __construct() {
    $this->mId = null;
    $this->mUsername = null;
    $this->mVital = null;
  }
  public function initialize($array) {
    $this->setId($array["id"]);
    $this->setUsername($array["username"]);
    $this->setVital($array["vital"]);
  }
}
?>
