<?php
//http://www.returnsuccess.com/post/15-PDO-class-Object-Oriented-PHP
class Database extends PDO {
	private $engine;
	private $host;
	private $database;
	private $user;
	private $pass;
	private $post;

	public function __construct() {
		$this -> engine = 'mysql';
		$this -> host = 'localhost';
		$this -> database = 'filmDB';
		$this -> user = 'root';
		$this -> pass = 'abc123';
		$this -> port = '3306';

		$dsn = $this -> engine . ':host=' . $this -> host . ';post=' . $this -> port . ';dbname=' . $this -> database;
		parent::__construct($dsn, $this -> user, $this -> pass);
	}

	public function alteration_query($query)
	/*  It returns an one row array containing
	 how many rows where affected and the
	 errors (if any)  */
	{
		$count = parent::exec($query);
		$error = parent::errorInfo();
		if ($error[0] == 00000)
			$error[2] = '';
		$resultarray = array('rows_affected' => $count, 'error' => $error[2]);
		return $resultarray;
	}

	public function select_query($query, $param = array(), $items_per_page = NULL, $page = NULL)
	/*  It returns an array containing all the items we asked for.
	 In case of an error it returns this array:
	 ('1'=>'false','2'=>'There was an error in sql syntax.')
	 $param is an array on form of: array(':placeholder' => $value)*/
	{
		if ($items_per_page != null) {
			if ($page == null) {
				$page = 1;
			}
			$limit = ' LIMIT ' . ($page - 1) * $items_per_page . ' , ' . $items_per_page;
		} else {
			$limit = '';
		}

		$stmnt = parent::prepare($query . $limit);
		if (!$stmnt -> execute($param)) {
			$result = array(1 => 'false', 2 => "There was an error in sql syntax.");
			return $result;
		}
		$result = $stmnt -> fetchAll();
		return $result;
	}

	public function multi_query($query, $param = array(array()))
	/*  It returns true/false depending on success of query.
	 $param is an array on form of: array(array(':placeholder' => 'value'))*/
	{
		$result = array();
		$stmnt = parent::prepare($query);
		foreach ($param as $value) {
			if (!$stmnt -> execute($value)) {
				return array("Fel!");
			}
			$value1 = $stmnt -> fetchAll();
			$result[] = $value1;
		}
		return $result;
	}

}
