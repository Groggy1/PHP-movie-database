<p>Poäng är beräknade på filmens genres och de filmer du betygsatt sedan tidigare.</p>
<?php
$functions = new Functions();
$functions -> printTable($viewModel -> get("tableBody"), $viewModel -> get("tableHead"));