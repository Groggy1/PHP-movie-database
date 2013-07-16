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
			<div class="page-header">
				<h1>Logga in <small>på FilmDB</small></h1>
			</div>
			<form class="form-inline" action="index.php" method="post">
				<input type="text" name="username" placeholder="Användarnamn" class="input-small">
				<input type="password" name="password" placeholder="Lösenord" class="input-small">
				<button class="btn" type="submit" name="login">
					Logga in
				</button>
			</form>
			<?php
			if (sizeof($login -> errors) > 0 || sizeof($login -> messages) > 0) {
				echo '<hr><ul>';
				foreach ($login -> errors as $value) {
					echo '<li>' . $value . '</li>';
				}
				foreach ($login -> messages as $value) {
					echo '<li>' . $value . '</li>';
				}
				echo '</ul>';
			}
			?>
		</div>
	</body>
</html>
<?php
break;
}

$sql = "SELECT id, title, poster
		FROM movies
		ORDER BY id DESC";
		
$movie = $db -> select_query($sql,array(),6,1);

$sitetitle = "Index";
require_once 'template/header.php';
?>
<script>
	$(document).ready(function() {
		$('.carousel').carousel({
			interval : 2000
		});
	}); 
</script>

<div id="carousel" class="carousel slide hero-unit">
	<div class="carousel-inner">
		<div class="item active">
			<div class="row-fluid no-space">
				<?php
				for ($i = 0; $i <= 2; $i++) {
					echo '<div class="span4"><a href="dispmovie.php?id=' . $movie[$i][id] . '"><img src="img/posters/' . $movie[$i][poster] . '" width = "100%" /></a></div>';
				}
				?>
			</div>
		</div>
		<div class="item">
			<div class="row-fluid no-space">
				<?php
				for ($i = 3; $i <= 5; $i++) {
					echo '<div class="span4"><a href="dispmovie.php?id=' . $movie[$i][id] . '"><img src="img/posters/' . $movie[$i][poster] . '" width = "100%" /></a></div>';
				}
				?>
			</div>
		</div>
	</div>
	<a class="carousel-control left" href="#carousel" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#carousel" data-slide="next">&rsaquo;</a>
</div>
<?php
require_once 'template/footer.php';