<?php
class Repository {
  public function createConnection() {
    $conn = null;
    try {
      $conn = new PDO("mysql:host=localhost;dbname=lifttracker",
        "lifttrackerwebuser",
        "lifttrackerwebuser1234");
    } catch (PDOException $e) {
      echo ("Connection failed: " . $e->getMessage());
    }
    return $conn;
  }
}
?>

