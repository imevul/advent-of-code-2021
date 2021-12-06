<?php

namespace Imevul\AdventOfCode2021;

require_once __DIR__ . '/../../bootstrap.php';

$days = [];
$directories = glob('Day*');

foreach (range(1, (int)$directories[array_key_last($directories)][-1]) as $day) {
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
