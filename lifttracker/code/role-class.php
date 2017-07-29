<?php

/**
 * A user role
 */
class Role {
  /**
   * The I.D.
   * @var int 
   */
  private $mId;
  /**
   * The name.
   * @var string 
   */
  private $mName;
  /**
   * Gets the I.D.
   * @return int The I.D.
   */
  public function getId() {
    return $this->mId;
  }
  /**
   * Sets the I.D.
   * @param int $id The I.D.
   */
  public function setId($id) {
    $this->mId = $id;
  }
  /**
   * Gets the name.
   * @return string The name.
   */
  public function GetName() {
    return $this->mName;
  }
  /**
   * Sets the name.
   * @param string $name The name.
   */
  public function SetName($name) {
    $this->mName = $name;
  }
  /**
   * Creates an instance of a role.
   */
  public function Role() {
    $this->mId = 0;
    $this->mName = "";
  }
  /**
   * Gets the roles identifier.
   * @return string The identifier.
   */
  public function getIdentifier() {
    return "role";
  }
  /**
   * Gets the role I.D. identifier.
   * @return string The identifier.
   */
  public function getIdIdentifier() {
    return "roleid";
  }
  /**
   * Gets the identifier of the name attribute.
   * @return string The identifier.
   */
  public function getNameIdentifier() {
    return "name";
  }
}
?>

