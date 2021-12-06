<?php
/*
 * Boilerplate
 * URL
 */

namespace Imevul\AdventOfCode2021\Day0;

require_once '../../../bootstrap.php';

/**
 * @param bool $useTestData True to use input_test.txt (if it exists)
 * @return array<int>
 */
function getConvertedInput(bool $useTestData = FALSE): array {
	return getInput(__DIR__, $useTestData);
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

test([0, 0]);
return run();
