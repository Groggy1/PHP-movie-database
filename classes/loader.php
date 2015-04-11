<?php
/*
 * Project: Nathan MVC
 * File: /classes/loader.php
 * Purpose: class which maps URL requests to controller object creation
 * Author: Nathan Davison
 */

class Loader {

	private $controllerName;
	private $controllerClass;
	private $action;
	private $urlValues;

	//store the URL request values on object creation
	public function __construct($urlValues = false) {
		if (!$urlValues) {
			$this -> urlValues = $_GET;
		} else {
			$this -> urlValues = $urlValues;
		}
		
		if ($this -> urlValues['controller'] == "") {
			$this -> controllerName = "home";
			$this -> controllerClass = "HomeController";
			$this -> urlValues['controller'] = "home";
		} else {
			$this -> controllerName = strtolower($this -> urlValues['controller']);
			$this -> controllerClass = ucfirst(strtolower($this -> urlValues['controller'])) . "Controller";
		}

		if ($this -> urlValues['action'] == "") {
			$this -> action = "index";
			$this -> urlValues['action'] = "index";
		} else {
			$this -> action = $this -> urlValues['action'];
		}
	}

	//factory method which establishes the requested controller as an object
	public function createController() {
		//check our requested controller's class file exists and require it if so
		if (file_exists("controllers/" . $this -> controllerName . ".php")) {
			require ("controllers/" . $this -> controllerName . ".php");
		} else {
			require ("controllers/error.php");
			return new ErrorController("badurl", $this -> urlValues);
		}

		//does the class exist?
		if (class_exists($this -> controllerClass)) {
			$parents = class_parents($this -> controllerClass);

			//does the class inherit from the BaseController class?
			if (in_array("BaseController", $parents)) {
				//does the requested class contain the requested action as a method?
				if (method_exists($this -> controllerClass, $this -> action)) {
					return new $this->controllerClass($this -> action, $this -> urlValues);
				} else {
					//bad action/method error
					require ("controllers/error.php");
					return new ErrorController("badurl", $this -> urlValues);
				}
			} else {
				//bad controller error
				require ("controllers/error.php");
				return new ErrorController("badurl", $this -> urlValues);
			}
		} else {
			//bad controller error
			require ("controllers/error.php");
			return new ErrorController("badurl", $this -> urlValues);
		}
	}

}
?>
