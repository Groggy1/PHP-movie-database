<?php
require_once 'class/database.php';

$sql = "SELECT * FROM news
		ORDER BY id DESC";

$db = new Database();

$result = $db -> select_query($sql, array(), 10, 1);

$sitetitle = "Nyheter";
require_once ('template/header.php');
?>
<div class="hero-unit">
	<div class="row-fluid">
		<div class="span9">
			<h5> Nyheter! </h5>
			<?php
			foreach ($result as $value) {
				echo "<b>" . $value[name] . "</b>, " . $value[date] . "<p>";
				echo $value[description];
				echo "</p>";
			}
			?>
		</div>
		<div class="span3">
			<h5>L&auml;gg till nyhet</h5>
			<form name = "input" action = "addnews.php" method = "post">
				<input type="text" name="name" class="name" placeholder="Ditt namn"/>
				<br />
				<textarea name="description" rows="10" placeholder="Vad har gjorts?"></textarea>
				<br />
				<input type="submit" value="submit" class="btn btn-primary" />
			</form>
		</div>
	</div>
</div>
<?php
require_once ('template/footer.php');