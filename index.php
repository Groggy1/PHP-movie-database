<?php
$starting_time_measure = MICROTIME(TRUE);
require_once 'class/database.php';

$db = new Database();

$sql = "SELECT id, title, poster
		FROM movies
		ORDER BY id DESC";
		
$movie = $db -> select_query($sql,array(),6,1);

$sitetitle = "Index";
require_once 'template/header.php';
?>
<script>
	$(document).ready(function() {
		$('.carousel').carousel({
			interval : 2000
		});
	}); 
</script>

<div id="carousel" class="carousel slide hero-unit">
	<div class="carousel-inner">
		<div class="item active">
			<div class="row-fluid no-space">
				<?php
				for ($i = 0; $i <= 2; $i++) {
					echo '<div class="span4"><a href="dispmovie.php?id=' . $movie[$i][id] . '"><img src="img/posters/' . $movie[$i][poster] . '" width = "100%" /></a></div>';
				}
				?>
			</div>
		</div>
		<div class="item">
			<div class="row-fluid no-space">
				<?php
				for ($i = 3; $i <= 5; $i++) {
					echo '<div class="span4"><a href="dispmovie.php?id=' . $movie[$i][id] . '"><img src="img/posters/' . $movie[$i][poster] . '" width = "100%" /></a></div>';
				}
				?>
			</div>
		</div>
	</div>
	<a class="carousel-control left" href="#carousel" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#carousel" data-slide="next">&rsaquo;</a>
</div>
<?php
require_once 'template/footer.php';