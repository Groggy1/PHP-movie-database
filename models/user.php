<?php
/*
 * Project: Nathan MVC
 * File: /models/user.php
 * Purpose:
 * Author: Nathan Davison
 */

class UserModel extends BaseModel {
	public function towatch() {
		$sql = "SELECT allMovies.id, allMovies.title, allMovies.year, allMovies.genre, towatch.date
				FROM allMovies
				JOIN towatch ON towatch.movieid = allMovies.id
				LEFT JOIN (SELECT userid, movieid, date FROM userviewed) AS UV ON UV.movieid = allMovies.id AND UV.userid = towatch.userid
				WHERE UV.date IS NULL AND towatch.userid = :uid
				ORDER BY towatch.date, allMovies.title";

		$result = $this -> db -> select_query($sql, array(':uid' => $_SESSION['user_id']));
		
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
		
		$this -> viewModel -> set('tableHead', array('Film', 'År', 'Genre','Tillagd'));
		$this -> viewModel -> set('tableBody', $tableBody);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Filmer att se');
		return $this -> viewModel;
	}
	
	public function recomended() {
		$sql = "SELECT allMovies.id, allMovies.title, allMovies.year, allMovies.genre, towatch.date
				FROM allMovies
				JOIN towatch ON towatch.movieid = allMovies.id
				LEFT JOIN (SELECT userid, movieid, date FROM userviewed) AS UV ON UV.movieid = allMovies.id AND UV.userid = towatch.userid
				WHERE UV.date IS NULL AND towatch.userid = :uid
				ORDER BY towatch.date, allMovies.title";

		$result = $this -> db -> select_query($sql, array(':uid' => $_SESSION['user_id']));
		
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
		
		$this -> viewModel -> set('tableHead', array('Film', 'År', 'Genre','Tillagd'));
		$this -> viewModel -> set('tableBody', $tableBody);
		$this -> viewModel -> set('urlValues', $this -> urlValues);
		$this -> viewModel -> set('pageTitle', TITLE . 'Filmer att se');
		return $this -> viewModel;
	}

}
?>
