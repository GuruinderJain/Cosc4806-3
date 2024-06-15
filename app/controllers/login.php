<?php

class Login extends Controller {

    public function index() {		
	    $this->view('login/index');
    }
    
    public function verify(){
			$username = $_REQUEST['username'];
			$password = $_REQUEST['password'];
		
			$user = $this->model('User');
			$user->check_username_exists($username);
			if (isset($_SESSION['username_exists']) && $_SESSION['username_exists'] == 0) {
				header('location: /login');
				die;
			}
			$user->authenticate($username, $password); 
    }

}
