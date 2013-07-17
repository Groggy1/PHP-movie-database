<?php
require_once 'class/Login.php';
require_once 'class/database.php';

$db = new Database();

$login = new Login($db);

if ($login -> isUserLoggedIn() == false) {
	$title = "Logga in";
	require_once 'views/login.php';
} else {
	require_once 'views/addnews.php';
}