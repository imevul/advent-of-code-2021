<?php
/*
 * Boilerplate
 * https://adventofcode.com/2021/day/0
 */

namespace Imevul\AdventOfCode2021\Day0;

require_once __DIR__ . '/../../../bootstrap.php';

function getConvertedInput(array $input): array {
	return $input;
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	$result = 0;

	foreach ($input as $item) {
		$result += (int)$item;
	}

	return $result;
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	return 0;
}

return [test([NULL, NULL]), run(empty($skipRun))];
