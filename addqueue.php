<?php
$starting_time_measure = MICROTIME(TRUE);
include ("class/imdb.php");
require_once 'class/database.php';
require_once 'class/arraytools.php';

if (empty($_POST['imdbid'])) {
	$sitetitle = "L&auml;gg till bevakning";
	require_once 'template/header.php';
	echo '<div class="hero-unit"><p>N&aring;got gick fel!</p></div>';
	require_once 'template/footer.php';
	break;
}

$db = new Database();

$sql = "SELECT id FROM movies
 WHERE imdbid = :imdbid";

$resultfrommovies = $db -> select_query($sql, array(':imdbid' => $_POST['imdbid']));

if (sizeof($resultfrommovies)) {
	header("Location:dispmovie.php?id=" . $resultfrommovies[0]['id']);
	break;
}

$sql = "SELECT id FROM queue
 WHERE imdb = :imdbid";

$resultfromqueue = $db -> select_query($sql, array(':imdbid' => $_POST['imdbid']));

if (sizeof($resultfromqueue)) {
	header("Location:queue.php");
	break;
}

$imdb = new Imdb();
$movieArray = $imdb -> getMovieInfoById($_POST['imdbid']);

if (!empty($movieArray['original_title'])) {
	$title = trim($movieArray['original_title']);
	echo "orig";
} else {
	$title = trim($movieArray['title']);
	echo "normal";
}

$year = $movieArray['year'];

$sql = "SELECT title FROM movies
		WHERE movies.title = :title
		UNION
		SELECT title FROM queue
		WHERE queue.title = :title";

$result = $db -> select_query($sql, array(':title' => $title));

if (sizeof($result) == 0) {
	$sql = "INSERT INTO queue (imdb , title, year, added)
	 VALUES (:imdbid, :title, :year, CURDATE())";

	$db -> select_query($sql, array(':imdbid' => $_POST['imdbid'], ':title' => $title, ':year' => $year));
	$mid = $db -> lastInsertId('id');

	foreach ($movieArray['genres'] as $genre) {
		$param[] = array(':genre' => $genre);
	}

	$sql = "SELECT id FROM genres
			WHERE genre = :genre";

	$result = $db -> multi_query($sql, $param);

	foreach ($result as $key => $value) {
		echo 'value<pre>';
		var_dump($value);
		echo '</pre>';
		echo sizeof($value);
		if (sizeof($value) == 0) {
			$insertparam[] = $param[$key];
		} else {
			$genreparam[] = $value[0];
		}
	}

	$sql = "INSERT INTO genres (genre)
			VALUES(:genre)";

	$db -> multi_query($sql, $insertparam);

	$gid = $db -> lastInsertId('id');

	for ($i = $gid - sizeof($insertparam) + 1; $i <= $gid; $i++) {
		$genreparam[] = $i;
	}

	$ar = new ArrayTools();

	$genres = $ar -> unique_flat_array($genreparam);

	foreach ($genres as $value) {
		$genresin[] = array(':gid' => $value, ':mid' => $mid);
	}
	
	$sql = "INSERT INTO genresinqueue (movie_id,genre_id)
			VALUES (:mid,:gid)";
			
	$db -> multi_query($sql,$genresin);
	header("Location:queue.php");
} else {
	$sql = "SELECT id FROM movies
			WHERE title = :title";

	$resultfrommovies = $db -> select_query($sql, array(':title' => $title));
	if (sizeof($resultfrommovies) > 0) {
		header("Location:dispmovie.php?id=" . $resultfrommovies[0]['id']);
		break;
	} else {
		header("Location:queue.php");
	}
}
