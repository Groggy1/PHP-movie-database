<?php
/*
 * Project: Nathan MVC
 * File: /controllers/home.php
 * Purpose: controller for the home of the app.
 * Author: Nathan Davison
 */

class MovieController extends BaseController {
	//add to the parent constructor
	public function __construct($action, $urlValues) {
		parent::__construct($action, $urlValues);

		//För att lösenordsskydda en sida ska Auth::handleLogin($urlValues); skrivas in på den/de delarna
		Auth::handleLogin($urlValues);

		//create the model object
		require ("models/movie.php");
		$this -> model = new MovieModel();
		$this -> model -> set('urlValues', $urlValues);
	}

	//default method
	protected function index() {
		$this -> view -> output($this -> model -> index());
	}

	protected function display() {
		$this -> view -> output($this -> model -> display());
	}

	protected function edit() {
		$this -> view -> output($this -> model -> edit());
	}

	protected function vote() {
		$this -> view -> output($this -> model -> vote());
	}

	protected function towatch() {
		$this -> view -> output($this -> model -> towatch());
	}

	protected function towatchagain() {
		$this -> view -> output($this -> model -> towatchagain());
	}

	protected function viewed() {
		$this -> view -> output($this -> model -> viewed());
	}

	protected function wall() {
		$this -> view -> output($this -> model -> wall());
	}

	protected function add() {
		$this -> view -> output($this -> model -> add());
	}

	protected function addcomment() {
		$param = array(':uid' => $_SESSION['user_id'], ':mid' => $_POST['mid'], ':comment' => strip_tags($_POST['comment']));
		$this -> model -> set('param', $param);
		$this -> view -> output($this -> model -> addcomment());
	}

	protected function removecomment() {
		$this -> view -> output($this -> model -> removecomment());
	}

	protected function makeedit() {
		$this -> model -> set('submit', $_POST['submit']);
		$this -> view -> output($this -> model -> makeedit());
	}

	protected function addimdb() {
		$this -> model -> set('imdbID', $_POST['imdbid']);
		$this -> model -> set('sub', $_POST['sub']);
		$this -> model -> set('type', $_POST['type']);
		$this -> view -> output($this -> model -> addimdb());
	}

	protected function publish() {
		$this -> view -> output($this -> model -> publish(), 0);
	}

	protected function addman() {
		$this -> model -> set('Nodir', trim($_POST['Nodir']));
		$this -> model -> set('Noact', trim($_POST['Noact']));
		$this -> model -> set('Nogen', trim($_POST['Nogen']));
		$this -> model -> set('sub', trim($_POST['sub']));
		$this -> model -> set('type', trim($_POST['type']));
		$this -> view -> output($this -> model -> addman());
	}

	protected function queue() {
		$this -> view -> output($this -> model -> queue());
	}

	protected function addqueue() {
		$this -> model -> set('imdbid', trim($_POST['imdbid']));
		$this -> model -> set('chars', strlen(trim($_POST['imdbid'])));
		$this -> view -> output($this -> model -> addqueue());
	}

	protected function stat() {
		$this -> view -> output($this -> model -> stat());
	}
}
?>
