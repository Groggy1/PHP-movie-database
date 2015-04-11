<div class="row">
	<div class="col-md-10">
		<?php
		$func = new Functions();
		$func -> printTable($viewModel -> get('tableBody'), $viewModel -> get('tableHead'));
		?>
	</div>

	<div class="col-md-2">
		<form class="form-horizontal" name = "input" action = "<?php echo URL . $url['controller'] . '/addqueue'; ?>" method = "post">
				<input class="form-control" type="text" name="imdbid" placeholder="imdB ID" />
				<button type="submit" class="btn btn-default">
					Lägg till
				</button>
		</form>
	</div>
</div>