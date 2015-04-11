<?php
/*
 * Project: Nathan MVC
 * File: /models/login.php
 * Purpose: model for the home controller.
 * Author: Nathan Davison
 */

class LoginModel extends BaseModel {
	//data passed to the home index view
	public function index() {
		$this -> viewModel -> set('urlValues', $this -> get('urlValues'));
		$this -> viewModel -> set('pageTitle', TITLE . 'Logga in');
		return $this -> viewModel;
	}

	public function login() {
		if (!empty($_POST['username']) && !empty($_POST['password'])) {
			//Om användarnamn/lösenord matats in måste de kontroleras
			$sql = "SELECT id, name, password FROM " . DB_FLAG . "users
					WHERE BINARY name = :name";
			$param = array(':name' => $_POST['username']);

			$checklogin = $this -> db -> select_query($sql, $param);
			if (count($checklogin) == 1) {
				if (crypt($_POST['password'], $checklogin[0]['password']) == $checklogin[0]['password']) {
					Session::init();
					Session::set('user_id', $checklogin[0]['id']);
					Session::set('user_name', $checklogin[0]['name']);
					Session::set('user_logged_in', 1);
					Session::set('site', SITE);
					header('location: ' . $_POST['path']);
				} else {
					$this -> viewModel -> set('error[]', 'Fel användare/lösenord');
				}
			} else {
				$this -> viewModel -> set('error[]', 'Användarnamnet finns inte');
			}
		} else {
			$this -> viewModel -> set('error[]', 'Användarnamn eller lösenord saknas');
		}
		return $this -> viewModel;
	}

	public Function logout() {
		Session::init();
		Session::destroy();
		header('location: ' . URL);
	}

}
