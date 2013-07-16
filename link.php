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

if (!empty($_GET['imdb'])) {
	$imdb = $_GET['imdb'];
} else {
	$imdb = "";
}

$sql = "SELECT * FROM movietype";
$movietype = $db -> select_query($sql);

$sitetitle = "L&auml;gg till film";
require_once 'template/header.php';
?>
<div class="hero-unit">
	<div class="row-fluid">
		<div class="span6">
			<form class="form-horizontal" name = "input" action = "imdbproxy.php" method = "post">
				<div class="form-horizontal">
					<div class="control-group">
						<div class="controls">
							<h5>H&auml;mta data fr&aring;n imdB</h5>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" id="inputImdbId">imdB ID</label>
						<div class="controls">
							<input type="text" name="imdbid" placeholder="imdB ID" value="<?php echo $imdb; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" id="inputSub">Textning</label>
						<div class="controls">
							<select name="sub">
								<option value="Ingen text, engelst tal">Ingen text, engelskt tal</option>
								<option value="Ingen text, svenskt tal">Ingen text, svenskt tal</option>
								<option value="Svensk text">Svensk text</option>
								<option value="Engelsk text">Engelsk text</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" id="inputType">Typ</label>
						<div class="controls">
							<select name="type">
								<?php
								foreach ($movietype as $value) {
									echo '<option value="' . $value['short'] . '">' . $value['type'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" type="submit">
							N&auml;sta
						</button>
					</div>
				</div>
				</div>
			</form>
		</div>
		<div class="span6">
			<form class="form-horizontal" name = "input" action = "manproxy.php" method = "post">
				<div class="form-horizontal">
					<div class="control-group">
						<div class="controls">
							<h5>Mata in data sj&auml;lv</h5>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" id="inputNumbersActors">Antal sk&aring;despelare</label>
						<div class="controls">
							<input type="text" name="actors" placeholder="Antal sk&aring;despelare" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" id="inputNumbersDirectors">Antal regis&ouml;rer</label>
						<div class="controls">
							<input type="text" name="directors" placeholder="Antal regis&ouml;rer" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" id="inputNumbersgenres">Antal genres</label>
						<div class="controls">
							<input type="text" name="genres" placeholder="Antal genres" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" id="inputType">Typ</label>
						<div class="controls">
							<select name="type">
								<?php
								foreach ($movietype as $value) {
									echo '<option value="' . $value['short'] . '">' . $value['type'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button class="btn btn-primary" type="submit">
								N&auml;sta
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
require_once 'template/footer.php';
