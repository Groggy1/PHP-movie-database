<?php
include 'class/arraytools.php';

$title = trim($_POST['title']);
$imdb = trim($_POST['imdbid']);

$sql = "DELETE FROM queue WHERE imdb = :imdb";
$param = array(':imdb' => $imdb);

$db -> select_query($sql, $param);

$sql = "SELECT * FROM movies WHERE title = :title";
$param = array(':title' => $title);

$count = $db -> select_query($sql, $param);

if (sizeof($count) == 0) {
	$ar = new ArrayTools();

	$directors = $ar -> pickvalues_to_array($_POST, 1, $_POST['directors']);
	$actors = $ar -> pickvalues_to_array($_POST, 100, $_POST['actors']);
	$genres = $ar -> pickvalues_to_array($_POST, 1000, $_POST['genres']);

	//Hämta hem postern -- http://www.phpriot.com/articles/download-with-curl-and-php
	$url = $_POST['poster'];
	$imgtitle = basename($url);
	$path = time() . '-' . $imgtitle;
	$fp = fopen('img/posters/' . $path, 'w');
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	$data = curl_exec($ch);
	curl_close($ch);
	fclose($fp);

	$sql = "INSERT INTO movies (imdbid, title, plot, year, poster, type, sub, runtime, date)
 VALUES(:imdbid, :title, :plot, :year, :path, :type, :sub, :runtime, now())";

	$param = array(':imdbid' => $_POST['imdbid'], ':title' => strip_tags($_POST['title']), ':plot' => strip_tags($_POST['plot']), ':year' => strip_tags($_POST['year']), ':path' => $path, ':type' => strip_tags($_POST['type']), ':sub' => strip_tags($_POST['sub']), ':runtime' => strip_tags($_POST['runtime']));

	$db -> select_query($sql, $param);
	$mid = $db -> lastInsertId('id');

	$genreparam = array();
	foreach ($genres as $value) {
		$genreparam[] = array(':genre' => strip_tags($value));
	}
	$actorparam = array();
	foreach ($actors as $value) {
		$actorparam[] = array(':actor' => strip_tags($value));
	}
	$directorparam = array();
	foreach ($directors as $value) {
		$directorparam[] = array(':director' => strip_tags($value));
	}

	########################################################
	#	Genres hanteras här								   #
	#	Ser till att mata in all data i databasen		   #
	########################################################

	$sql = "SELECT * FROM genres
		WHERE genre = :genre";
	$genreids = $db -> multi_query($sql, $genreparam);

	$genrenotindb = array_diff($ar -> flatten_array($genreparam), $ar -> flatten_array($genreids));

	$paraminsert = array();
	foreach ($genrenotindb as $value) {
		$paraminsert[] = array(':genre' => strip_tags($value));
	}

	$sql = "INSERT INTO genres (genre)
		VALUES(:genre)";

	$result = $db -> multi_query($sql, $paraminsert);
	$genrefromdbid = $db -> lastInsertId();

	$genreidstomovie = array();
	for ($i = $genrefromdbid - sizeof($result) + 1; $i <= $genrefromdbid; $i++) {
		$genresinmovies[] = array(':genreid' => (int)$i, ':movieid' => $mid);
	}

	$genreindb = $ar -> unique_flat_array(array_diff($ar -> flatten_array($genreids), $ar -> flatten_array($genreparam)));

	foreach ($genreindb as $value) {
		$genresinmovies[] = array(':genreid' => (int)$value, ':movieid' => $mid);
	}

	$sql = "INSERT INTO genresinmovies (movie_id, genre_id)
		VALUES (:movieid,:genreid)";

	$db -> multi_query($sql, $genresinmovies);

	########################################################
	#	Actors hanteras här								   #
	#	Ser till att mata in all data i databasen		   #
	########################################################

	$sql = "SELECT * FROM actors
		WHERE actor = :actor";

	$actorsinmovie = $db -> multi_query($sql, $actorparam);

	$actorsinmovienotdb = array_diff($ar -> flatten_array($actorparam), $ar -> flatten_array($actorsinmovie));

	$actorinsertparam = array();
	foreach ($actorsinmovienotdb as $value) {
		$actorinsertparam[] = array(':actor' => strip_tags($value));
	}

	$sql = "INSERT INTO actors (actor)
		VALUES (:actor)";

	$db -> multi_query($sql, $actorinsertparam);
	$actorid = $db -> lastInsertId();

	$actorsparam = array();
	for ($i = $actorid - sizeof($actorinsertparam) + 1; $i <= $actorid; $i++) {
		$actorsparam[] = array(':actor' => (int)$i, ':movieid' => $mid);
	}

	$actorsinmoviedb = $ar -> unique_flat_array(array_diff($ar -> flatten_array($actorsinmovie), $ar -> flatten_array($actorparam)));
	foreach ($actorsinmoviedb as $value) {
		$actorsparam[] = array(':actor' => (int)$value, ':movieid' => $mid);
	}

	$sql = "INSERT INTO actorsinmovies (movie_id,actor_id)
		VALUES (:movieid,:actor)";
	$db -> multi_query($sql, $actorsparam);

	########################################################
	#	Directors hanteras här							   #
	#	Ser till att mata in all data i databasen		   #
	########################################################

	$sql = "SELECT * FROM directors
		WHERE director = :director";

	$directorsindb = $db -> multi_query($sql, $directorparam);

	$directorsnotindb = array_diff($ar -> flatten_array($directorparam), $ar -> flatten_array($directorsindb));

	$directorsinsertdb = array();
	foreach ($directorsnotindb as $value) {
		$directorsinsertdb[] = array(':director' => strip_tags($value));
	}

	$sql = "INSERT INTO directors (director)
		VALUES (:director)";

	$db -> multi_query($sql, $directorsinsertdb);
	$dib = $db -> lastInsertId();

	$directorsparam = array();
	for ($i = $dib - sizeof($directorsinsertdb) + 1; $i <= $dib; $i++) {
		$directorsparam[] = array(':directorid' => (int)$i, ':movieid' => $mid);
	}

	echo '<br>directorsparam<pre>';
	var_dump($directorsparam);
	echo '</pre>';

	$directorsindb = $ar -> unique_flat_array(array_diff($ar -> flatten_array($directorsindb), $ar -> flatten_array($directorparam)));
	foreach ($directorsindb as $value) {
		$directorsparam[] = array(':directorid' => (int)$value, ':movieid' => $mid);
	}

	$sql = "INSERT INTO directorsinmovies (movie_id,director_id)
		VALUES (:movieid,:directorid)";

	$res = $db -> multi_query($sql, $directorsparam);

	header('Location:dispmovie.php?id=' . $mid);

} else {
	header('Location:dispmovie.php?id=' . $count[0][id]);
	break;
}
