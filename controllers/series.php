<?php
/*
 * Project: Nathan MVC
 * File: /controllers/home.php
 * Purpose: controller for the home of the app.
 * Author: Nathan Davison
 */

class SeriesController extends BaseController {
	//add to the parent constructor
	public function __construct($action, $urlValues) {
		parent::__construct($action, $urlValues);

		//För att lösenordsskydda en sida ska Auth::handleLogin($urlValues); skrivas in på den/de delarna
		Auth::handleLogin($urlValues);

		//create the model object
		require ("models/series.php");
		$this -> model = new SeriesModel();
		$this -> model -> set('urlValues', $urlValues);
	}

	//default method
	protected function index() {
		$this -> view -> output($this -> model -> index());
	}
	protected function display() {
		$this -> view -> output($this -> model -> display());
	}
	protected function create() {
		$this -> model -> set('submit', $_POST['submit']);
		$this -> view -> output($this -> model -> create());
	}
	protected function edit() {
		$this -> view -> output($this -> model -> edit());
	}
	protected function makeedit() {
		$this -> model -> set('submit', $_POST['submit']);
		$this -> view -> output($this -> model -> makeedit());
	}
	protected function remove() {
		$this -> view -> output($this -> model -> remove());
	}
}
?>
