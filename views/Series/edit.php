<p class="edit">
	[<a href="<?= URL . 'series/remove/' . $url['id'] ?>">Ta bort</a>]
</p>
<a href="<?= URL . $url['controller'] . '/display/' . $url['id'] ?>">Tillbaka</a>
<form class="form-horizontal" name = "input" action="<?= URL . $url['controller'] . '/makeedit/' . $url['id']; ?>" method = "post">
	<div class="row">
		<div class="col-md-4">
			<div class="control-group">
				<label class="control-label" for="inputTitle">Namn:</label>
				<div class="controls">
					<input value="<?= $viewModel -> get('name'); ?>" name="name" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputRuntime">Infosida:</label>
				<div class="controls">
					<input value="<?= $viewModel -> get('infopage'); ?>" name="infopage" />
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="control-group">
				<div class="controls">
					<?php
					$functions = new Functions();
					$functions -> printTable($viewModel -> get("tableBody"), $viewModel -> get("tableHead"));
					?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="control-group">
				<label class="control-label" for="inputStoryline">Beskrivning:</label>
				<div class="controls">
					<textarea rows="10" name="desc"><?= $viewModel -> get('desc'); ?></textarea>
				</div>
			</div>
		</div>
	</div>
	<button class="btn btn-primary" type="submit" name="submit">
		Ändra!
	</button>
</form>
