<?php
if (strlen($_POST['userid']) && strlen($_POST['description'])) {
	$sql = 'INSERT INTO news (userid, description, date)
			VALUES (:userid, :description, CURDATE())';

	$param = array(':userid' => $_POST['userid'], ':description' => strip_tags($_POST['description']));
	$db -> select_query($sql,$param);

	header("Location:news.php");
	break;
} else {
	$sitetitle = "Nyhets fel";
	require ('template/header.php');
	echo '<div class="hero-unit"><p>N&aring;got gick fel!</p></div>';
	require ('template/footer.php');
}