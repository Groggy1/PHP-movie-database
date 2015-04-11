<?php
/*
 * Project: Nathan MVC
 * File: /controllers/movie.php
 * Purpose: controller for the home of the app.
 * Author: Nathan Davison
 */

class UserController extends BaseController {
	//add to the parent constructor
	public function __construct($action, $urlValues) {
		parent::__construct($action, $urlValues);

		//För att lösenordsskydda en sida ska Auth::handleLogin($urlValues); skrivas in på den/de delarna
		Auth::handleLogin($urlValues);

		//create the model object
		require ("models/user.php");
		$this -> model = new UserModel();
		$this -> model -> set('urlValues', $urlValues);
	}

	//default method
	protected function towatch() {
		$this -> view -> output($this -> model -> towatch());
	}

}
?>
