<?php

/**
 * The function class.
 */
class Func {
  /**
   * The I.D.
   * @var int
   */
  private $id;
  /**
   * The name.
   * @var string 
   */
  private $name;
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
  public function getName() {
    return $this->mName;
  }
  /**
   * Sets the name.
   * @param string $name The name.
   */
  public function setName($name) {
    $this->mName = $name;
  }
  /**
   * Creates an instance of a function.
   */
  public function Func() {
    $this->mId = -;
    $this->mName = "";
  }
  /**
   * Initializes the function.
   * @param array $row The row of data.
   */
  public function initialize($row) {
    $idIdentifier = $this->getIdIdentifier();
    $nameIdentifier = $this->getNameIdentifier();
    if (isset($row[$idIdentifier])) {
      $id = $row[$idIdentifier];

      $this->setId($id);
    }
    if (isset($row[$nameIdentifier])) {
      $name = $row[$nameIdentifier];

      $this->setName($name);
    }
  }
  /**
   * Gets the function identifier.
   * @return string The identifier.
   */
  public function getIdentifier() {
    return "func";
  }
  /**
   * Gets the function I.D. identifier.
   * @return string The identifier.
   */
  public function getIdIdentifier() {
    return "id";
  }
  /**
   * Get the function name identifier.
   * @return string The identifier.
   */
  public function getNameIdentifier() {
    return "name";
  }
}

?>
