<?php
/*
 * Uppdaterar runtime på de filmer som inte har en redan
 * Bra efter 2013-07-03 uppdateringen av scriptet om det installerades innan
 * Bör inte köras "för ofta" då data scrapas från imdB varje gång
 * Väljer en film att uppdatera vid varje körning av skriptet
 */

 include'../class/database.php';
 include'../class/arraytools.php';
 include '../class/imdb.php';
 $db = new Database();
 $ar = new Arraytools();
 $imdb = new Imdb();
 
 $sql = "SELECT imdbid FROM movies
 		WHERE runtime = 0 AND imdbid != ''";
		
$result = array_values($ar -> unique_flat_array($db -> select_query($sql)));

$movietopick = rand(0,sizeof($result) - 1);

$movieArray = $imdb -> getMovieInfoById($result[$movietopick]);

$sql = "UPDATE `movies` SET `runtime`=:runtime
		WHERE `imdbid` = :imdbid";

$db -> select_query($sql,array(':runtime' => $movieArray['runtime'], ':imdbid' => $result[$movietopick]));