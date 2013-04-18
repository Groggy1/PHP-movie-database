<?php
$starting_time_measure = MICROTIME(TRUE);
$actors = $_POST['actors'];
$directors = $_POST['directors'];
$genres = $_POST['genres'];
$type = $_POST['type'];

$sitetitle = "L&auml;gg till film";
require ('template/header.php');
?>
<div class="hero-unit">
	<form class="form-horizontal" name="input" action="addmovie.php" method="post">
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="inputTitle">Titel</label>
					<div class="controls">
						<input type="text" name="title" placeholder="Titel" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputYear">&Aring;r</label>
					<div class="controls">
						<input type="text" name="year" placeholder="&Aring;r" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPoster">Poster</label>
					<div class="controls">
						<input type="text" name="poster" placeholder="Poster" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPlot">Plot</label>
					<div class="controls">
						<textarea name="plot" rows="20" placeholder="Handlingen"></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputImdbid">imdbID</label>
					<div class="controls">
						<input type="text" name="imdbid" placeholder="imdbID" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputSub">Textning</label>
					<div class="controls">
						<select name="sub">
							<option value="Ingen text, engelst tal">Ingen text, engelskt tal</option>
							<option value="Ingen text, svenskt tal">Ingen text, svenskt tal</option>
							<option value="Svensk text">Svensk text</option>
							<option value="Engelsk text">Engelsk text</option>
						</select>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="inputDirectors">Regis&ouml;rer</label>
					<div class="controls">
						<?php
						for ($i = 1; $i <= $directors; $i++) {
							echo "<input type =\"text\" name = \"" . $i . "\" />";
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputActors">Sk&aring;despelare</label>
					<div class="controls">
						<?php
						for ($i = 100; $i < $actors + 100; $i++) {
							echo "<input type =\"text\" name = \"" . $i . "\" />";
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputGenres">Genres</label>
					<div class="controls">
						<?php
						for ($i = 1000; $i < $genres + 1000; $i++) {
							echo "<input type =\"text\" name = \"" . $i . "\" />";
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="well">
			<div class="row-fluid">
				<div class="offset3 span6 offset3">
					<input type="hidden" name="directors" value="<?php echo $directors; ?>"/>
					<input type="hidden" name="actors" value="<?php echo $actors + 100; ?>"/>
					<input type="hidden" name="genres" value="<?php echo $genres + 1000; ?>"/>
					<input type="hidden" name="type" value="<?php echo $type; ?>" />
					<button class="btn btn-primary" type="submit">
						L&auml;gg till
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
<?php
require_once 'template/footer.php';
?>