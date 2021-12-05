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
	return getInput($useTestData);
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

$input = getConvertedInput(TRUE);
$parts = [part1($input), part2($input)];
assert($parts[0] === 0, "Part1: Failed to assert that $parts[0] === 0");
assert($parts[1] === 0, "Part2: Failed to assert that $parts[1] === 0");

$input = getConvertedInput(TRUE);
output('Solution1: ', part1($input));
output('Solution2: ', part2($input));
