<?php
/*
 * Project: Nathan MVC
 * File: /models/movie.php
 * Purpose: model for the home controller.
 * Author: Nathan Davison
 */

class MovieModel extends BaseModel {
	//data passed to the home index view
	public function index() {
		$ar = new ArrayTools();
		foreach ($this -> urlValues AS $key => $value) {
			if (substr($key, 0, 2) == 'id') {
				$glink .= $value . '/';
				$ylink .= $value . '/';
				$alink .= $value . '/';
				$dlink .= $value . '/';
				if (substr($value, 0, 1) == 'g') {
					$genre = substr($value, 1);
					$glink = substr($glink, 0, strlen($glink) - (strlen($value) + 1));
				} elseif (substr($value, 0, 1) == 'y') {
					$year = substr($value, 1);
					$ylink = substr($ylink, 0, strlen($ylink) - (strlen($value) + 1));
				} elseif (substr($value, 0, 1) == 'a') {
					$actor = substr($value, 1);
					$alink = substr($alink, 0, strlen($alink) - (strlen($value) + 1));
				} elseif (substr($value, 0, 1) == 'd') {
					$director = substr($value, 1);
					$dlink = substr($dlink, 0, strlen($dlink) - (strlen($value) + 1));
				}
			}
		}

		$glink = rtrim($glink, '/');
		$ylink = rtrim($ylink, '/');
		$alink = rtrim($alink, '/');
		$dlink = rtrim($dlink, '/');

		//$year = (substr($this -> urlValues['id'], 0, 1) == 'y') ? substr($this -> urlValues['id'], 1) : substr($this -> urlValues['id2'], 1);
		//$genre = (substr($this -> urlValues['id'], 0, 1) == 'g') ? substr($this -> urlValues['id'], 1) : substr($this -> urlValues['id2'], 1);

		/*
		 * select movies.id AS id,movies.title AS title,movies.year AS year,group_concat(`genres`.`id` separator ',') AS `genreid`,group_concat(concat(genres.id,':',genres.genre) separator '|') AS genre from movies
		 * join genresinmovies on movies.id = genresinmovies.movie_id
		 * join genres on genresinmovies.genre_id = genres.id
		 * group by movies.id
		 * order by movies.title,genres.genre
		 */

		$param = array();
		$SQL = "SELECT allMovies.id, allMovies.title, allMovies.year, allMovies.genre";
		if (strlen($actor) > 0 && strlen($director) == 0) {
			$SQL .= ", group_concat(DISTINCT concat(directors.id,':',directors.director) separator '|') AS directors";
		} elseif (strlen($actor) == 0 && strlen($director) > 0) {
			$SQL .= ", group_concat(DISTINCT concat(actors.id,':',actors.actor) separator '|') AS actors";
		}
		$SQL .= " FROM allMovies";

		/*
		 * För actor och director
		 * SELECT id, title, year, genre, genreid FROM allMovies
		 * JOIN actorsinmovies ON allMovies.id = actorsinmovies.movie_id
		 * JOIN directorsinmovies ON directorsinmovies.movie_id = allMovies.id
		 * WHERE actorsinmovies.actor_id = 27 AND directorsinmovies.director_id = 3
		 */

		if (strlen($actor) > 0 || strlen($director) > 0) {
			$SQL .= " JOIN actorsinmovies ON allMovies.id = actorsinmovies.movie_id
					JOIN directorsinmovies ON directorsinmovies.movie_id = allMovies.id";
			if (strlen($actor) > 0 && strlen($director) == 0) {
				$SQL .= " JOIN directors ON directors.id = directorsinmovies.director_id";
			} elseif (strlen($actor) == 0 && strlen($director) > 0) {
				$SQL .= " JOIN actors ON actors.id = actorsinmovies.actor_id";
			}
		}
		$SQL .= " WHERE";
		if (strlen($actor) > 0) {
			$SQL .= " actorsinmovies.actor_id = :aid AND";
			$param = array_merge($param, array(':aid' => $actor));
		}
		if (strlen($director) > 0) {
			$SQL .= " directorsinmovies.director_id = :did AND";
			$param = array_merge($param, array(':did' => $director));
		}
		if (strlen($genre) > 0) {
			$SQL .= " (genre LIKE :genre1 OR genre LIKE :genre2 OR genre LIKE :genre3) AND";
			$param = array_merge($param, array(':genre1' => '%|' . $genre . ':%', ':genre2' => $genre . ':%', ':genre3' => '%|' . $genre));
		}
		if (strlen($year) > 0) {
			$SQL .= " year = :year AND";
			$param = array_merge($param, array(':year' => $year));
		}
		$SQL .= " 1=1 GROUP BY allMovies.id ORDER BY allMovies.title ";

		/*
		 if (strlen($genre) > 0 && strlen($year) > 0) {
		 $SQL .= " HAVING (genreid LIKE :genre1 OR genreid LIKE :genre2 OR genreid LIKE :genre3) AND year = :year";
		 $param = array(':genre1' => '%,' . $genre . ',%', ':genre2' => $genre . ',%', ':genre3' => '%,' . $genre, ':year' => $year);
		 } elseif (strlen($genre) > 0) {
		 $SQL .= " HAVING (genreid LIKE :genre1 OR genreid LIKE :genre2 OR genreid LIKE :genre3)";
		 $param = array(':genre1' => '%,' . $genre . ',%', ':genre2' => $genre . ',%', ':genre3' => '%,' . $genre);
		 } elseif (strlen($year) > 0) {
		 $SQL .= " HAVING year = :year";
		 $param = array(':year' => $year);
		 }
		 */

		//echo $SQL . '<br>';
		//var_dump();

		$result = $this -> db -> select_query($SQL, $param);
		/*
		 echo '<pre>';
		 var_dump($result);
		 echo '</pre>';
		 */
		$i = 0;
		foreach ($result AS $value) {
			$actors[] = explode('|', $value['actors']);
			$directors[] = explode('|', $value['directors']);
			$tableBody[$i][0] = '<a href="' . URL . 'movie/display/' . $value['id'] . '">' . $value['title'] . '</a>';
			$tableBody[$i][1] = '<a href="' . rtrim(URL . 'movie/index/' . $ylink, '/') . '/y' . $value['year'] . '">' . $value['year'] . '</a>';
			$genres = explode('|', $value['genre']);
			foreach ($genres AS $value2) {
				$localgenre = explode(':', $value2);
				$tableBody[$i][2] .= '<a href="' . rtrim(URL . 'movie/index/' . $glink, '/') . '/g' . $localgenre[0] . '">' . $localgenre[1] . '</a>';
				if (end($genres) !== $value2) {
					$tableBody[$i][2] .= ', ';
				}
			}
			$i++;
		}

		foreach ($ar -> unique_flat_array($actors) as $value) {
			if (strlen($value) != 0) {
				$local = explode(':', $value);
				$actorsout .= '<a href="' . rtrim(URL . 'movie/index/' . $alink, '/') . '/a' . $local[0] . '">' . $local[1] . '</a>';
				if ($value !== end($ar -> unique_flat_array($actors)))
					$actorsout .= ', ';
			}
		}
		foreach ($ar -> unique_flat_array($directors) as $value) {
			if (strlen($value) != 0) {
				$local = explode(':', $value);
				$directorsout .= '<a href="' . rtrim(URL . 'movie/index/' . $dlink, '/') . '/d' . $local[0] . '">' . $local[1] . '</a>';
				if ($value !== end($ar -> unique_flat_array($directors)))
					$directorsout .= ', ';
			}
		}

		$this -> viewModel -> set('actors', trim($actorsout, ','));
		$this -> viewModel -> set('directors', trim($directorsout, ','));
		$this -> viewModel -> set('tableHead', array('Film', 'År', 'Genre'));
		$this -> viewModel -> set('tableBody', $tableBody);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Alla filmer');
		return $this -> viewModel;
	}

