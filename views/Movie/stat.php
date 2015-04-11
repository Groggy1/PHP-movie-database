<h2>Statistik</h2>
<div class="row">
	<div class="col-md-4">
		<h4>Filmer</h4>
		<?php
		echo '<p>Det finns <strong>' . $viewModel -> get(antalfilmer) . '</strong> filmer i databasen</p>';
		echo '<p>Av dessa har <strong>' . $viewModel -> get(watched) . '</strong> filmer setts';
		echo '<p><strong>' . $viewModel -> get(towatch) . '</strong> filmer är markerade för att ses</p>';
		echo '<p><strong>' . $viewModel -> get(watchedtowatch) . '</strong> filmer har varit markerade för att ses och setts</p>';
		echo '<p>Det finns <strong>' . $viewModel -> get(numberinqueue) . '</strong> filmer i kö</p>';
		echo '<p><strong>' . $viewModel -> get(movieswithoutruntime) . '</strong> filmer saknar speltid</p>';
		?>
	</div>
	<div class="col-md-4">
		<h4>Filminnehåll</h4>
		<?php
		echo '<p>Filmerna har regiserats av <strong>' . $viewModel -> get(numberofdirectors) . '</strong> olika regisörer</p>';
		echo '<p>I filmerna finns det totalt <strong>' . $viewModel -> get(numberofactors) . '</strong> skådespelare</p>';
		echo '<p>Filmerna spänner över <strong>' . $viewModel -> get(numberofgenres) . '</strong> olika genres</p>';
		$subtitle = $viewModel -> get(subtitle);
		for ($i = 0; $i <= sizeof($subtitle) - 1; $i++) :
			echo '<p>Det finns <strong>' . $subtitle[$i][1] . '</strong> filmer med <strong>' . $subtitle[$i][0] . '</strong></p>';
		endfor;
		?>
	</div>
	<div class="col-md-4">
		<h4>Användardata</h4>
		<?php
		$votes = $viewModel -> get(votes);
		echo '<p>Det har postats totalt <strong>' . $viewModel -> get(comments) . '</strong> kommentar på filmerna</p>';
		echo '<p>Det har postats <strong>' . $viewModel -> get(numberofnews) . '</strong> nyheter</p>';
		echo '<p>Det har lagts <strong>' . $votes[0][1] . '</strong> röster på filmerna</p>';
		echo '<p>Rösterna har ett genomsnitt på <strong>' . number_format($votes[0][0], 1) . '</strong> poäng</p>';
		?>
	</div>
</div>