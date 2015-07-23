<a href="<?= URL . $url['controller'] . '/display/' . $url['id'] ?>">Tillbaka</a>
<form class="form-horizontal" name = "input" action="<?= URL . $url['controller'] . '/makeedit/' . $url['id']; ?>" method = "post">
	<div class="row">
		<div class="col-md-3">
			<div class="control-group">
				<label class="control-label" for="inputTitle">Titel:</label>
				<div class="controls">
					<input value="<?= $viewModel -> get('title'); ?>" name="title" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputImdbid">imDB-id:</label>
				<div class="controls">
					<input value="<?= $viewModel -> get('imdbid'); ?>" name="imdbid" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputYear">År:</label>
				<div class="controls">
					<input value="<?= $viewModel -> get('year'); ?>" name="year" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputTrailer">Trailer:</label>
				<div class="controls">
					<input value="<?= $viewModel -> get('youtube'); ?>" name="youtube" />
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="control-group">
				<label class="control-label" for="inputRuntime">Speltid:</label>
				<div class="controls">
					<input value="<?= $viewModel -> get('runtime'); ?>" name="runtime" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPoster">Poster:</label>
				<div class="controls">
					<input value="<?= $viewModel -> get('poster'); ?>" name="poster" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputTyp">Typ:</label>
				<div class="controls">
					<select name="type">
						<option></option>
						<?php
						foreach ($viewModel -> get('types') as $key => $value) {
							echo '<option value="' . $key . '"';
							if ($value == $viewModel -> get('type')) {
								echo ' selected="selected"';
							}
							echo '>' . $value . '</option>';
						}
						?>
					</select>
				</div>
			</div>
			<div class="row nospace">
				<div class="control-group col-md-6">
					<label class="control-label" for="inputTyp">Serie:</label>
					<div class="controls">
						<select name="series">
							<option></option>
							<?php
							foreach ($viewModel -> get('series') as $value) {
								echo '<option value="' . $value["id"] . '"';
								if ($value["name"] == $viewModel -> get('theSerie')) {
									echo ' selected="selected"';
								}
								echo '>' . $value["name"] . '</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="control-group col-md-6">
					<label class="control-label" for="inputTyp">Nummer:</label>
					<div class="controls">
						<input value="<?= $viewModel -> get('number'); ?>" name="number" />
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="control-group">
				<label class="control-label" for="inputTyp">Textning:</label>
				<div class="controls">
					<select name="sub">
						<option value="Ingen text, engelst tal" <?= ($viewModel -> get('sub') == "Ingen text, engelst tal") ? ' selected="selected"' : '' ?>>Ingen text, engelskt tal</option>
						<option value="Ingen text, svenskt tal" <?= ($viewModel -> get('sub') == "Ingen text, svenskt tal") ? ' selected="selected"' : '' ?>>Ingen text, svenskt tal</option>
						<option value="Svensk text" <?= ($viewModel -> get('sub') == "Svensk text") ? ' selected="selected"' : '' ?>>Svensk text</option>
						<option value="Engelsk text" <?= ($viewModel -> get('sub') == "Engelsk text") ? ' selected="selected"' : '' ?>>Engelsk text</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputStoryline">Kommentarer:</label>
				<div class="controls">
					<table class="table tabel-striped">
						<?php
						foreach ($viewModel -> get('comments') as $key => $value) {
							echo '<tr><td>' . $value['comment'] . '</td><td><a href="' . URL . $url['controller'] . '/removecomment/' . $value['id'] . '"><span class="glyphicon glyphicon-remove"></span></a></td></tr>';
						}
						?>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="control-group">
				<label class="control-label" for="inputStoryline">Plot:</label>
				<div class="controls">
					<textarea rows="10" name="plot"><?= $viewModel -> get('plot'); ?></textarea>
				</div>
			</div>
		</div>
	</div>
	<button class="btn btn-primary" type="submit" name="submit">
		Ändra!
	</button>
</form>

<!--
<?php
echo '<pre>';
var_dump($viewModel);
echo '</pre>';
?>-->
