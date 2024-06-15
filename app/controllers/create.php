<?php

class Create extends Controller {

  public function index() {		
    $this->view('create/index');
  }

  public function create_user() { 
    $username = $_REQUEST['username'];
    $password1 = $_REQUEST['password1'];
    $password2 = $_REQUEST['password2'];

    $user = $this->model('User');

    $user->check_username_exists($username); 
   
    if (isset($_SESSION['username_exists']) && $_SESSION['username_exists'] == true) {
      header('location: /create');
    }

     else if ($password1 != $password2) {
      $_SESSION['password_mismatch'] = 1;
      header ('location: /create');
    }

    
    else if (strlen($password1) < 8) {
      $_SESSION['password_too_short'] = 1;
      header ('location: /create');
    }
    else { $user->add_user($username, $password1);
          $_SESSION['account_created'] = 1;
          unset($_SESSION['username_exists']);
          header('location: /login');
    }
  }
}