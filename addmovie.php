<?php
$starting_time_measure = MICROTIME(TRUE);
include 'class/database.php';
require_once 'class/Login.php';
$db = new Database();

$login = new Login($db);

if ($login -> isUserLoggedIn() == false) {
	$title = "Logga in";
	require_once 'views/login.php';
} else {
	require_once 'views/addmovie.php';
}