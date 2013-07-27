<?php
header('Content-Type:text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
<channel>  
<title>FilmDB</title>  
<description>Senast tillagda filmer</description>  
<link>http://groggy1.tk/filmdb</link>';

require_once '../class/database.php';
$db = new Database();
$sql = "SELECT `id`,`title`,`date` FROM `movies`
		ORDER BY date desc, id desc
		LIMIT 10";

$result = $db -> select_query($sql);

foreach ($result as $value) {
	$value['date'] .= " +02:00";
	echo '
	<item>
		<title>'.htmlspecialchars($value['title']).'</title>
		<description><![CDATA[]]></description> 
		<link>http://www.groggy1.tk/filmdb/dispmovie.php?id='.$value['id'].'</link>
		<pubDate>'.date("r",strtotime($value['date'])).'</pubDate>
	</item>';
}
echo '</channel>
</rss>';
