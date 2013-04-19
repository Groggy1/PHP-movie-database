<form action="install.php" method="post">
	<?php
	for ($i = 0; $i < $_POST['numberusers']; $i++) {
		echo '<input type="text" name="' . $i . '" />';
	}
	echo '<input type="hidden" name="numberusers" value="' . $_POST['numberusers'] . '" />';
	?>
	<button type="submit">
		Nästa
	</button>
</form>
