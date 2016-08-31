<?php
/*
 * Project: Nathan MVC
 * File: /models/home.php
 * Purpose: model for the home controller.
 * Author: Nathan Davison
 */

class HomeModel extends BaseModel {
	//data passed to the home index view
	public function index() {
		$posters = $this -> db -> select_query("SELECT `id`, `poster` FROM `movies` ORDER BY id DESC LIMIT 3");

		$this -> viewModel -> set("posters", $posters);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set("pageTitle", TITLE . "Index");
		return $this -> viewModel;
	}
}
?>
