<div class="row-fluid">
	<div class="col-md-6 col-sm-12 col-xs-12">
		<form class="form-horizontal" name = "input" action = "<?php echo URL . $url['controller'] . '/addimdb'; ?>" method = "post">
			<h4>Hämta data från imdB</h4>
			<div class="form-group">
				<label for="inputImdbId" class="col-sm-2 control-label">imdB ID</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" name="imdbid" placeholder="imdB ID" value="<?php echo $url['id']; ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="inputSub" class="col-sm-2 control-label">Textning</label>
				<div class="col-sm-10">
					<select name="sub" class="form-control">
						<option value="Ingen text, engelst tal">Ingen text, engelskt tal</option>
						<option value="Ingen text, svenskt tal">Ingen text, svenskt tal</option>
						<option value="Svensk text">Svensk text</option>
						<option value="Engelsk text">Engelsk text</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputType" class="col-sm-2 control-label">Typ</label>
				<div class="col-sm-10">
					<select name="type" class="form-control">
						<?php
						foreach ($viewModel -> get('movietype') as $value) {
							echo '<option value="' . $value['short'] . '">' . $value['type'] . '</option>';
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">
						Nästa
					</button>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-6 col-sm-12 col-xs-12">
		<form class="form-horizontal" name = "input" action = "<?php echo URL . $url['controller'] . '/addman'; ?>" method = "post">
			<h4>Mata in data själv</h4>
			<div class="form-group">
				<label for="inputImdbId" class="col-sm-2 control-label">Regisörer</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" name="Nodir" placeholder="Antal regisörer" />
				</div>
			</div>
			<div class="form-group">
				<label for="inputImdbId" class="col-sm-2 control-label">Skåespelare</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" name="Noact" placeholder="Antal skådespelare" />
				</div>
			</div>
			<div class="form-group">
				<label for="inputImdbId" class="col-sm-2 control-label">Genrer</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" name="Nogen" placeholder="Antal genrer" />
				</div>
			</div>
			<div class="form-group">
				<label for="inputSub" class="col-sm-2 control-label">Textning</label>
				<div class="col-sm-10">
					<select name="sub" class="form-control">
						<option value="Ingen text, engelst tal">Ingen text, engelskt tal</option>
						<option value="Ingen text, svenskt tal">Ingen text, svenskt tal</option>
						<option value="Svensk text">Svensk text</option>
						<option value="Engelsk text">Engelsk text</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputType" class="col-sm-2 control-label">Typ</label>
				<div class="col-sm-10">
					<select name="type" class="form-control">
						<?php
						foreach ($viewModel -> get('movietype') as $value) {
							echo '<option value="' . $value['short'] . '">' . $value['type'] . '</option>';
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">
						Nästa
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
<br clear="all">
