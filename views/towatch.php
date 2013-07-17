<?php
$sql = "SELECT users.name, movies.title, movies.id AS mid
		FROM users
		JOIN towatch ON users.id = towatch.userid
		JOIN movies ON towatch.movieid = movies.id
		LEFT JOIN (SELECT userid, movieid, date FROM userviewed) AS UV ON UV.movieid = movies.id AND UV.userid = towatch.userid
		WHERE UV.date IS NULL
		ORDER BY users.name, towatch.date, movies.title";

$result = $db -> select_query($sql);

$toprint  = array();
foreach ($result as $key => $value) {
	$name = $value["name"];
	if (in_array($name, array_keys($toprint))) {
		$i++;
	} else {
		$i = 0;
	}
	$toprint[$value["name"]][$i]["title"] = $value["title"];
	$toprint[$value["name"]][$i]["mid"] = $value["mid"];
}

$sitetitle = 'Filmer att se';
require_once 'template/header.php';
?>
<div class="hero-unit">
	<?php
	if (is_array($toprint)) :
		$maxnumberofmovies = 0;
		$keys = array_keys($toprint);
		echo '<table class="table table-striped"><tr>';
		for ($i = 0; $i < sizeof($toprint); $i++) :
			echo '<th>' . $keys[$i] . '</th>';
			$maxnumberofmovies = max($maxnumberofmovies, sizeof($toprint[$keys[$i]]));
		endfor;
		echo '</tr>';
		$i = 0;
		for ($i = 0; $i < $maxnumberofmovies; $i++) :
			echo '<tr>';
			for ($j = 0; $j < sizeof($toprint); $j++) :
				echo '<td>';
				if (is_array($toprint[$keys[$j]][$i])) {
					echo '<a href= "dispmovie.php?id=' . $toprint[$keys[$j]][$i]['mid'] . '">' . $toprint[$keys[$j]][$i]['title'] . '</a>';
				}
				echo '</td>';
			endfor;
			echo '</tr>';
		endfor;
		echo '</table>';
	else :
		echo "Det finns inga filmer som är markerade för att ses";
	endif;
	?>
</div>
<?php
require_once 'template/footer.php';
