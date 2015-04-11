<div class="row nospace">
	<?php
	foreach ($viewModel -> get("posters") as $key => $value) {
		echo '<div class="col-md-4"><a href="' . URL . 'movie/display/' . $value['id'] . '"><img src="' . URL . 'public/img/posters/' . $value['poster'] . '" class="img"></a></div>';
	}
	?>
</div>