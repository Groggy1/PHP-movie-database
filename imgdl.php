<?php
$url = $_GET['url'];
$path = $_GET['path'];

echo '<pre>';
var_dump($_GET);
echo '</pre>';

file_put_contents('public/img/posters/' . $path, file_get_contents($url));
?>
<!DOCTYPE html>
<html>
	<head>
	</head>
	<script type="text/javascript">
function poponload()
{
	close();
}
</script>
	<body onload="javascript: poponload()"></body>
</html>