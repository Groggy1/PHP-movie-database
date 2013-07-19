<?php
$filname = pathinfo($_SERVER['PHP_SELF']);
$filname = $filname['basename'];
if(is_array($_GET)) {
	foreach ($_GET as $key => $value) {
		$filname .= '?' . $key . '=' . $value;
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $title; ?></title>
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
			<form class="form-inline" action="<?php  echo $filname; ?>" method="post">
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