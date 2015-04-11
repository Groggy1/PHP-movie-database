<?php
$posters = $viewModel -> get('posters');
$first = $posters[0];
$second = $posters[1];
$third = $posters[2];
?>
<div class="row nospace">
	<?php
	foreach ($viewModel -> get('posters') as $value) {
		echo $value;
	}
	?>
</div>
<div class="fullwidth">
	<a <?=$viewModel -> get("getPrew") ?>><span class="glyphicon glyphicon-chevron-left pull-left"></span></a>
	<a <?=$viewModel -> get("getNext") ?>><span class="glyphicon glyphicon-chevron-right pull-right"></span></a>
	<br clear="all">
</div>