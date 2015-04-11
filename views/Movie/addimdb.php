<div class="row-fluid">
	<form class="form-horizontal" name = "input" action = "<?php echo URL . $url['controller'] . '/publish'; ?>" method = "post">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="inputTitlte" class="col-sm-3 control-label">Titel</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="title" placeholder="Titel" value="<?php echo $viewModel -> get('title'); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="inputYesy" class="col-sm-3 control-label">År</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="year" placeholder="År" value="<?php echo $viewModel -> get('year'); ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="inputPoster" class="col-sm-3 control-label">Poster</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="poster" placeholder="Poster" value="<?php echo $viewModel -> get('poster'); ?>" />
					<a href="<?php echo URL . "imgdl.php?url=" . $viewModel -> get(posterURL) . "&path=" . $viewModel -> get(poster);?>" target="_blank">Hämta poster</a>
				</div>
			</div>
			<div class="form-group">
				<label for="inputRuntime" class="col-sm-3 control-label">Speltid</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="runtime" placeholder="Speltid" value="<?php echo $viewModel -> get('runtime'); ?>" />
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
					<textarea name="plot" rows="10"><?php echo $viewModel -> get('plot'); ?></textarea>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="inputDirector" class="col-sm-3 control-label">Regisör</label>
				<div class="col-sm-9">
					<?php
					$director = 0;
					foreach ($viewModel -> get('directors') as $value) {
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
					foreach ($viewModel -> get('cast') as $value) {
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
					foreach ($viewModel -> get('genres') as $value) {
						$genre = $genre + 1;
						echo '<input class="form-control" type="text" name="' . $genre . '" placeholder="Skådespelare" value="' . $value . '" />';
					}
					?>
				</div>
			</div>
		</div>
		<input type="hidden" name="imdbid" value="<?php echo $viewModel -> get('imdbid');?>" />
		<input type="hidden" name="NoDirectors" value="<?php echo $director;?>" />
		<input type="hidden" name="NoActors" value="<?php echo $actor;?>" />
		<input type="hidden" name="NoGenres" value="<?php echo $genre;?>" />
		<input type="hidden" name="type" value="<?php echo $viewModel -> get('type');?>" />
		<input type="hidden" name="sub" value="<?php echo $viewModel -> get('sub');?>" />
		<div class="col-md-offset-5 col-md-2 col-md-offset-5 col-sm-12 col-xs-12"><button type="submit" class="btn btn-default fullwidth">Lägg till</button> </div>
	</form>
</div>
<br clear="all">
