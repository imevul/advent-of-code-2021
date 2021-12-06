<?php

namespace Imevul\AdventOfCode2021;

require_once __DIR__ . '/../../bootstrap.php';

$days = [];
$directories = glob('Day*');
$maxDay = (int)$directories[array_key_last($directories)][-1];

for ($i = 1; $i <= $maxDay; $i++) {
	$filename = "day$i/day$i.php";
	if (file_exists($filename)) {
		$days[$i] = [$i, ...include_once($filename)];
	}
}

$color = new \Console_Color2();
$cOK = '%G';
$cBad = '%R';

$data = [];
foreach ($days as $day) {
	$data[] = [
		$day[1][0] && $day[1][1] ? $color->convert("$cOK{$day[0]}%n") : $color->convert("$cBad{$day[0]}%n"),
		$day[1][0] ? $color->convert("$cOK{$day[2][0]}%n") : $color->convert("$cBad{$day[2][0]}%n"),
		$day[1][1] ? $color->convert("$cOK{$day[2][1]}%n") : $color->convert("$cBad{$day[2][1]}%n"),
	];
}

$table = new \Console_Table(color: TRUE);
$table->setHeaders(['Day', 'Part1', 'Part2']);
$table->addData($data);
echo $table->getTable();
