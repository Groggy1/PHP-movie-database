<?php
$starting_time_measure = MICROTIME(TRUE);
require_once 'class/database.php';
require_once 'class/Login.php';
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

require_once 'class/display.php';

$display = new Display();

$sql = "SELECT id, name FROM users";

$users = $db -> select_query($sql);

$sql = "SELECT news.description, news.date, users.name FROM `news`
		JOIN users ON news.userid = users.id
		ORDER BY news.id DESC";

$result = $db -> select_query($sql, array(), 10, 1);

$sitetitle = "Nyheter";
require_once ('template/header.php');
?>
<div class="hero-unit">
	<div class="row-fluid">
		<div class="span9">
			<h5> Nyheter! </h5>
			<?php
			foreach ($result as $value) {
				echo "<p><strong>" . $value['name'] . "</strong>, " . $value['date'] . "</p><p>";
				echo nl2br($value['description']);
				echo "</p>";
			}
			?>
		</div>
		<div class="span3">
			<h5>L&auml;gg till nyhet</h5>
			<form name = "input" action = "addnews.php" method = "post">
				<?php $display -> dispselectuser($users); ?>
				<br />
				<textarea name="description" rows="10" placeholder="Vad har gjorts?"></textarea>
				<br />
				<input type="submit" value="submit" class="btn btn-primary" />
			</form>
		</div>
	</div>
</div>
<?php
require_once ('template/footer.php');