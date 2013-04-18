<?php
$starting_time_measure = MICROTIME(TRUE);
$id = intval($_GET['id']);

if ($id == 0) {
	require_once 'template/header.php';
	echo '<div class="hero-unit"><p>N&aring;got gick fel!</p></div>';
	require_once 'template/footer.php';
	break;
}

require_once 'class/database.php';

$db = new Database();

$sql = "SELECT movies.title, movies.year, movies.poster, movies.plot, movies.sub, actors.actor, directors.director, movietype.type, genres.genre, genres.id as genreid
		FROM movies
		JOIN actorsinmovies ON movies.id = actorsinmovies.movie_id
		JOIN actors ON actors.id = actorsinmovies.actor_id
		JOIN directorsinmovies ON movies.id = directorsinmovies.movie_id
		JOIN directors ON directorsinmovies.director_id = directors.id
		JOIN movietype ON movies.type = movietype.short
		JOIN genresinmovies ON movies.id = genresinmovies.movie_id
		JOIN genres ON genresinmovies.genre_id = genres.id
		WHERE movies.id = :id";

$result = $db -> select_query($sql, array(':id' => $id));

$i = 0;
$j = 0;
$k = 0;
$l = 0;
$movie['actor'] = array();
$movie['director'] = array();
$movie['genre'] = array();
$movie['genreid'] = array();

foreach ($result as $key => $value) {
	if ($key == 0) {
		$movie['title'] = $value['title'];
		$movie['year'] = $value['year'];
		$movie['poster'] = $value['poster'];
		$movie['plot'] = $value['plot'];
		$movie['sub'] = $value['sub'];
		$movie['type'] = $value['type'];
	}
	if (!in_array($value['actor'], $movie['actor'])) {
		$movie['actor'][$i] = $value['actor'];
		$i++;
	}
	if (!in_array($value['director'], $movie['director'])) {
		$movie['director'][$j] = $value['director'];
		$j++;
	}
	if (!in_array($value['genre'], $movie['genre'])) {
		$movie['genre'][$k] = $value['genre'];
		$k++;
	}
	if (!in_array($value['genreid'], $movie['genreid'])) {
		$movie['genreid'][$l] = $value['genreid'];
		$l++;
	}
}

$sql = "SELECT id, name FROM users";

$users = $db -> select_query($sql);

$sql = "SELECT user_id, value FROM uservote
		WHERE movie_id = :movieid";

$votes = $db -> select_query($sql, array(':movieid' => $id));

$averagepoint = 0;
$numberofvoters = 0;

foreach ($votes as $value) {
	foreach ($users as $key => $value2) {
		if ($value2['id'] == $value['user_id']) {
			$users[$key]['value'] = $value['value'];
		}
	}
	$averagepoint += $value['value'];
	if (isset($value['value'])) {
		$numberofvoters++;
	}
}

$sql = "SELECT usercomment.comment, users.name, usercomment.date FROM usercomment
		JOIN users ON usercomment.userid = users.id
		WHERE usercomment.movieid = :id
		ORDER BY usercomment.date DESC";

$comments = $db -> select_query($sql, array(':id' => $id));

$sitetitle = $movie['title'] . " (" . $movie['year'] . ")";
require_once 'template/header.php';
?>
<div class="hero-unit">
	<h3><?php
	echo $movie['title'] . " (" . $movie['year'] . ")";
	?></h3>
	<p>
	<strong>Genres:</strong>
	<?php
	for ($i = 0; $i < count($movie['genreid']); $i++) {
		if ($i > 0) {
			echo ", ";
		}
		echo '<a href="allmovies.php?genre=' . $movie['genreid'][$i] . '">' . $movie['genre'][$i] . '</a>';
	}
	?>
	<strong>Spr&aring;k/texning</strong>:<?php echo $movie['sub']; ?>. <strong>Typ</strong>:<?php echo $movie['type']; ?> 
	<strong>Genomsnittspo&auml;ng</strong> <?php echo number_format($averagepoint / $numberofvoters, 1); ?></p>
</div>
<div class="hero-unit">
	<div class="row-fluid">
		<div class="span4">
			<img src="img/posters/<?php echo $movie['poster']; ?>" />
		</div>
		<div class="span8">
			<h4>Handling</h4>
			<?php
			echo '<p>' . $movie['plot'] . '</p>';
			?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span2">
			<h4>Sk&aring;despelare</h4>
			<p>
			<?php
			foreach ($movie['actor'] as $value) {
				echo $value . "<br>";
			}
			?>
			</p>
		</div>
		<div class="span2">
			<h4>Regis&ouml;rer</h4>
			<p>
			<?php
			foreach ($movie['director'] as $value) {
				echo $value . "<br>";
			}
			?>
			</p>
		</div>
		<div class="span3">
			<h4>Kommentarer</h4>
			<?php
			foreach ($comments as $value) {
				echo '<p><strong>'.$value['name'].'</strong> '.$value['date'].'</p>';
				echo '<p>'.$value['comment'].'</p>';
			}
			?>
		</div>
		<div class="span3">
			<h4>Kommentera filmen!</h4>
			<form class="form-horizontal" name = "input" action = "addvote.php" method = "post">
				<select name="userid">
					<?php
					foreach ($users as $value) {
						echo "<option value=\"" . $value['id'] . "\">" . $value['name'] . "</option>";
					}
					?>
				</select>
				<textarea name="comment" rows="10"></textarea>
				<input type="hidden" name="mid" value="<?php echo $id; ?>" />
				<button class="btn btn-primary" type="submit">L&auml;gg till kommentar</button>
			</form>
		</div>
		<div class="span2">
			<h4>Betygs&auml;tt filmen!</h4>
			<?php
			foreach ($users as $value) {
				echo '<p>' . $value['name'] . ': ';
				for ($i = 1; $i <= 5; $i++) {
					echo '<a href ="addvote.php?uid=' . $value['id'] . '&vote=' . $i . '&mid=' . $id . '"';
					if ($value['value'] == $i) {
						echo 'style = "text-decoration:underline;font-weight:bold">';
					} else {
						echo '>';
					}
					echo $i . '</a> ';
				}
				echo '</p>';
			}
			?>
		</div>
	</div>
</div>
<?php
require_once 'template/footer.php';
