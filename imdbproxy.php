<?php
$starting_time_measure = MICROTIME(TRUE);
include ("class/imdb.php");

$imdbid = $_POST['imdbid'];

if (empty($imdbid)) {
	require_once 'template/header.php';
	echo '<div class="hero-unit"><p>N&aring;got gick fel!</p></div>';
	require_once 'template/footer.php';
	break;
}

$imdb = new Imdb();
$movieArray = $imdb -> getMovieInfoById($imdbid);

if (!empty($movieArray['original_title'])) {
	$title = trim($movieArray['original_title']);
} else {
	$title = trim($movieArray['title']);
}
?>
<?php
$sitetitle = "L&auml;gg till film";

require_once 'template/header.php';
?>
<div class="hero-unit">
	<form class="form-horizontal" name = "input" action = "addmovie.php" method = "post">
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="inputTitle">Titel</label>
					<div class="controls">
						<input type="text" name="title" value="<?php echo $title; ?>" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputYear">&Aring;r</label>
					<div class="controls">
						<input type="text" name="year" value="<?php echo $movieArray['year']; ?>" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPoster">Poster</label>
					<div class="controls">
						<input type="text" name="poster" value="<?php echo $movieArray['poster_large']; ?>" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputStoryline">Plot</label>
					<div class="controls">
						<textarea name="plot" rows="10"><?php echo $movieArray['storyline']; ?></textarea>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="inputDirectors">Regis&ouml;rer</label>
					<div class="controls">
						<?php
						$directors = 0;
						foreach ($movieArray['directors'] as $value) {
							$directors = $directors + 1;
							echo "<input type=\"text\" name=\"" . $directors . "\" value=\"" . $value . "\" />";
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputActors">Sk&aring;despelare</label>
					<div class="controls">
						<?php
						$actors = 99;
						foreach ($movieArray['cast'] as $value) {
							$actors = $actors + 1;
							echo "<input type=\"text\" name=\"" . $actors . "\" value=\"" . $value . "\" />";
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputGenres">Genres</label>
					<div class="controls">
						<?php
						$genres = 999;
						foreach ($movieArray['genres'] as $value) {
							$genres = $genres + 1;
							echo "<input type=\"text\" name=\"" . $genres . "\" value=\"" . $value . "\" />";
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="offset3 span6 offset3">
				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="directors" value="<?php echo $directors; ?>"/>
						<input type="hidden" name="actors" value="<?php echo $actors; ?>"/>
						<input type="hidden" name="genres" value="<?php echo $genres; ?>"/>
						<input type="hidden" name="imdbid" value="<?php echo $imdbid; ?>" />
						<input type="hidden" name="sub" value="<?php echo $_POST['sub']; ?>" />
						<input type="hidden" name="type" value="<?php echo $_POST['type']; ?>" />
						<button class="btn btn-primary" type="submit">
							L&auml;gg till
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<?php
require_once ('template/footer.php');
?>