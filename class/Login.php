<?php
//Inspired by http://www.php-login.net/
class Login {
	//object The database connection
	private $db = null;
	//int The user's id
	private $user_id = null;
	//string The user's name
	private $user_name = "";
	//string The user's hashed and salted password
	private $user_password_hash = "";
	private $user_is_logged_in = false;
	public $errors = array();
	public $messages = array();

	public function __construct($db) {
		$this -> db = $db;

		//create/read session
		session_start();

		/*
		 * check the possible login actions:
		 * 1. logout (happen when user clicks logout button)
		 * 2. login via session data (happens each time user opens a page on your php project AFTER he has successfully logged in via the login form)
		 * 3. login via post data, which means simply logging in via the login form. after the user has submit his login/password successfully, his
		 * logged-in-status is written into his session data on the server. this is the typical behaviour of common login scripts.
		 */

		//If user trued to log out
		if (isset($_GET["logout"])) {
			$this -> doLogout();
		} elseif (!empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)) {
			$this -> loginWithSessionData();
		} elseif (isset($_POST['login'])) {
			$this -> loginWithPostData();
		}
	}

	private function doLogout() {
		$_SESSION = array();
		session_destroy();
		$this -> user_is_logged_in = false;
		$this -> messages[] = "Du har blivit utloggad";
	}

	private function loginWithPostData() {
		// if POST data (from login form) contains non-empty user_name and non-empty user_password
		if (!empty($_POST['username']) && !empty($_POST['password'])) {
			$sql = "SELECT id, name, password FROM users
					WHERE BINARY name = :name";
			$param = array(':name' => $_POST['username']);
			$checklogin = $this -> db -> select_query($sql,$param);
			if(sizeof($checklogin) == 1 && crypt($_POST['password'],$checklogin[0]['password']) == $checklogin[0]['password']):
				$_SESSION['user_id'] = $checklogin[0]['id'];
				$_SESSION['user_name'] = $checklogin[0]['name'];
				$_SESSION['user_logged_in'] = 1;
				
				$this -> user_id = $checklogin[0]['id'];
				$this -> user_is_logged_in = true;
			else:
				$this->errors[] = "Fel användarnamn eller lösenord";
			endif;
		}
	}

	private function loginWithSessionData() {
		// set logged in status to true, because we just checked for this:
		// !empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)
		// when we called this method (in the constructor)
		$this -> user_is_logged_in = true;
	}
	
	public function isUserLoggedIn() {
		return $this -> user_is_logged_in;
	}

	public function query() {
		echo '<pre>';
		var_dump($this -> db -> select_query("SELECT * FROM movies LIMIT 1"));
		echo '</pre>';
	}

}
