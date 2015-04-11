<?php
class ArrayTools {
	public function flatten_array($array) {
		$out = array();

		foreach ($array as $key => $value) {
			if (is_array($array[$key])) {
				$out = array_merge($out, $this -> flatten_array($array[$key]));
			} else {
				$out[] = $value;
			}
		}
		return $out;
	}

	public function unique_flat_array($array) {
		$out = $this -> flatten_array($array);
		return array_unique($out);
	}

	public function pickvalues_to_array($post, $start, $stop){
		$result = array();
		for($i = $start; $i <= $stop;$i++){
			$result[] = $post[$i];
		}
		return $result;
	}
}
