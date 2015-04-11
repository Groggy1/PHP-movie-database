<?php
/*
 * Project: Nathan MVC
 * File: /controllers/login.php
 * Purpose: controller for the home of the app.
 * Author: Nathan Davison
 */

class LoginController extends BaseController {
	//add to the parent constructor
	public function __construct($action, $urlValues) {
		parent::__construct($action, $urlValues);

		//create the model object
		require ("models/login.php");
		$this -> model = new LoginModel();
		$this -> model -> set('urlValues', $urlValues);
	}

	//default method
	protected function index() {
		$this -> view -> output($this -> model -> index());
	}
	
	protected function login() {
		$this -> view -> output($this -> model -> login());
	}
	
	protected function logout() {
		$this -> view -> output($this -> model -> logout());
	}

}
?>
