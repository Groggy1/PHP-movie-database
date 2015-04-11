<?php
/*
 * Project: Nathan MVC
 * File: /classes/basemodel.php
 * Purpose: abstract class from which models extend.
 * Author: Nathan Davison
 */

class BaseModel {

	protected $viewModel;
	protected $db;

	//create the base and utility objects available to all models on model creation
	public function __construct() {
		$this -> db = new Database();
		$this -> viewModel = new ViewModel();
		$this -> commonViewData();
	}

	//establish viewModel data that is required for all views in this method (i.e. the main template)
	protected function commonViewData() {
		//e.g. $this->viewModel->set("mainMenu",array("Home" => "/home", "Help" => "/help"));
	}

	public function set($name, $value) {
		$this -> $name = $value;
	}

	public function get($name) {
		return $this -> $name;
	}

}
?>
