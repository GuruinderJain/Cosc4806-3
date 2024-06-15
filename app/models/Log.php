<?php

class Log {

  public $username;
  public $success;
  public $time;
  public $current_fails = 0;
  public function __construct() {}
  
  public function log_attempt($username, $success, $time) {
    $db = db_connect();
    $statement = $db->prepare("INSERT INTO logs (username, success, time) VALUES (:username, :success, :time)");
    $statement->bindParam(':username', $username);
    $statement->bindParam(':success', $success);
    $statement->bindParam(':time', $time);
    $statement->execute();
  }
  public function count_fails($username) { 
    $db = db_connect();
    $statement = $db->prepare("SELECT COUNT(*) FROM (SELECT * FROM logs WHERE username = :username AND success = 0 AND time > :time) AS temp"); 
    $statement->bindParam(':username', $username);
    $statement->bindParam(':time', $this->success_time($username));
    $statement->execute();
    $rows = $statement->fetch(PDO::FETCH_ASSOC);                                        
    $this->current_fails = $rows['COUNT(*)'];                                              
  }

  
  public function success_time($username) {
    $db = db_connect();
    $statement = $db->prepare("SELECT time FROM logs WHERE username = :username AND success = 1 ORDER BY time DESC LIMIT 1");
    $statement->bindParam(':username', $username);
    $statement->execute();
    $rows = $statement->fetch(PDO::FETCH_ASSOC);
    if (!empty($rows)) {
      return $rows['time'];
    }
    else {
    
      return strtotime('1970-01-01 00:00:00');
    }
  }

  
  public function lock_time($username) {
    $db = db_connect();
    $statement = $db->prepare("SELECT time FROM logs WHERE username = :username AND success = 0 ORDER BY time DESC LIMIT 1");
    $statement->bindParam(':username', $username);
    $statement->execute();
    $rows = $statement->fetch(PDO::FETCH_ASSOC);
    $this->time = $rows['time'];
  }
}
?>