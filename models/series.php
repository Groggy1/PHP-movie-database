<?php
/*
 * Project: Nathan MVC
 * File: /models/home.php
 * Purpose: model for the home controller.
 * Author: Nathan Davison
 */

class SeriesModel extends BaseModel {
	//data passed to the home index view
	public function index() {
		$sql = "SELECT series.id, series.name, if(moviecount.count IS NULL, 0, moviecount.count) AS count, group_concat(DISTINCT `genres`.`genre` ORDER BY genres.genre separator ',') AS genres FROM
				series LEFT JOIN moviesinseries ON series.id = moviesinseries.seriesID
				LEFT JOIN genresinmovies ON moviesinseries.movieID = genresinmovies.movie_id
				LEFT JOIN genres ON genresinmovies.genre_id = genres.id
                LEFT JOIN (SELECT series.id, count(moviesinseries.movieID) AS count FROM series
                      JOIN moviesinseries ON series.id = moviesinseries.seriesID
                     GROUP BY series.id) AS moviecount ON moviecount.id = series.id
				GROUP BY series.id
				ORDER BY series.name";

		$series = $this -> db -> select_query($sql);

		$i = 0;
		foreach ($series as $value) {
			$tableBody[$i][0] = '<a href="' . URL . 'series/display/' . $value['id'] . '">' . $value['name'] . '</a>';
			$tableBody[$i][1] = $value['count'];
			$tableBody[$i][2] = $value['genres'];
			$i++;
		}

		$this -> viewModel -> set('tableHead', array("Namn", "Antal filmer", "Genres i serien"));
		$this -> viewModel -> set('tableBody', $tableBody);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set("pageTitle", TITLE . "Alla filmserier");
		return $this -> viewModel;
	}

	public function display() {
		$id = $this -> urlValues['id'];
		$sql = "SELECT series.name, movies.title, movies.id, moviesinseries.number, group_concat(DISTINCT `genres`.`genre` ORDER BY genres.genre separator ',') AS genres FROM
				series JOIN moviesinseries ON series.id = moviesinseries.seriesID
				JOIN movies ON moviesinseries.movieID = movies.id
				JOIN genresinmovies ON genresinmovies.movie_id = movies.id
				JOIN genres ON genresinmovies.genre_id = genres.id
				WHERE series.id = :id
				GROUP BY movies.id
				ORDER BY moviesinseries.number";

		$result = $this -> db -> select_query($sql, array(':id' => $id));

		$i = 0;
		foreach ($result as $value) {
			$tableBody[$i][0] = '<a href="' . URL . 'movie/display/' . $value['id'] . '">' . $value['title'] . '</a>';
			$tableBody[$i][1] = $value['number'];
			$tableBody[$i][2] = $value['genres'];
			$i++;
		}

		$sql = "SELECT series.infopage, series.description, series.name FROM series WHERE series.id = :id";
		$result = $this -> db -> select_query($sql, array(':id' => $id));

		$infopage = $result[0]['infopage'];
		$seriesname = $result[0]['name'];
		$seriesdesc = $result[0]['description'];

		$this -> viewModel -> set('infopage', $infopage);
		$this -> viewModel -> set('seriesname', $seriesname);
		$this -> viewModel -> set('seriesdesc', $seriesdesc);
		$this -> viewModel -> set('tableHead', array("Film", "Nummer", "Genres"));
		$this -> viewModel -> set('tableBody', $tableBody);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set("pageTitle", TITLE . $result[0]['name'] . "-serien");
		return $this -> viewModel;
	}

	public function create() {
		$post = $this -> submit;
		if (isset($post)) {
			$sql = "INSERT INTO `series`(`name`, `infopage`, `adDate`, `description`)
					VALUES (:name,:infopage,now(),:desc)";
			$this -> db -> select_query($sql, array(":name" => $_POST["name"], ":infopage" => $_POST["infopage"], ":desc" => $_POST["desc"]));
			header('Location: ' . URL . 'series/display/' . $this -> db -> lastInsertId());
		}
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set("pageTitle", TITLE . "Skapa en serie");
		return $this -> viewModel;
	}

	public function edit() {
		$id = $this -> urlValues['id'];

		$result = $this -> db -> select_query("SELECT `name`, `infopage`, `description` FROM `series` WHERE id = :id", array(":id" => $id));
		$name = $result[0]["name"];
		$infopage = $result[0]["infopage"];
		$description = $result[0]["description"];

		$sql = "SELECT movies.title, movies.id, moviesinseries.seriesID, moviesinseries.number FROM moviesinseries
				JOIN movies ON moviesinseries.movieID = movies.id
				WHERE moviesinseries.seriesID = :id
				ORDER BY moviesinseries.number";
		$result = $this -> db -> select_query($sql, array(":id" => $id));

		$i = 0;
		foreach ($result as $value) {
			$tableBody[$i][0] = $value['title'];
			$tableBody[$i][1] = $value['number'];
			$tableBody[$i][2] = '<a href="' . URL . 'series/makeedit/rem/' . $value['id'] . '/' . $value['seriesID'] . '"class="glyphicon glyphicon-remove"></a>';
			$i++;
		}

		$this -> viewModel -> set('tableHead', array("Film", "Nummer", "Ta bort"));
		$this -> viewModel -> set('tableBody', $tableBody);
		$this -> viewModel -> set('name', $name);
		$this -> viewModel -> set('infopage', $infopage);
		$this -> viewModel -> set('desc', $description);
		$this -> viewModel -> set('movies', $movies);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set("pageTitle", TITLE . "Ändra \"" . $name . "\"");
		return $this -> viewModel;
	}

	public function makeedit() {
		$post = $this -> submit;
		if (isset($post)) {
			$this -> db -> select_query("UPDATE `series` SET `name`=:name,`infopage`=:infopage,`description`=:desc WHERE id = :id", array(":id" => $this -> urlValues["id"], ":name" => $_POST["name"], ":infopage" => $_POST["infopage"], ":desc" => $_POST["desc"]));
			header('Location: ' . URL . 'series/display/' . $this -> urlValues["id"]);
		} elseif ($this -> urlValues["id"] == "rem") {
			$movieid = $this -> urlValues["id2"];
			$seriesid = $this -> urlValues["id3"];
			$this -> db -> select_query("DELETE FROM `moviesinseries` WHERE `movieID` = :movieid AND `seriesID` = :seriesid", array(":movieid" => $movieid, ":seriesid" => $seriesid));
			header('Location: ' . URL . 'series/display/' . $seriesid);
		}
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set("pageTitle", TITLE . "Fel!");
		return $this -> viewModel;
	}

	public function remove() {
		$id = $this -> urlValues['id'];
		echo $id;
		$this -> db -> select_query("DELETE FROM `series` WHERE `id` = :id;", array(":id" => $id));
		$this -> db -> select_query("DELETE FROM `moviesinseries` WHERE `seriesID` = :id", array(":id" => $id));
		header('Location: ' . URL . 'series');
	}

}
?>
