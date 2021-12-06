<?php

namespace Imevul\AdventOfCode2021;

$days = [];
foreach (range(1, 6) as $day) {
	if (file_exists("day$day/day$day.php")) {
		/** @noinspection PhpIncludeInspection */
		$days[$day] = include_once("day$day/day$day.php");
	}
}

foreach ($days as $day => $result) {
	echo "Day $day:\n";
	foreach ($result as $i => $v) {
		printf("\tPart%s = %d\n", $i + 1, $v);
	}
}