	public function display() {
		$id = $this -> urlValues['id'];
		$ar = new ArrayTools();

		$sql = "SELECT movies.youtube, movies.imdbid, movies.runtime, movies.title, movies.year, movies.poster, movies.plot, movies.sub, group_concat(DISTINCT concat(actors.id,',',actors.actor) separator '|') AS actor, group_concat(DISTINCT concat(directors.id,',',directors.director) separator '|') AS director, movietype.type, group_concat(DISTINCT concat(genres.id,',',genres.genre) separator '|') AS genre
				FROM movies
				LEFT JOIN actorsinmovies ON movies.id = actorsinmovies.movie_id
				LEFT JOIN actors ON actors.id = actorsinmovies.actor_id
				LEFT JOIN directorsinmovies ON movies.id = directorsinmovies.movie_id
				LEFT JOIN directors ON directorsinmovies.director_id = directors.id
				LEFT JOIN movietype ON movies.type = movietype.short
				LEFT JOIN genresinmovies ON movies.id = genresinmovies.movie_id
				LEFT JOIN genres ON genresinmovies.genre_id = genres.id
				WHERE movies.id = :id
				GROUP BY movies.id";

		$result = $this -> db -> select_query($sql, array(':id' => $id));
		$result = $result[0];

		$sql = "SELECT user_id, value FROM uservote
				WHERE movie_id = :movieid";

		$votes = $this -> db -> select_query($sql, array(':movieid' => $id));

		$averagepoint = 0;
		$numberofvoters = 0;

		$sql = "SELECT id, name FROM users";

		$users = $this -> db -> select_query($sql);

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

		$sql = "SELECT userid FROM userviewed
				WHERE movieid = :id";

		$viewed = $ar -> unique_flat_array($this -> db -> select_query($sql, array(':id' => $id)));

		$sql = "SELECT userid FROM towatch
				WHERE movieid = :id";

		$towatch = $ar -> unique_flat_array($this -> db -> select_query($sql, array(':id' => $id)));

		$sql = "SELECT usercomment.comment, users.name, usercomment.date FROM usercomment
		JOIN users ON usercomment.userid = users.id
		WHERE usercomment.movieid = :id
		ORDER BY usercomment.date, usercomment.id DESC";

		$comments = $this -> db -> select_query($sql, array(':id' => $id));

		foreach ($users as $key => $value) {
			$usertable[$key][0] = $value['name'];
			if (in_array($key + 1, $viewed)) {
				$usertable[$key][2] .= '<span class="glyphicon glyphicon-ok"></span>';
			} else {
				if ($_SESSION['user_id'] == $key + 1) {
					$usertable[$key][2] .= '<a href="' . URL . 'movie/viewed/' . $id . '" class="glyphicon glyphicon-remove"></a>';
				} else {
					$usertable[$key][2] .= '<a class="glyphicon glyphicon-remove novote"></a>';
				}
			}
			for ($i = 1; $i <= 5; $i++) {
				if ($value['value'] == $i) {
					$usertable[$key][3] .= '<a class="vote">' . $i . '</a> ';
				} else {
					if ($_SESSION['user_id'] == $key + 1) {
						$usertable[$key][3] .= '<a href="' . URL . 'movie/vote/' . $id . '/' . $i . '">' . $i . '</a> ';
					} else {
						$usertable[$key][3] .= '<a class="novote">' . $i . '</a> ';
					}
				}
			}
			if (in_array($key + 1, $towatch)) {
				$usertable[$key][4] .= '<span class="glyphicon glyphicon-ok"></span>';
			} else {
				if ($_SESSION['user_id'] == $key + 1) {
					if (!in_array($_SESSION['user_id'], $viewed)) {
						$usertable[$key][4] .= '<a href="' . URL . 'movie/towatch/' . $id . '" class="glyphicon glyphicon-remove"></a>';
					} else {
						$usertable[$key][4] .= '<a class="glyphicon glyphicon-remove novote"></a>';
					}
				} else {
					$usertable[$key][4] .= '<a class="glyphicon glyphicon-remove novote"></a>';
				}
			}
		}

		$this -> viewModel -> set('comments', $comments);
		$this -> viewModel -> set('betygHead', array('Namn', 'Sedd', 'Betyg', 'Att se'));
		$this -> viewModel -> set('betygBody', $usertable);
		$this -> viewModel -> set('avgPoints', number_format($averagepoint / $numberofvoters, 1));
		$this -> viewModel -> set('imdbid', $result['imdbid']);
		$this -> viewModel -> set('runtime', $result['runtime']);
		$this -> viewModel -> set('title', $result['title']);
		$this -> viewModel -> set('year', $result['year']);
		$this -> viewModel -> set('poster', $result['poster']);
		$this -> viewModel -> set('plot', $result['plot']);
		$this -> viewModel -> set('sub', $result['sub']);
		$this -> viewModel -> set('actor', $result['actor']);
		$this -> viewModel -> set('director', $result['director']);
		$this -> viewModel -> set('type', $result['type']);
		$this -> viewModel -> set('genre', $result['genre']);
		$this -> viewModel -> set('youtube', $result['youtube']);
		$this -> viewModel -> set('id', $result['id']);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . $result['title']);
		return $this -> viewModel;
	}

	public function vote() {
		$url = filter_var_array($this -> urlValues, FILTER_VALIDATE_INT);
		if ($url['id'] && $url['id2']) {
			$param = array(':mid' => $url['id'], ':uid' => $_SESSION['user_id']);
			$ar = new ArrayTools();

			$sql = "SELECT count(*) FROM `userviewed` WHERE
					`movieid` = :mid AND `userid` = :uid";

			$result = $ar -> unique_flat_array($this -> db -> select_query($sql, $param));

			if ($result[0] == 0) {
				$sql = "INSERT INTO userviewed (userid, movieid, date)
				VALUE (:uid,:mid,NOW())";

				$this -> db -> select_query($sql, $param);
			}
			$sql = "SELECT user_id FROM `uservote`
					WHERE `user_id` = :uid AND `movie_id` = :mid";

			$result = $ar -> unique_flat_array($this -> db -> select_query($sql, $param));
			var_dump($result);
			if (empty($result)) {
				$sql = "INSERT INTO `uservote`(`user_id`, `movie_id`, `value`, date)
						VALUES (:uid,:mid,:vote, NOW())";
				$param = array(':mid' => $url['id'], ':uid' => $_SESSION['user_id'], ':vote' => $url['id2']);

				$this -> db -> select_query($sql, $param);
			} else {
				$sql = "UPDATE `uservote` SET `value`=:vote , `date` = NOW()
						WHERE `movie_id` = :mid AND `user_id` = :uid";
				$param = array(':mid' => $url['id'], ':uid' => $_SESSION['user_id'], ':vote' => $url['id2']);

				$this -> db -> select_query($sql, $param);
			}
			header('location:' . URL . 'movie/display/' . $url['id']);
		}
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Fel!');
		return $this -> viewModel;
	}

	public function towatch() {
		$url = filter_var_array($this -> urlValues, FILTER_VALIDATE_INT);
		if ($url['id']) {
			$sql = "INSERT INTO towatch(movieid, userid, date) 
					VALUES (:mid,:uid,now())";
			$param = array(':mid' => $url['id'], ':uid' => $_SESSION['user_id']);
			$this -> db -> select_query($sql, $param);
			header('location:' . URL . 'movie/display/' . $url['id']);
		}
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Fel!');
		return $this -> viewModel;
	}

	public function viewed() {
		$url = filter_var_array($this -> urlValues, FILTER_VALIDATE_INT);
		if ($url['id']) {
			$sql = "INSERT INTO userviewed (userid, movieid, date)
					VALUE (:uid,:mid,NOW())";
			$param = array(':mid' => $url['id'], ':uid' => $_SESSION['user_id']);
			$this -> db -> select_query($sql, $param);
			header('location:' . URL . 'movie/display/' . $url['id']);
		}
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Fel!');
		return $this -> viewModel;
	}

	public function edit() {
		$post = $this -> submit;
		if (is_null($post)) {
			$id = $this -> urlValues['id'];
			$ar = new ArrayTools();

			$sql = "SELECT movies.youtube, movies.imdbid, movies.runtime, movies.title, movies.year, movies.poster, movies.plot, movies.sub, group_concat(DISTINCT concat(actors.id,',',actors.actor) separator '|') AS actor, group_concat(DISTINCT concat(directors.id,',',directors.director) separator '|') AS director, movietype.type, group_concat(DISTINCT concat(genres.id,',',genres.genre) separator '|') AS genre
				FROM movies
				LEFT JOIN actorsinmovies ON movies.id = actorsinmovies.movie_id
				LEFT JOIN actors ON actors.id = actorsinmovies.actor_id
				LEFT JOIN directorsinmovies ON movies.id = directorsinmovies.movie_id
				LEFT JOIN directors ON directorsinmovies.director_id = directors.id
				LEFT JOIN movietype ON movies.type = movietype.short
				LEFT JOIN genresinmovies ON movies.id = genresinmovies.movie_id
				LEFT JOIN genres ON genresinmovies.genre_id = genres.id
				WHERE movies.id = :id
				GROUP BY movies.id";

			$result = $this -> db -> select_query($sql, array(':id' => $id));
			$result = $result[0];

			$types = $this -> db -> select_query("SELECT short, type FROM movietype");
			foreach ($types as $value) {
				$types2[$value['short']] = $value['type'];
			}
			$actors = $this -> db -> select_query("SELECT id,actor FROM actors");
			foreach ($actors as $value) {
				$actors2[$value['id']] = $value['actor'];
			}

			$comments = $this -> db -> select_query("SELECT `comment`,`id` FROM `usercomment` WHERE `userid` = :uid AND `movieid` = :mid ORDER BY `id` DESC", array(':uid' => $_SESSION['user_id'], ':mid' => $id));
		}

		/*
		 echo '<pre>';
		 var_dump($comments);
		 echo '</pre>';
		 */

		$this -> viewModel -> set('comments', $comments);
		$this -> viewModel -> set('actors', $actors2);
		$this -> viewModel -> set('types', $types2);
		$this -> viewModel -> set('imdbid', $result['imdbid']);
		$this -> viewModel -> set('runtime', $result['runtime']);
		$this -> viewModel -> set('title', $result['title']);
		$this -> viewModel -> set('year', $result['year']);
		$this -> viewModel -> set('poster', $result['poster']);
		$this -> viewModel -> set('plot', $result['plot']);
		$this -> viewModel -> set('sub', $result['sub']);
		$this -> viewModel -> set('actor', $result['actor']);
		$this -> viewModel -> set('director', $result['director']);
		$this -> viewModel -> set('type', $result['type']);
		$this -> viewModel -> set('genre', $result['genre']);
		$this -> viewModel -> set('youtube', $result['youtube']);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Ändra "' . $result['title'] . '"');
		return $this -> viewModel;
	}

	public function wall() {
		$numberofimgperside = 9;
		$ar = new ArrayTools();
		$url = filter_var_array($this -> urlValues, FILTER_VALIDATE_INT);
		$sql = "SELECT `id`,`poster` FROM `movies`
				ORDER BY id DESC ";
		if ($url['id']) {
			$sql .= "LIMIT " . $numberofimgperside * ((int)$url['id'] - 1) . ", " . $numberofimgperside;
		} else {
			$url['id'] = 1;
			$sql .= "LIMIT " . $numberofimgperside;
		}

		$result = $this -> db -> select_query($sql);

		$sql = "SELECT count(id)
				FROM movies
				ORDER BY id DESC";

		$numberofmovies = $ar -> unique_flat_array($this -> db -> select_query($sql));
		$numberofmovies = $numberofmovies[0];

		$antalSidor = ceil($numberofmovies / 9);

		if ($this -> urlValues['id'] == 0) {
			$id = 1;
			$classone = 'class="notclickable"';
		} elseif ($this -> urlValues['id'] == $antalSidor) {
			$id = $antalSidor;
			$classtwo = 'class="notclickable"';
		} else {
			$id = $this -> urlValues['id'];
		}

		$getPrew = 'href="' . URL . $this -> urlValues['controller'] . '/' . $this -> urlValues['action'] . '/' . ($id - 1) . '" ' . $classone;
		$getNext = 'href="' . URL . $this -> urlValues['controller'] . '/' . $this -> urlValues['action'] . '/' . ($id + 1) . '"' . $classtwo;

		/*
		 for ($i = $lover; $i <= $upper; $i++) {
		 $pagination .= '<li' . ((int)$url['id'] == $i ? ' class="active' : '') . '><a href="' . URL . $this -> urlValues['controller'] . '/' . $this -> urlValues['action'] . '/' . $i . '"><span>' . $i . '<span class="sr-only">(current)</span></span></a></li>';
		 }
		 */

		$row = 1;
		foreach ($result as $key => $value) {
			if ($key == 3 || $key == 6)
				$row++;
			$posters[$row] .= '<a href="' . URL . 'movie/display/' . $value['id'] . '"><img src="' . URL . 'public/img/posters/' . $value['poster'] . '" class="poster"></a>';
		}

		/*
		 $i = 3;
		 $j = 2;
		 $k = 1;

		 foreach ($result AS $key => $value) {
		 if ($i % 3 == 0)
		 $posters[0][$key] = '<a href="' . URL . 'movie/display/' . $value['id'] . '"><img src="' . URL . 'public/img/posters/' . $value['poster'] . '" class="img"></a>';
		 elseif ($j % 3 == 0)
		 $posters[1][$key] = '<a href="' . URL . 'movie/display/' . $value['id'] . '"><img src="' . URL . 'public/img/posters/' . $value['poster'] . '" class="img"></a>';
		 elseif ($k % 3 == 0)
		 $posters[2][$key] = '<a href="' . URL . 'movie/display/' . $value['id'] . '"><img src="' . URL . 'public/img/posters/' . $value['poster'] . '" class="img"></a>';
		 $i++;
		 $j++;
		 $k++;
		 }
		 *
		 */

		$this -> viewModel -> set("getPrew", $getPrew);
		$this -> viewModel -> set("getNext", $getNext);
		$this -> viewModel -> set('posters', $posters);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Filmvägg');
		return $this -> viewModel;
	}

	public function addcomment() {
		$param = $this -> param;
		if (!empty($param[':uid']) && !empty($param[':mid']) && !empty($param[':comment'])) {
			$sql = "INSERT INTO `usercomment`(`userid`, `movieid`, `comment`, date)
				VALUES (:uid,:mid,:comment,now())";

			$this -> db -> select_query($sql, $param);
			header('location:' . URL . 'movie/display/' . $param[':mid']);
		}
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Fel!');
		return $this -> viewModel;
	}

	public function add() {
		$sql = "SELECT * FROM movietype";
		$movieype = $this -> db -> select_query($sql);

		$this -> viewModel -> set('movietype', $movieype);
		$this -> viewModel -> set('imdbID', '');
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Lägg till film');
		return $this -> viewModel;
	}

	public function addimdb() {
		$imdb = new Imdb();
		$imdbid = $this -> imdbID;
		$movieData = $imdb -> getMovieInfoById($imdbid);

		if (!empty($movieData['original_title'])) {
			$title = trim($movieData['original_title']);
		} else {
			$title = trim($movieData['title']);
		}

		$url = $movieData['poster_large'];
		$imgtitle = basename($url);
		$path = time() . '-' . $imgtitle;

		$this -> viewModel -> set('imdbid', $movieData['title_id']);
		$this -> viewModel -> set('title', $title);
		$this -> viewModel -> set('year', $movieData['year']);
		$this -> viewModel -> set('genres', $movieData['genres']);
		$this -> viewModel -> set('directors', $movieData['directors']);
		$this -> viewModel -> set('cast', $movieData['cast']);
		$this -> viewModel -> set('plot', $movieData['plot']);
		$this -> viewModel -> set('poster', $path);
		$this -> viewModel -> set('posterURL', $url);
		$this -> viewModel -> set('runtime', $movieData['runtime']);
		$this -> viewModel -> set('type', $this -> type);
		$this -> viewModel -> set('sub', $this -> sub);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Lägg till film');
		return $this -> viewModel;
	}

	public function publish() {
		$this -> viewModel -> set('pageTitle', TITLE . '');
		include 'class/arraytools.php';

		$title = trim($_POST['title']);
		$imdb = trim($_POST['imdbid']);

		$sql = "DELETE FROM queue WHERE imdb = :imdb";
		$param = array(':imdb' => $imdb);

		$this -> db -> select_query($sql, $param);

		$sql = "SELECT * FROM movies WHERE title = :title";
		$param = array(':title' => $title);

		$count = $this -> db -> select_query($sql, $param);

		if (sizeof($count) == 0) {
			$ar = new ArrayTools();

			$directors = $ar -> pickvalues_to_array($_POST, 1, $_POST['NoDirectors']);
			$actors = $ar -> pickvalues_to_array($_POST, 100, $_POST['NoActors']);
			$genres = $ar -> pickvalues_to_array($_POST, 1000, $_POST['NoGenres']);

			//Hämta hem postern -- http://www.phpriot.com/articles/download-with-curl-and-php

			$path = $_POST['poster'];
			/*
			 $fp = fopen('public/img/posters/' . $path, 'w');
			 $ch = curl_init($url);
			 curl_setopt($ch, CURLOPT_FILE, $fp);
			 $data = curl_exec($ch);
			 curl_close($ch);
			 fclose($fp);
			 *
			 */

			$sql = "INSERT INTO movies (imdbid, title, plot, year, poster, type, sub, runtime, date, youtube)
 					VALUES(:imdbid, :title, :plot, :year, :path, :type, :sub, :runtime, now(), :youtube)";

			$param = array(':imdbid' => $_POST['imdbid'], ':title' => strip_tags($_POST['title']), ':plot' => strip_tags($_POST['plot']), ':year' => strip_tags($_POST['year']), ':path' => $path, ':type' => strip_tags($_POST['type']), ':sub' => strip_tags($_POST['sub']), ':runtime' => strip_tags($_POST['runtime']), ':youtube' => strip_tags($_POST['youtube']));

			$this -> db -> select_query($sql, $param);
			$mid = $this -> db -> lastInsertId('id');

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
			$genreids = $this -> db -> multi_query($sql, $genreparam);

			$genrenotindb = array_diff($ar -> flatten_array($genreparam), $ar -> flatten_array($genreids));

			$paraminsert = array();
			foreach ($genrenotindb as $value) {
				$paraminsert[] = array(':genre' => strip_tags($value));
			}

			$sql = "INSERT INTO genres (genre)
					VALUES(:genre)";

			$result = $this -> db -> multi_query($sql, $paraminsert);
			$genrefromdbid = $this -> db -> lastInsertId();

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

			$this -> db -> multi_query($sql, $genresinmovies);

			########################################################
			#	Actors hanteras här								   #
			#	Ser till att mata in all data i databasen		   #
			########################################################

			$sql = "SELECT * FROM actors
					WHERE actor = :actor";

			$actorsinmovie = $this -> db -> multi_query($sql, $actorparam);

			$actorsinmovienotdb = array_diff($ar -> flatten_array($actorparam), $ar -> flatten_array($actorsinmovie));

			$actorinsertparam = array();
			foreach ($actorsinmovienotdb as $value) {
				$actorinsertparam[] = array(':actor' => strip_tags($value));
			}

			$sql = "INSERT INTO actors (actor)
					VALUES (:actor)";

			$this -> db -> multi_query($sql, $actorinsertparam);
			$actorid = $this -> db -> lastInsertId();

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
			$this -> db -> multi_query($sql, $actorsparam);

			########################################################
			#	Directors hanteras här							   #
			#	Ser till att mata in all data i databasen		   #
			########################################################

			$sql = "SELECT * FROM directors
					WHERE director = :director";

			$directorsindb = $this -> db -> multi_query($sql, $directorparam);

			$directorsnotindb = array_diff($ar -> flatten_array($directorparam), $ar -> flatten_array($directorsindb));

			$directorsinsertdb = array();
			foreach ($directorsnotindb as $value) {
				$directorsinsertdb[] = array(':director' => strip_tags($value));
			}

			$sql = "INSERT INTO directors (director)
					VALUES (:director)";

			$this -> db -> multi_query($sql, $directorsinsertdb);
			$dib = $this -> db -> lastInsertId();

			$directorsparam = array();
			for ($i = $dib - sizeof($directorsinsertdb) + 1; $i <= $dib; $i++) {
				$directorsparam[] = array(':directorid' => (int)$i, ':movieid' => $mid);
			}

			$directorsindb = $ar -> unique_flat_array(array_diff($ar -> flatten_array($directorsindb), $ar -> flatten_array($directorparam)));
			foreach ($directorsindb as $value) {
				$directorsparam[] = array(':directorid' => (int)$value, ':movieid' => $mid);
			}

			$sql = "INSERT INTO directorsinmovies (movie_id,director_id)
					VALUES (:movieid,:directorid)";

			$res = $this -> db -> multi_query($sql, $directorsparam);

			header('Location:' . URL . 'movie/display/' . $mid);
		} else {
			header('Location:' . URL . 'movie/display/' . $count[0][id]);
			break;
		}
		return $this -> viewModel;
	}

	public function removecomment() {
		$result = $this -> db -> select_query("SELECT `movieid` FROM `usercomment` WHERE `id` = :id AND `userid` = :uid", array(':id' => $this -> urlValues['id'], ':uid' => $_SESSION['user_id']));
		$this -> db -> select_query("DELETE FROM `usercomment` WHERE `id` = :id AND `userid` = :uid", array(':id' => $this -> urlValues['id'], ':uid' => $_SESSION['user_id']));
		header('location:' . URL . 'movie/edit/' . $result[0][0]);
		$this -> viewModel -> set('pageTitle', TITLE . 'removecomment!');
		return $this -> viewModel;
	}

	public function makeedit() {
		if (isset($_POST['submit'])) {
			$url = $_POST['poster'];
			if (substr($url, 0, 4) == "http") {
				$imgtitle = basename($url);
				$path = time() . '-' . $imgtitle;
				$fp = fopen('public/img/posters/' . $path, 'w');
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_FILE, $fp);
				curl_exec($ch);
				curl_close($ch);
				fclose($fp);
				echo "hej!";
				$url = $path;
			}
			$sql = "UPDATE `movies` SET `poster` = :poster, `imdbid`=:imdb,`title`=:title,`plot`=:plot,`year`=:year,`type`=:type,`sub`=:sub,`runtime`=:runtime,`youtube`=:youtube WHERE id = :id";
			$param = array(':poster' => $url, ':imdb' => $_REQUEST['imdbid'], ':title' => $_REQUEST['title'], ':plot' => strip_tags($_REQUEST['plot']), ':year' => $_REQUEST['year'], ':type' => $_REQUEST['type'], ':sub' => $_REQUEST['sub'], ':runtime' => $_REQUEST['runtime'], ':youtube' => $_REQUEST['youtube'], ':id' => $_REQUEST['id']);
			$this -> db -> select_query($sql, $param);
			header('location:' . URL . $_REQUEST['controller'] . '/display/' . $_REQUEST['id']);
		}
		$this -> viewModel -> set('pageTitle', TITLE . 'makeedit!');
		return $this -> viewModel;
	}

	public function addman() {
		$this -> viewModel -> set('Nodir', $this -> Nodir);
		$this -> viewModel -> set('Noact', $this -> Noact);
		$this -> viewModel -> set('Nogen', $this -> Nogen);
		$this -> viewModel -> set('sub', $this -> sub);
		$this -> viewModel -> set('type', $this -> type);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Lägg till film');
		return $this -> viewModel;
	}

	public function queue() {
		$sql = "SELECT queue.imdb, queue.title, queue.year, queue.added, group_concat(genres.genre ORDER BY genres.genre ASC SEPARATOR ', ') AS genre
					FROM queue JOIN genresinqueue ON queue.id = genresinqueue.movie_id
					JOIN genres ON genres.id = genresinqueue.genre_id
					GROUP BY queue.imdb
					ORDER BY queue.id DESC, genres.genre ASC";

		$result = $this -> db -> select_query($sql);

		foreach ($result as $key => $value) {
			$tableBody[$key]['0'] = '<a href="http://www.imdb.com/title/' . $value['imdb'] . '" target="_blank">' . $value['title'] . '</a> (' . $value['year'] . ')';
			$tableBody[$key]['1'] = $value['genre'];
			$tableBody[$key]['2'] = $value['added'];
			$tableBody[$key]['3'] = '<a href="' . URL . 'movie/add/' . $value['imdb'] . '"><i class="glyphicon glyphicon-remove"></i></a>';
		}

		$this -> viewModel -> set('tableBody', $tableBody);
		$this -> viewModel -> set('tableHead', array('Titel', 'Genres', 'Tillagd'));
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Köa en film');
		return $this -> viewModel;
	}

	public function addqueue() {
		if ($this -> chars == 9) {
			$sql = "SELECT id FROM movies
 					WHERE imdbid = :imdbid";

			$resultfrommovies = $this -> db -> select_query($sql, array(':imdbid' => $_POST['imdbid']));

			if (sizeof($resultfrommovies)) {
				header("Location:" . URL . "movie/display/" . $resultfrommovies[0]['id']);
				break;
			}

			$sql = "SELECT id FROM queue
 					WHERE imdb = :imdbid";

			$resultfromqueue = $this -> db -> select_query($sql, array(':imdbid' => $_POST['imdbid']));

			if (sizeof($resultfromqueue)) {
				header("Location:" . URL . "movie/queue");
				break;
			}

			$imdb = new Imdb();
			$imdbid = $this -> imdbid;
			$movieData = $imdb -> getMovieInfoById($imdbid);

			$title = trim($movieData['title']);
			$year = $movieData['year'];

			$sql = "SELECT title FROM movies
					WHERE movies.title = :title
					UNION
					SELECT title FROM queue
					WHERE queue.title = :title";

			$result = $this -> db -> select_query($sql, array(':title' => $title));

			if (sizeof($result) == 0) {
				$sql = "INSERT INTO queue (imdb , title, year, added)
	 					VALUES (:imdbid, :title, :year, CURDATE())";
				$imdbidt = $this -> imdbid;
				$result = $this -> db -> select_query($sql, array(':imdbid' => $imdbidt, ':title' => $title, ':year' => $year));
				$mid = $this -> db -> lastInsertId('id');

				foreach ($movieData['genres'] as $genre) {
					$param[] = array(':genre' => $genre);
				}

				$sql = "SELECT id FROM genres
						WHERE genre = :genre";

				$result = $this -> db -> multi_query($sql, $param);

				echo '<pre>';
				var_dump($result);
				echo '</pre>';

				foreach ($result as $key => $value) {
					echo sizeof($value);
					if (sizeof($value) == 0) {
						$insertparam[] = $param[$key];
					} else {
						$genreparam[] = $value[0];
					}
				}

				$sql = "INSERT INTO genres (genre)
						VALUES(:genre)";

				$this -> db -> multi_query($sql, $insertparam);

				$gid = $this -> db -> lastInsertId('id');

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

				$this -> db -> multi_query($sql, $genresin);
				header("Location:" . URL . "movie/queue");

			} else {
				$sql = "SELECT id FROM movies
						WHERE title = :title";

				$resultfrommovies = $this -> db -> select_query($sql, array(':title' => $title));
				if (sizeof($resultfrommovies) > 0) {
					header("Location:" . URL . "movie/display/" . $resultfrommovies[0]['id']);
					break;
				} else {
					header("Location:" . URL . "movie/queue");
				}
			}

			break;
		}
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Köa en film');
		return $this -> viewModel;
	}

	public function stat() {
		$ar = new Arraytools();

		$antalfilmer = array_sum($ar -> unique_flat_array($this -> db -> select_query("SELECT COUNT(movies.id) FROM movies")));

		$sql = "SELECT count(*)
		FROM users
		JOIN towatch ON users.id = towatch.userid
		JOIN movies ON towatch.movieid = movies.id
		LEFT JOIN (SELECT userid, movieid, date FROM userviewed) AS UV ON UV.movieid = movies.id AND UV.userid = towatch.userid
		WHERE UV.date IS NULL
		ORDER BY users.name, towatch.date, movies.title";

		$towatch = array_sum($ar -> unique_flat_array($this -> db -> select_query($sql)));

		$sql = "SELECT count(*)
		FROM users
		JOIN towatch ON users.id = towatch.userid
		JOIN movies ON towatch.movieid = movies.id
		LEFT JOIN (SELECT userid, movieid, date FROM userviewed) AS UV ON UV.movieid = movies.id AND UV.userid = towatch.userid
		WHERE UV.date IS NOT NULL
		ORDER BY users.name, towatch.date, movies.title";

		$watchedtowatch = array_sum($ar -> unique_flat_array($this -> db -> select_query($sql)));
		$comments = array_sum($ar -> unique_flat_array($this -> db -> select_query("SELECT COUNT(id) FROM usercomment")));
		$watched = sizeof($this -> db -> select_query("SELECT count(*) FROM userviewed GROUP BY movieid"));
		$numberofnews = array_sum($ar -> unique_flat_array($this -> db -> select_query("SELECT count(*) FROM news")));
		$numberinqueue = array_sum($ar -> unique_flat_array($this -> db -> select_query("SELECT count(*) FROM queue")));
		$numberofactors = array_sum($ar -> unique_flat_array($this -> db -> select_query("SELECT count(*) FROM actors")));
		$numberofdirectors = array_sum($ar -> unique_flat_array($this -> db -> select_query("SELECT count(*) FROM directors")));
		$numberofgenres = array_sum($ar -> unique_flat_array($this -> db -> select_query("SELECT count(*) FROM genres")));
		$votes = $this -> db -> select_query("SELECT avg(value), count(*) FROM uservote");
		$movieswithoutruntime = array_sum($ar -> unique_flat_array($this -> db -> select_query("SELECT count(id) FROM `movies` WHERE `runtime` = 0")));
		$subtitle = $this -> db -> select_query("SELECT sub,count(*) FROM movies GROUP BY  sub");

		$this -> viewModel -> set('antalfilmer', $antalfilmer);
		$this -> viewModel -> set('towatch', $towatch);
		$this -> viewModel -> set('watchedtowatch', $watchedtowatch);
		$this -> viewModel -> set('comments', $comments);
		$this -> viewModel -> set('watched', $watched);
		$this -> viewModel -> set('numberofnews', $numberofnews);
		$this -> viewModel -> set('numberinqueue', $numberinqueue);
		$this -> viewModel -> set('numberofactors', $numberofactors);
		$this -> viewModel -> set('numberofdirectors', $numberofdirectors);
		$this -> viewModel -> set('numberofgenres', $numberofgenres);
		$this -> viewModel -> set('votes', $votes);
		$this -> viewModel -> set('movieswithoutruntime', $movieswithoutruntime);
		$this -> viewModel -> set('subtitle', $subtitle);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Köa en film');
		return $this -> viewModel;
	}

}
?>
