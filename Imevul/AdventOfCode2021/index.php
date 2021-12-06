<?php

namespace Imevul\AdventOfCode2021;

require_once __DIR__ . '/../../bootstrap.php';

$days = [];
$directories = glob('Day*');
$maxDay = (int)$directories[array_key_last($directories)][-1];

for ($i = 1; $i <= $maxDay; $i++) {
	$filename = "day$i/day$i.php";
	if (file_exists($filename)) {
		$days[$i] = include_once($filename);
	}
}

foreach ($days as $day => $result) {
	echo "Day $day:\n";
	foreach ($result as $i => $v) {
		printf("\tPart%s = %d\n", $i + 1, $v);
	}
}
