<?php
class Functions {

	public function printTable($body, $header = FALSE, $footer = FALSE, $class = FALSE) {
		echo '<table class="table table-condensed table-responsive">';
		if ($header) {
			echo '<thead>
		<tr>';
			foreach ($header as $value) {
				echo '<th>' . $value . '</th>';
			}
			echo '</tr>
	</thead>';
		}
		echo '<tbody>';
		foreach ($body as $key => $value) {
			$trclass = (!empty($class[$key])) ? $class[$key] : '';
			echo '<tr ' . $trclass . '>';
			foreach ($value as $value2) {
				echo '<td>' . $value2 . '</td>';
			}
			echo '</tr>';
		}
		echo '</tbody>';
		if ($footer) {
			echo '<tfoot>
		<tr>';
			foreach ($footer as $value) {
				echo '<th>' . $value . '</th>';
			}
			echo '</tr>
	</tfoot>';
		}
		echo '</table>';
	}
}
