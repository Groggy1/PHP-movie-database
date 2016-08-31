<?php
/*
 * Project: Nathan MVC
 * File: /models/user.php
 * Purpose:
 * Author: Nathan Davison
 */

class UserModel extends BaseModel {
	public function towatch() {
		/*SELECT allMovies.id, allMovies.title, allMovies.year, allMovies.genre, towatch.date
FROM allMovies
JOIN towatch ON towatch.movieid = allMovies.id
LEFT JOIN (
    SELECT userviewed.userid, userviewed.movieid, userviewed.date, towatchagain.added
    FROM userviewed
    LEFT JOIN towatchagain ON towatchagain.movieid = userviewed.movieid AND towatchagain.userid = userviewed.userid
) AS UV ON UV.movieid = allMovies.id AND UV.userid = towatch.userid
WHERE UV.added IS NOT NULL AND towatch.userid = ':uid'
ORDER BY towatch.date, allMovies.title*/
		$sql = "SELECT allMovies.id, allMovies.title, allMovies.year, allMovies.genre, towatch.date
				FROM allMovies
				JOIN towatch ON towatch.movieid = allMovies.id
				LEFT JOIN (SELECT userid, movieid, date FROM userviewed) AS UV ON UV.movieid = allMovies.id AND UV.userid = towatch.userid
				WHERE UV.date IS NULL AND towatch.userid = :uid
				ORDER BY towatch.date, allMovies.title";

		$result = $this -> db -> select_query($sql, array(':uid' => $_SESSION['user_id']));

		$i = 0;
		foreach ($result AS $value) {
			$tableBody[$i][0] = '<a href="' . URL . 'movie/display/' . $value['id'] . '">' . $value['title'] . '</a>';
			$tableBody[$i][1] = $value['year'];
			$genres = explode('|', $value['genre']);
			foreach ($genres AS $value2) {
				$localgenre = explode(':', $value2);
				$tableBody[$i][2] .= $localgenre[1];
				if (end($genres) !== $value2) {
					$tableBody[$i][2] .= ', ';
				}
			}
			$tableBody[$i][3] = $value['date'];
			$i++;
		}

		$sql = "SELECT allMovies.id, allMovies.title, allMovies.year, allMovies.genre, towatchagain.added as date
				FROM allMovies
				JOIN towatchagain ON towatchagain.movieid = allMovies.id
				LEFT JOIN (SELECT userid, movieid, date FROM userviewed) AS UV ON UV.movieid = allMovies.id AND UV.userid = towatchagain.userid
				WHERE towatchagain.userid = :uid
				ORDER BY towatchagain.added, allMovies.title";

		$result = $this -> db -> select_query($sql, array(':uid' => $_SESSION['user_id']));

		foreach ($result AS $value) {
			$tableBody[$i][0] = '<a href="' . URL . 'movie/display/' . $value['id'] . '">' . $value['title'] . '</a>';
			$tableBody[$i][1] = $value['year'];
			$genres = explode('|', $value['genre']);
			foreach ($genres AS $value2) {
				$localgenre = explode(':', $value2);
				$tableBody[$i][2] .= $localgenre[1];
				if (end($genres) !== $value2) {
					$tableBody[$i][2] .= ', ';
				}
			}
			$tableBody[$i][3] = $value['date'];
			$i++;
		}

		$this -> viewModel -> set('tableHead', array('Film', 'År', 'Genre','Tillagd'));
		$this -> viewModel -> set('tableBody', $tableBody);
		$this -> viewModel -> set('tableBody2', $tableBody2);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Filmer att se');
		return $this -> viewModel;
	}

	public function recomended() {
		$sql = "SELECT movies.id,movies.title, movies.year, avg(avg) AS totalavg
				FROM movies JOIN genresinmovies AS gim ON movies.id = gim.movie_id
				JOIN
				(SELECT gim.genre_id, avg(uv.value) AS avg FROM uservote AS uv
				JOIN genresinmovies AS gim ON uv.movie_id = gim.movie_id
				JOIN genres AS gen ON gim.genre_id = gen.id
				WHERE uv.user_id = :uid
				GROUP BY gim.genre_id
				ORDER BY avg DESC) AS avg
				ON avg.genre_id = gim.genre_id
				LEFT JOIN userviewed AS uw ON uw.movieid = movies.id
				WHERE uw.date IS NULL
				GROUP BY movies.id
				ORDER BY totalavg DESC";

		$result = $this -> db -> select_query($sql, array(':uid' => $_SESSION['user_id']));

		$i = 0;
		foreach ($result as $value) {
			$tableBody[$i][0] = '<a href="' . URL . 'movie/display/' . $value['id'] . '">' . $value['title'] . '</a>';
			$tableBody[$i][1] = $value['year'];
			$tableBody[$i][2] = round($value['totalavg'], 1);;
			$i++;
		}

		/*
		$i = 0;
		foreach ($result AS $value) {
			$actors[] = explode('|', $value['actors']);
			$directors[] = explode('|', $value['directors']);
			$tableBody[$i][0] = '<a href="' . URL . 'movie/display/' . $value['id'] . '">' . $value['title'] . '</a>';
			$tableBody[$i][1] = $value['year'];
			$genres = explode('|', $value['genre']);
			foreach ($genres AS $value2) {
				$localgenre = explode(':', $value2);
				$tableBody[$i][2] .= $localgenre[1];
				if (end($genres) !== $value2) {
					$tableBody[$i][2] .= ', ';
				}
			}
			$tableBody[$i][3] = $value['date'];
			$i++;
		}
		 */

		$this -> viewModel -> set('tableHead', array('Film', 'År', 'Poäng'));
		$this -> viewModel -> set('tableBody', $tableBody);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Filmer att se');
		return $this -> viewModel;
	}

}
?>
