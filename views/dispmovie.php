<?php
$id = intval($_GET['id']);

if ($id == 0) {
	require_once 'template/header.php';
	echo '<div class="hero-unit"><p>N&aring;got gick fel!</p></div>';
	require_once 'template/footer.php';
	break;
}

require_once 'class/arraytools.php';
require_once 'class/display.php';

$display = new Display();
$ar = new ArrayTools();

$sql = "SELECT movies.imdbid, movies.runtime, movies.title, movies.year, movies.poster, movies.plot, movies.sub, actors.actor, directors.director, movietype.type, genres.genre, genres.id as genreid
		FROM movies
		LEFT JOIN actorsinmovies ON movies.id = actorsinmovies.movie_id
		LEFT JOIN actors ON actors.id = actorsinmovies.actor_id
		LEFT JOIN directorsinmovies ON movies.id = directorsinmovies.movie_id
		LEFT JOIN directors ON directorsinmovies.director_id = directors.id
		LEFT JOIN movietype ON movies.type = movietype.short
		LEFT JOIN genresinmovies ON movies.id = genresinmovies.movie_id
		LEFT JOIN genres ON genresinmovies.genre_id = genres.id
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
		$movie['title'] = ($value['title']);
		$movie['year'] = ($value['year']);
		$movie['poster'] = ($value['poster']);
		$movie['plot'] = nl2br(($value['plot']));
		$movie['sub'] = ($value['sub']);
		$movie['type'] = ($value['type']);
		$movie['imdbid'] = ($value['imdbid']);
		$movie['runtime'] = ($value['runtime']);
	}
	if (!in_array($value['actor'], $movie['actor'])) {
		$movie['actor'][$i] = ($value['actor']);
		$i++;
	}
	if (!in_array($value['director'], $movie['director'])) {
		$movie['director'][$j] = ($value['director']);
		$j++;
	}
	if (!in_array($value['genre'], $movie['genre'])) {
		$movie['genre'][$k] = ($value['genre']);
		$k++;
	}
	if (!in_array($value['genreid'], $movie['genreid'])) {
		$movie['genreid'][$l] = ($value['genreid']);
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
		ORDER BY usercomment.date, usercomment.id DESC";

$comments = $db -> select_query($sql, array(':id' => $id));

$sql = "SELECT userid FROM userviewed
		WHERE movieid = :id";

$viewed = $ar -> unique_flat_array($db -> select_query($sql, array(':id' => $id)));

$sql = "SELECT userid FROM towatch
		WHERE movieid = :id";
		
$towatch = $ar -> unique_flat_array($db -> select_query($sql, array(':id' => $id)));

$sitetitle = $movie['title'] . " (" . $movie['year'] . ")";
require_once 'template/header.php';
?>
<div class="hero-unit">
	<h3><?php
	if (!empty($movie['imdbid'])) {
		echo '<a href="http://www.imdb.com/title/' . $movie['imdbid'] . '" target="blank">';
	}
	echo $movie['title'];
	if (!empty($movie['imdbid'])) {
		echo '</a>';
	}
	echo " (" . $movie['year'] . ")";
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
		<strong>Spr&aring;k/texning</strong>:<?php echo $movie['sub']; ?>.
		<strong>Typ</strong>:<?php echo $movie['type']; ?>
		<strong>Genomsnittspo&auml;ng:</strong>
		<?php
		if (count($votes) > 0) {
			echo number_format($averagepoint / $numberofvoters, 1);
		} else {
			echo 'Inga röster';
		}
	?>
	<strong>Speltid:</strong>
	<?php
	echo $movie['runtime'].' minuter';
	?>
	</p>
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
		<div class="span2">
			<h4>Kommentarer</h4>
			<?php
			foreach ($comments as $value) {
				echo '<p><strong>' . $value['name'] . '</strong> ' . $value['date'] . '</p>';
				echo '<p>' . nl2br($value['comment']) . '</p>';
			}
			?>
		</div>
		<div class="span3">
			<h4>Kommentera filmen!</h4>
			<form class="form-horizontal" name = "input" action = "usermovie.php" method = "post">
				<?php $display -> dispselectuser($users); ?>
				<textarea name="comment" rows="10"></textarea>
				<input type="hidden" name="mid" value="<?php echo $id; ?>" />
				<input type="hidden" name="action" value="1" />
				<button class="btn btn-primary" type="submit">
					L&auml;gg till kommentar
				</button>
			</form>
		</div>
		<div class="span3">
			<h4>Betygs&auml;tt filmen!</h4>
			<table><tr><td>Namn</td><td>Sedd</td><td>Betyg</td><td>Att se</td></tr>
			<?php
			foreach ($users as $key => $value) :
				echo '<tr><td>' . $value['name'] . '</td><td align="center">';
				if (in_array($key + 1, $viewed)) {
					echo ' <i class =" icon-ok"></i>';
				} else {
					echo ' <a href="usermovie.php?action=2&uid=' . $value['id'] . '&mid=' . $id . '"><i class =" icon-remove"></i></a>';
				}
				echo '</td><td>';
				for ($i = 1; $i <= 5; $i++) :
					echo '<a href ="usermovie.php?action=3&uid=' . $value['id'] . '&vote=' . $i . '&mid=' . $id . '"';
					if ($value['value'] == $i) {
						echo 'style = "text-decoration:underline;font-weight:bold">';
					} else {
						echo '>';
					}
					echo $i . '</a> ';
				endfor;
				echo '</td><td align="center">';
				if (in_array($key + 1, $towatch)) {
					echo ' <i class =" icon-ok"></i>';
				} else {
					if (in_array($key + 1, $viewed)) {
						echo '<i class =" icon-remove"></i>';
					} else {
						echo '<a href="usermovie.php?action=4&uid=' . $value['id'] . '&mid=' . $id . '"><i class =" icon-remove"></i></a>';
					}
				}
				echo '</td></tr>';
			endforeach;
			?>
			</table>
		</div>
	</div>
</div>
<?php
require_once 'template/footer.php';
