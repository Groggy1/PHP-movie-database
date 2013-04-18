<?php
$starting_time_measure = MICROTIME(TRUE);
require_once 'class/database.php';

$genre = filter_var($_GET['genre'], FILTER_SANITIZE_NUMBER_INT);
$year = filter_var($_GET['year'], FILTER_SANITIZE_NUMBER_INT);

$db = new Database();

$sql = "SELECT movies.id, movies.title, movies.year, genres.genre, genres.id as genreid FROM movies";

if (!empty($genre)) {
	$sql .= " JOIN (SELECT movie_id FROM genresinmovies WHERE genre_id = :genre) moviegenre ON movies.id = moviegenre.movie_id";
}

$sql .= " JOIN genresinmovies ON movies.id = genresinmovies.movie_id
			JOIN genres ON genresinmovies.genre_id = genres.id";

$in2 = array();
if (!empty($year)) {
	$sql .= " WHERE movies.year = :year";
}

if (!empty($genre)) {
	if (!empty($year)) {
		$param = array(':genre' => $genre, 'year' => $year);
	} else {
		$param = array(':genre' => $genre);
	}
} elseif (!empty($_GET['year'])) {
	$param = array(':year' => $year);
}

$sql .= " ORDER BY movies.title ASC, genres.genre ASC";

$result = $db -> select_query($sql, $param);

$i = 1;
foreach ($result as $key => $value) {
	if ($movies[$i]['title'] != $value['title']) {
		$k = 1;
		$i++;
		$movies[$i]['movieid'] = $value['id'];
		$movies[$i]['title'] = $value['title'];
		$movies[$i]['year'] = $value['year'];
		$movies[$i]['genre'][$k] = $value['genre'];
		$movies[$i]['genreid'][$k] = $value['genreid'];
	} else {
		$k++;
		$movies[$i]['genre'][$k] = $value['genre'];
		$movies[$i]['genreid'][$k] = $value['genreid'];
	}
}

$sitetitle = "Alla filmer";
require_once 'template/header.php';
?>
<div class="hero-unit">
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="40%">Film</th>
				<th width="10%">&Aring;r</th>
				<th width="50%">Genres</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($movies as $value) {
				echo '<tr><td><p><a href = "dispmovie.php?id=' . $value['movieid'] . '">' . $value['title'] . '</a></p></td>';
				echo '<td><p><a href="' . $filname;
				if (!empty($genre)) {
					echo '?genre=' . $genre . '&year=' . $value['year'];
				} else {
					echo '?year=' . $value['year'];
				}
				echo '">' . $value['year'] . '</a></p></td><td><p>';
				for ($i = 1; $i <= count($value['genre']); $i++) {
					echo '<a href="' . $filname;
					if (!empty($year)) {
						echo '?year=' . $year . '&genre=' . $value['genreid'][$i];
					} else {
						echo '?genre=' . $value['genreid'][$i];
					}
					echo '">' . $value['genre'][$i] . '</a>';
					if ($i != count($value['genre'])) {
						echo ', ';
					}
				}
				echo '</p></td></tr>';
			}
			?>
		</tbody>
	</table>
</div>
<?php
require_once 'template/footer.php';
