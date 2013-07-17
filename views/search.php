<?php
require_once 'class/arraytools.php';

$ar = new ArrayTools();

$ysql = "SELECT DISTINCT year FROM movies
		ORDER BY year DESC";
$gsql = "SELECT id, genre FROM genres
		ORDER BY genre ASC";

$year = $ar -> unique_flat_array($db -> select_query($ysql));
$genre = $db -> select_query($gsql);

$sitetitle = "S&ouml;k &aring;r/genre";
require_once ('template/header.php');
?>
<div class="hero-unit">
	<div class="row-fluid">
		<div class="span4">
			<p style="text-align: center">
				V&auml;lj &Aring;r och Genre
			</p>
			<form name = "input" action = "allmovies.php" method = "get" class="form-inline">
				<select name="year">
					<?php
					foreach ($year as $value) {
						echo "<option value=\"" . $value . "\">" . $value . "</option>";
					}
					?>
				</select>
				<select name="genre">
					<?php
					foreach ($genre as $value) {
						echo "<option value=\"" . $value[id] . "\">" . $value[genre] . "</option>";
					}
					?>
				</select>
				<button class="btn btn-primary" type="submit">
					N&auml;sta
				</button>
			</form>
		</div>
		<div class="span4">
			<p style="text-align: center">
				V&auml;lj Genre
			</p>
			<form name = "input" action = "allmovies.php" method = "get">
				<select name="genre">
					<?php
					foreach ($genre as $value) {
						echo "<option value=\"" . $value[id] . "\">" . $value[genre] . "</option>";
					}
					?>
				</select>
				<button class="btn btn-primary" type="submit">
					N&auml;sta
				</button>
			</form>
		</div>
		<div class="span4">
			<p style="text-align: center">
				V&auml;lj &Aring;r
			</p>
			<form name = "input" action = "allmovies.php" method = "get">
				<select name="year">
					<?php
					foreach ($year as $value) {
						echo "<option value=\"" . $value . "\">" . $value . "</option>";
					}
					?>
				</select>
				<button class="btn btn-primary" type="submit">
					N&auml;sta
				</button>
			</form>
		</div>
	</div>
</div>
<?php
require_once 'template/footer.php';
