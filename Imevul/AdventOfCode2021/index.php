<?php

namespace Imevul\AdventOfCode2021;

use Console_Color2;
use Console_Table;
use DateTime;
use SebastianBergmann\Timer\Timer;

require_once __DIR__ . '/../../bootstrap.php';

define('IS_CLI', php_sapi_name() == 'cli');
define('ONLY_LATEST', TRUE);

$days = [];
$directories = glob('Day*');
$maxDay = (int)$directories[array_key_last($directories)][-1];

for ($i = 1; $i <= $maxDay; $i++) {
	$filename = "day$i/day$i.php";
	$skipRun = (ONLY_LATEST && $i === $maxDay) || !ONLY_LATEST;

	if (file_exists($filename)) {
		$timer = new Timer;
		$timer->start();
		$result = include_once($filename);
		$duration = $timer->stop();
		$days[$i] = [$i, ...$result, $duration->asString()];

	}
}

function success(mixed $v, bool $color = TRUE) {
	if ($color) {
		$color = new Console_Color2();

		return $color->convert("%G$v%n");
	}

	return $v;
}

function failure(mixed $v, bool $color = TRUE) {
	if ($color) {
		$color = new Console_Color2();

		return $color->convert("%R$v%n");
	}

	return $v;
}

$data = [];
foreach ($days as $day) {
	$data[] = [
		$day[1][0] && $day[1][1] ? success($day[0], IS_CLI) : failure($day[0], IS_CLI),
		$day[1][0] ? success($day[2][0], IS_CLI) : failure($day[2][0], IS_CLI),
		$day[1][1] ? success($day[2][1], IS_CLI) : failure($day[2][1], IS_CLI),
		$day[3],
	];
}

$table = new Console_Table(color: IS_CLI);
$table->setHeaders(['Day', 'Part1', 'Part2', 'Time']);
$table->addData($data);
$tableText = $table->getTable();
$tableText = IS_CLI ? $tableText : str_replace([' ', PHP_EOL], ['&nbsp;', '<br>'], $tableText);

echo (new DateTime('now'))->format('c') . PHP_EOL;
echo $tableText;

