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

	public function rssCheckboxTableMaker($feeds) {
		$i = 0;
		foreach ($feeds as $value) {
			$tableBody[$i][] = '<input type="checkbox" name="' . $i . '" value="' . $value['id'] . '"' . (is_null($value['user_id']) ? '' : ' checked') . '>';
			$tableBody[$i][] = $value['name'];
			$tableBody[$i][] = '<a href="' . $value['url'] . '" target="_blank">' . $value['url'] . '</a>';
			$tableBody[$i][] = '<a href="' . $value['feedurl'] . '" target="_blank">' . $value['feedurl'] . '</a>';
			$i++;
		}
		return $tableBody;
	}

	public function getFeedData($url) {
		$i = 0;
		$file = file_get_contents($url['feedurl']);
		$xml = simplexml_load_string($file, 'SimpleXMLElement', LIBXML_NOCDATA);
		if (!$xml) {
			$xml = simplexml_load_string($this -> utf8_for_xml($file), 'SimpleXMLElement', LIBXML_NOCDATA);
		}
		$save['feedid'] = $url['id'];
		$save['url'] = $url['url'];
		$xmldata = $xml -> channel -> item;
		foreach ($xmldata as $data) {
			$pubDate = substr($data -> pubDate, 0, 25);
			$pubDate = strftime("%Y-%m-%d %H:%M:%S", strtotime($pubDate));

			$save[$i]['title'] = (string)$data -> title;
			$save[$i]['description'] = strip_tags((string)$data -> description);
			$save[$i]['link'] = (string)$data -> link;
			$save[$i]['pubDate'] = $pubDate;
			$i++;
		}
		return $save;
	}

	public function utf8_for_xml($string) {
		return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
	}

}
