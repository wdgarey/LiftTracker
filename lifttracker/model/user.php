<?php
class User {
  private $mId;
  private $mUsername;
  private $mEmail;
  private $mVital;
  private $mFirstName;
  private $mLastName;
  private $mHeight;
  private $mWeight;
  public function getId() {
    return $this->mId;
  }
  public function getUsername() {
    return $this->mUsername;
  }
  public function getEmail() {
    return $this->mEmail;
  }
  public function getVital() {
    return $this->mVital;
  }
  public function getFirstName() {
    return $this->mFirstName;
  }
  public function getLastName() {
    return $this->mLastName;
  }
  public function getHeight() {
    return $this->mHeight;
  }
  public function getWeight() {
    return $this->mWeight;
  }
  public function setId($id) {
    $this->mId = $id;
  }
  public function setUsername($username) {
    $this->mUsername = $username;
  }
  public function setEmail($email) {
    $this->mEmail = $email;
  }
  public function setVital($vital) {
    $this->mVital = $vital;
  }
  public function setFirstName($firstName) {
    $this->mFirstName = $firstName;
  }
  public function setLastName($lastName) {
    $this->mLastName = $lastName;
  }
  public function setHeight($height) {
    $this->mHeight = $height;
  }
  public function setWeight($weight) {
    $this->mWeight = $weight;
  }
  public function __construct() {
    $this->mId = null;
    $this->mUsername = null;
    $this->mEmail = null;
    $this->mVital = null;
    $this->mFirstName = null;
    $this->mLastName = null;
    $this->mHeight = null;
    $this->mWeight = null;
  }
  public function initialize($array) {
    $this->setId($array["id"]);
    $this->setUsername($array["username"]);
    $this->setEmail($array["email"]);
    $this->setVital(boolval($array["vital"]));
    $this->setFirstName($array["firstname"]);
    $this->setLastName($array["lastname"]);
    $this->setHeight($array["height"]);
    $this->setWeight($array["weight"]);
  }
}
?>
