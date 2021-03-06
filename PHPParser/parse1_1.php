<?php

require_once('parse.php');

class IncreaseNumberParser extends Parser {

	public function output() {
		$target_strings = $this->target->getStrings();
		$last_num = $this->target->extract(0, 1);
		$last_index = 0;
		$max_interval = 0;
		$candidate = "";

		for ($i = 1; $i < strlen($target_strings); $i++) {
			$num = $this->target->extract($i, 1);
			$index = $i;
			if ($last_num->isBigger($num)) {
				if ($index - $last_index >= $max_interval) {
					$candidate = $this->target->extract($last_index, $index - $last_index);
					$max_interval = $index - $last_index;
				}
				$last_index = $index;
			}
			else if (($i === strlen($target_strings) - 1) && (!$last_num->isBigger($num)) && ($index - $last_index >= $max_interval)) {
				$candidate = substr($target_strings, $last_index, $index - $last_index + 1);
			}

			$last_num = $num;
		}

		return $candidate;
	}
}