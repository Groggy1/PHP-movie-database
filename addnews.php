<?php
if (strlen($_POST['name']) && strlen($_POST['description'])) {
	require_once 'class/database.php';
	$db = new Database();
	$sql = 'INSERT INTO news (name, description, date)
			VALUES (:name, :description, CURDATE())';

	$param = array(':name' => $_POST['name'], ':description' => $_POST['description']);
	$db -> select_query($sql,$param);

	header("Location:news.php");
	break;
} else {
	$sitetitle = "Nyhets fel";
	require ('template/header.php');
	echo '<div class="hero-unit"><p>N&aring;got gick fel!</p></div>';
	require ('template/footer.php');
}