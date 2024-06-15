<?php
session_start();
class Login extends Controller {

		public function index() {		
			$this->view('login/index');
		}

		public function verify() {
			$username = $_REQUEST['username'];
			$password = $_REQUEST['password'];
			$user = $this->model('User');

			$user->check_username_exists($username);
			if ($_SESSION['username_exists'] == 0) {
				header('location: /login');
			
			}

			$user->authenticate($username, $password); 
			if ($user->is_authenticated) {
				$_SESSION['auth'] = 1;
				$_SESSION['username'] = $username;
				unset($_SESSION['failedAuth']);
				echo "Authentication successful. Redirecting to home...";
				header('location: /home');
				die;
			}
			else {
				$_SESSION['password_incorrect'] = 1;
				if(isset($_SESSION['failedAuth'])) {
					$_SESSION['failedAuth'] ++; 
				} 
				else {
					$_SESSION['failedAuth'] = 1;
					echo "Password incorrect. Redirecting to login...";
				}
				header('location: /login.php');
				die;
			}

			$this->attempt($username);

			$this->lock(); 
		}

		
		public function attempt($username) {
			$log = $this->model('Log');

			if ($_SESSION['auth'] == 1) {
				$success = 1; 
			}
			else if (isset($_SESSION['failedAuth'])) {
				$success = 0;
			}
			date_default_timezone_set('America/Toronto');
			$date = date('Y-m-d H:i:s');
			$log->log_attempt($username, $success, $date);
		}

		
		public function lock() {
			$log = $this->model('Log');
			$log->count_fails($_SESSION['username']);
			
			if ($log->current_fails >= 3 || $_SESSION['failedAuth'] >= 3) {
				$_SESSION['locked'] = 1;
				 
				$log->lock_time($_SESSION['username']);
				$_SESSION['lock_start'] = $log->time;
				$_SESSION['lock_end'] = strtotime($_SESSION['lock_start']) + 60; 
			}
		}
}
?>