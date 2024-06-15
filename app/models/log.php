<?php

class Log {

  public $username;
  public $success;
  public $time;

  public function log_attempt($username, $success, $time) {
    $db = db_connect();
    $statement = $db->prepare("INSERT INTO logs (username, success, time) VALUES (:username, :success, :time)");
    $statement->bindParam(':username', $username);
    $statement->bindParam(':success', $success);
    $statement->bindParam(':time', $time);
    $statement->execute();
  }

}
?>