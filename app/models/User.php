  <?php

  class User {

    public $username;
    public $password;
    public $auth = false;

    public function __construct() {

    }

    public function test () {
      $db = db_connect();
      $statement = $db->prepare("select * from users;");
      $statement->execute();
      $rows = $statement->fetch(PDO::FETCH_ASSOC);
      return $rows;
    }

    public function authenticate($username, $password) {
        /*
         * if username and password good then
         * $this->auth = true;
         */
      $username = strtolower($username);
      $db = db_connect();
          $statement = $db->prepare("select * from users WHERE username = :name;");
          $statement->bindValue(':name', $username);
          $statement->execute();
          $rows = $statement->fetch(PDO::FETCH_ASSOC);

      if (password_verify($password, $rows['password'])) {
        $this->is_authenticated = true;
      }
      }
    public function check_username_exists($username) {
      $db = db_connect();
      $statement = $db->prepare("SELECT username FROM users WHERE username = :username");
      $statement->bindValue(':username', $username);
      $statement->execute(); 
      $row = $statement->fetch(PDO::FETCH_ASSOC);
      if (!empty($row)) { 
        $_SESSION['username_exists'] = 1;
      }
      else {
        $_SESSION['username_exists'] = 0;
      }
    }

   
    public function add_user($username, $password) {
      $db = db_connect();
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $statement = $db->prepare("INSERT into users (username, password) VALUES ('$username','$hashed_password')");
      $statement->execute();
    }

  }