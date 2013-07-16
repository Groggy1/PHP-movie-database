<?php
require_once 'class/Login.php';
require_once 'class/database.php';

$db = new Database();

$login = new Login($db);

if($login ->isUserLoggedIn() == false) {
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
		<link href="css/bootstrap-responsive.css" rel="stylesheet" />
	</head>
	<body>
		<div class="login">
			Du är inte inloggad! Gå till <a href="index.php">Startsidan</a> för att logga in.
		</div>
	</body>
</html>
<?php
break;
}

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