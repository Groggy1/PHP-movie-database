<?php
$functions = new Functions();
echo $viewModel -> get("actors");
echo $viewModel -> get("directors");
$functions -> printTable($viewModel -> get("tableBody"), $viewModel -> get("tableHead"));
?>