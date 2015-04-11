<div class="row-fluid">
	<form class="form-horizontal" name = "input" action = "<?php echo URL . $url['controller'] . '/publish'; ?>" method = "post">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="inputTitlte" class="col-sm-3 control-label">Titel</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="title" placeholder="Titel" />
				</div>
			</div>
			<div class="form-group">
				<label for="inputYesy" class="col-sm-3 control-label">År</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="year" placeholder="År" />
				</div>
			</div>
			<div class="form-group">
				<label for="inputPoster" class="col-sm-3 control-label">Poster</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="poster" placeholder="Poster" />
				</div>
			</div>
			<div class="form-group">
				<label for="inputRuntime" class="col-sm-3 control-label">Speltid</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="runtime" placeholder="Speltid" />
				</div>
			</div>
			<div class="form-group">
				<label for="inputYoutube" class="col-sm-3 control-label">Youtube ID</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="youtube" placeholder="Youtube trailer" />
				</div>
			</div>
			<div class="form-group">
				<label for="inputPlot" class="col-sm-3 control-label">Handling</label>
				<div class="col-sm-9">
					<textarea name="plot" rows="10"></textarea>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="inputDirector" class="col-sm-3 control-label">Regisör</label>
				<div class="col-sm-9">
					<?php
					$director = 0;
					for ($i = 0 ; $i < $viewModel -> get('Nodir') ; $i++) {
						$director = $director + 1;
						echo '<input class="form-control" type="text" name="' . $director . '" placeholder="Regisör" value="' . $value . '" />';
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="inputActor" class="col-sm-3 control-label">Skådespelare</label>
				<div class="col-sm-9">
					<?php
					$actor = 99;
					for ($i = 0 ; $i < $viewModel -> get('Noact') ; $i++) {
						$actor = $actor + 1;
						echo '<input class="form-control" type="text" name="' . $actor . '" placeholder="Skådespelare" value="' . $value . '" />';
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="inputGenre" class="col-sm-3 control-label">Genrer</label>
				<div class="col-sm-9">
					<?php
					$genre = 999;
					for ($i = 0 ; $i < $viewModel -> get('Nogen') ; $i++) {
						$genre = $genre + 1;
						echo '<input class="form-control" type="text" name="' . $genre . '" placeholder="Skådespelare" value="' . $value . '" />';
					}
					?>
				</div>
			</div>
		</div>
		<input type="hidden" name="imdbid" value="" />
		<input type="hidden" name="NoDirectors" value="<?php echo $director;?>" />
		<input type="hidden" name="NoActors" value="<?php echo $actor;?>" />
		<input type="hidden" name="NoGenres" value="<?php echo $genre;?>" />
		<input type="hidden" name="type" value="<?php echo $viewModel -> get('type');?>" />
		<input type="hidden" name="sub" value="<?php echo $viewModel -> get('sub');?>" />
		<div class="col-md-offset-5 col-md-2 col-md-offset-5 col-sm-12 col-xs-12"><button type="submit" class="btn btn-default fullwidth">Lägg till</button> </div>
	</form>
</div>
<br clear="all">