<?php
class Display {
	public function dispselectuser($array) {
		//echos out a select with name "userid"
		//The array should contain several users with both id and name, taken from the database
		echo '<select name="userid">';
		foreach ($array as $value) {
			echo "<option value=\"" . $value['id'] . "\">" . $value['name'] . "</option>";
		}
		echo '</select>';
	}
}
