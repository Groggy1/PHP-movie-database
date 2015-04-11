<div id="movie">
	<div class="page-header">
		<p class="edit">
			[<a href="<?= URL . 'movie/edit/' . $url['id'] ?>">ändra</a>]
		</p>
		<h1><?php
$imdbid = $viewModel -> get('imdbid');
if (!empty($imdbid)) {
		?>
		<a href="http://www.imdb.com/title/<?= $viewModel -> get('imdbid') ?>" target="_blank"> <?php
		}
		echo $viewModel -> get('title') . ' (' . $viewModel -> get('year') . ')';
		if (!empty($imdbid)) {
		echo '</a>';
		}
		?>
		<br />
		<small><strong>Poäng:</strong> <?= $viewModel -> get('avgPoints') ?>
			av 5.0 möjliga</small></h1><strong>Genres:</strong><?php $genre = explode('|', $viewModel -> get('genre'));
			foreach ($genre AS $value) {
				$value2 = explode(',', $value);
				echo '<a href="' . URL . 'movie/index/g' . $value2[0] . '">' . $value2[1] . '</a>';
				if (end($genre) !== $value) {
					echo ', ';
				}
			}
		?>
		<strong>Spr&aring;k/texning:</strong><?= $viewModel -> get('sub') ?>
		<strong>Typ:</strong><?= $viewModel -> get('type') ?>
		<strong>Speltid:</strong><?php echo $viewModel -> get('runtime') . ' minuter'; ?>
	</div>
	<div class="row">
		<div class="col-md-4">
			<img src="<?= URL . 'public/img/posters/' . $viewModel -> get('poster') ?>" class="img"/>
		</div>
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<h2>Handlning</h2>
					<?= nl2br($viewModel -> get('plot')) ?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-7">
					<h2>Trailer</h2>
					<?php
					if (strlen($viewModel -> get('youtube')) > 0) {
						echo '<iframe width="420" height="315" src="//www.youtube.com/embed/' . $viewModel -> get('youtube') . '" frameborder="0" allowfullscreen></iframe>';
					}
					?>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-5 betyg">
					<div class="clearfix"></div>
					<h2>Betyg</h2>
					<?php
					$func = new Functions();
					$func -> printTable($viewModel -> get('betygBody'), $viewModel -> get('betygHead'));
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-3 col-md-3">
			<h2>Skådespelare</h2>
			<?php $actor = explode('|', $viewModel -> get('actor'));
				foreach ($actor AS $value) {
					$value2 = explode(',', $value);
					echo '<a href="' . URL . 'movie/index/a' . $value2[0] . '">' . $value2[1] . '</a><br>';
				}
			?>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3">
			<h2>Regisörer</h2>
			<?php $director = explode('|', $viewModel -> get('director'));
				foreach ($director AS $value) {
					$value2 = explode(',', $value);
					echo '<a href="' . URL . 'movie/index/d' . $value2[0] . '">' . $value2[1] . '</a><br>';
				}
			?>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3">
			<h2>Kommentarer</h2>
			<?php
			foreach ($viewModel -> get('comments') AS $value) {
				echo '<p><strong>' . $value['name'] . '</strong> ' . $value['date'] . '</p>';
				echo '<p>' . nl2br($value['comment']) . '</p>';
			}
			?>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3">
			<h2>Kommentera</h2>
			<form class="form-horizontal" name = "input" action = "<?=  URL ?>movie/addcomment/" method = "post">
				<textarea name="comment" rows="10"></textarea>
				<input type="hidden" name="mid" value="<?php echo $url['id']; ?>" />
				<button class="btn btn-primary" type="submit">
					L&auml;gg till kommentar
				</button>
			</form>
		</div>
	</div>
</div>