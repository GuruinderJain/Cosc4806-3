<?php

public function index() {		
  $this->view('create/index');
}

public function createUser() {  $username = $_REQUEST['username'];
      $password = $_REQUEST['password'];


      $user = $this->model('User');
      $user->checkUsernameExists($username); 
      // echo $_SESSION['test']; // for testing, yes this does call the fxn in User
      if (isset($_SESSION['usernameExists']) && $_SESSION['usernameExists'] == true) {
        echo "Username taken";
      }
    }
  }
