<?php

class Auth {

	public static function handleLogin($urlValues) {

		Session::init();

		// if user is still not logged in, then destroy session and handle user as "not logged in"
		if (!isset($_SESSION['user_logged_in']) || $_SESSION['site'] != SITE) {

			Session::destroy();
			// route user to login page
			//header('location: ' . URL . 'login');
			$loader = new Loader(array('controller' => 'login','action' => 'index','path' => $urlValues));
			$controller = $loader -> createController();
			$controller -> executeAction();
			break;
		}
	}

}
