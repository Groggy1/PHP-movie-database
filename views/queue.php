<?php
$sql = "SELECT queue.imdb, queue.title, queue.year, queue.added, genres.genre
		FROM queue JOIN genresinqueue ON queue.id = genresinqueue.movie_id
		JOIN genres ON genres.id = genresinqueue.genre_id
		ORDER BY queue.id DESC, genres.genre ASC";


$result = $db -> select_query($sql);

$i = 0;
foreach ($result as $value) {
	if ($movies[$i]['title'] != $value['title']) {
		$i++;
		$movies[$i]['title'] = $value['title'];
		$movies[$i]['imdb'] = $value['imdb'];
		$movies[$i]['year'] = $value['year'];
		$movies[$i]['added'] = $value['added'];
		$k = 0;
	}
	$movies[$i]['genre'][$k] = $value['genre'];
	$k++;
}

$sitetitle = "L&auml;gg till bevakning";
require_once 'template/header.php';
?>
<div class="hero-unit">
	<div class="row-fluid">
		<div class="span8">
			<?php
			if (sizeof($movies) > 0){
			?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Titel</th>
						<th>Genres</th>
						<th>Tillagd</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($movies as $value) {
						echo '<tr><td><p><a href="http://www.imdb.com/title/' . $value['imdb'] . '" target="_blank">' . $value['title'] . '</a> (' . $value['year'] . ')</p></td>';
						echo '<td><p>' . implode(', ', $value['genre']) . '</p></td><td><p>' . $value['added'] . '</p></td>';
						echo '<td><p><a href="link.php?imdb=' . $value['imdb'] . '"><i class="icon-remove"></i></a></p></td></tr>';
					}
					?>
				</tbody>
			</table>
			<?php
			}
			else {
			echo "Det finns inga filmer att se h&auml;r!";
			}
			?>
		</div>
		<div class="span4">
			<form class="form-horizontal" name = "input" action = "addqueue.php" method = "post">
				<div class="control-group">
					<label class="control-label" for="inputimdb">L&auml;gg till i k&ouml;</label>
					<div class="controls">
						<input type="text" name="imdbid" placeholder="IMDb ID" />
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary">
							L&auml;gg till!
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
require_once 'template/footer.php';
