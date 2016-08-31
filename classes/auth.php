<?php

class Auth {

	public static function handleLogin($urlValues) {
		if(!isset($_SESSION["user_logged_in"]) || $_SESSION['site'] != SITE){
			$loader = new Loader(array('controller' => 'login','action' => 'index','path' => $urlValues));
			$controller = $loader -> createController();
			$controller -> executeAction();
			die();
		}
	}

}
