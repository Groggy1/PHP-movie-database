<p class="edit">
	[<a href="<?= URL . 'series/edit/' . $url['id'] ?>">Ändra</a>]
</p>
<?php
echo '<h1><a href="' . $viewModel -> get("infopage") . '" target="_blank">' . $viewModel -> get("seriesname") . '</a></h1>';
echo $viewModel -> get("seriesdesc");
$functions = new Functions();
$functions -> printTable($viewModel -> get("tableBody"), $viewModel -> get("tableHead"));
