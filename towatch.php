<?php
$starting_time_measure = MICROTIME(TRUE);
require_once 'class/database.php';
$db = new Database();

$sql = "SELECT users.name, movies.title, movies.id AS mid
		FROM users
		JOIN towatch ON users.id = towatch.userid
		JOIN movies ON towatch.movieid = movies.id
		LEFT JOIN (SELECT userid, movieid, date FROM userviewed) AS UV ON UV.movieid = movies.id AND UV.userid = towatch.userid
		WHERE UV.date IS NULL
		ORDER BY users.name, towatch.date, movies.title";

$result = $db -> select_query($sql);

foreach ($result as $key => $value) {
	$toprint[$value["name"]][$key]["title"] = $value["title"];
	$toprint[$value["name"]][$key]["mid"] = $value["mid"];
}

$sitetitle = 'Filmer att se';
require_once 'template/header.php';
?>
<div class="hero-unit">
	<div class="row-fluid no-space">
		<div class="offset1 span2">
			<table class="table table-striped">
				<tr>
					<th>Erik</th>
				</tr>
				<?php
				if(is_array($toprint)):
				foreach ($toprint as $key => $value) :
					if ($key == "Erik") :
						foreach ($value as $key => $value2) :
							echo '<tr><td><a href = "dispmovie.php?id=' . $value2['mid'] . '">' . $value2['title'] . '</a></td></tr>';
						endforeach;
					endif;
				endforeach;
				endif;
				?>
			</table>
		</div>
		<div class="span2">
			<table class="table table-striped">
				<tr>
					<th>Evelina</th>
				</tr>
				<?php
				if(is_array($toprint)):
				foreach ($toprint as $key => $value) :
					if ($key == "Evelina") :
						foreach ($value as $key => $value2) :
							echo '<tr><td><a href = "dispmovie.php?id=' . $value2['mid'] . '">' . $value2['title'] . '</a></td></tr>';
						endforeach;
					endif;
				endforeach;
				endif;
				?>
			</table>
		</div>
		<div class="span2">
			<table class="table table-striped">
				<tr>
					<th>Karin</th>
				</tr>
				<?php
				if(is_array($toprint)):
				foreach ($toprint as $key => $value) :
					if ($key == "Karin") :
						foreach ($value as $key => $value2) :
							echo '<tr><td><a href = "dispmovie.php?id=' . $value2['mid'] . '">' . $value2['title'] . '</a></td></tr>';
						endforeach;
					endif;
				endforeach;
				endif;
				?>
			</table>
		</div>
		<div class="span2">
			<table class="table table-striped">
				<tr>
					<th>Oskar</th>
				</tr>
				<?php
				if(is_array($toprint)):
				foreach ($toprint as $key => $value) :
					if ($key == "Oskar") :
						foreach ($value as $key => $value2) :
							echo '<tr><td><a href = "dispmovie.php?id=' . $value2['mid'] . '">' . $value2['title'] . '</a></td></tr>';
						endforeach;
					endif;
				endforeach;
				endif;
				?>
			</table>
		</div>
		<div class="span2">
			<table class="table table-striped">
				<tr>
					<th>Stefan</th>
				</tr>
				<?php
				if(is_array($toprint)):
				foreach ($toprint as $key => $value) :
					if ($key == "Stefan") :
						foreach ($value as $key => $value2) :
							echo '<tr><td><a href = "dispmovie.php?id=' . $value2['mid'] . '">' . $value2['title'] . '</a></td></tr>';
						endforeach;
					endif;
				endforeach;
				endif;
				?>
			</table>
		</div>
	</div>
</div>
<?php
require_once 'template/footer.php';
