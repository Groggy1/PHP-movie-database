<?php
include 'class/arraytools.php';
$ar = new Arraytools();

$antalfilmer = array_sum($ar -> unique_flat_array($db -> select_query("SELECT COUNT(movies.id) FROM movies")));

$sql = "SELECT count(*)
		FROM users
		JOIN towatch ON users.id = towatch.userid
		JOIN movies ON towatch.movieid = movies.id
		LEFT JOIN (SELECT userid, movieid, date FROM userviewed) AS UV ON UV.movieid = movies.id AND UV.userid = towatch.userid
		WHERE UV.date IS NULL
		ORDER BY users.name, towatch.date, movies.title";

$towatch = array_sum($ar -> unique_flat_array($db -> select_query($sql)));

$sql = "SELECT count(*)
		FROM users
		JOIN towatch ON users.id = towatch.userid
		JOIN movies ON towatch.movieid = movies.id
		LEFT JOIN (SELECT userid, movieid, date FROM userviewed) AS UV ON UV.movieid = movies.id AND UV.userid = towatch.userid
		WHERE UV.date IS NOT NULL
		ORDER BY users.name, towatch.date, movies.title";

$watchedtowatch = array_sum($ar -> unique_flat_array($db -> select_query($sql)));
$comments = array_sum($ar -> unique_flat_array($db -> select_query("SELECT COUNT(id) FROM usercomment")));
$watched = sizeof($db -> select_query("SELECT count(*) FROM userviewed GROUP BY movieid"));
$numberofnews = array_sum($ar -> unique_flat_array($db -> select_query("SELECT count(*) FROM news")));
$numberinqueue = array_sum($ar -> unique_flat_array($db -> select_query("SELECT count(*) FROM queue")));
$numberofactors = array_sum($ar -> unique_flat_array($db -> select_query("SELECT count(*) FROM actors")));
$numberofdirectors = array_sum($ar -> unique_flat_array($db -> select_query("SELECT count(*) FROM directors")));
$numberofgenres = array_sum($ar -> unique_flat_array($db -> select_query("SELECT count(*) FROM genres")));
$votes = $db -> select_query("SELECT avg(value), count(*) FROM uservote");
$movieswithoutruntime = array_sum($ar -> unique_flat_array($db -> select_query("SELECT count(id) FROM `movies` WHERE `runtime` = 0 AND imdbid != ''")));
$subtitle = $db -> select_query("SELECT sub,count(*) FROM movies GROUP BY  sub");

$sitetitle = "Statistik";
require_once 'template/header.php';
?>
<div class="hero-unit">
	<h2>Statistik</h2>
	<div class="row-fluid">
		<div class="span4">
			<h4>Filmer</h4>
			<?php
			echo '<p>Det finns <strong>' . $antalfilmer . '</strong> filmer i databasen</p>';
			echo '<p>Av dessa har <strong>' . $watched . '</strong> filmer setts';
			echo '<p><strong>' . $towatch . '</strong> filmer är markerade för att ses</p>';
			echo '<p><strong>' . $watchedtowatch . '</strong> filmer har varit markerade för att ses och setts</p>';
			echo '<p>Det finns <strong>' . $numberinqueue . '</strong> filmer i kö</p>';
			echo '<p><strong>' . $movieswithoutruntime . '</strong> filmer saknar speltid</p>';
			?>
		</div>
		<div class="span4">
			<h4>Filminnehåll</h4>
			<?php
			echo '<p>Filmerna har regiserats av <strong>' . $numberofdirectors . '</strong> olika regisörer</p>';
			echo '<p>I filmerna finns det totalt <strong>' . $numberofactors . '</strong> skådespelare</p>';
			echo '<p>Filmerna spänner över <strong>' . $numberofgenres . '</strong> olika genres</p>';
			for ($i = 0; $i <= 3; $i++) :
				echo '<p>Det finns <strong>' . $subtitle[$i][1] . '</strong> filmer med <strong>' . $subtitle[$i][0] . '</strong></p>';
			endfor;
			?>
		</div>
		<div class="span4">
			<h4>Användardata</h4>
			<?php
			echo '<p>Det har postats totalt <strong>' . $comments . '</strong> kommentar på filmerna</p>';
			echo '<p>Det har postats <strong>' . $numberofnews . '</strong> nyheter</p>';
			echo '<p>Det har lagts <strong>' . $votes[0][1] . '</strong> röster på filmerna</p>';
			echo '<p>Rösterna har ett genomsnitt på <strong>' . number_format($votes[0][0], 1) . '</strong> poäng</p>';
			?>
		</div>
	</div>
</div>
<?php
require_once 'template/footer.php';
