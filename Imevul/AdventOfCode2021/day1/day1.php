<?php
/*
 * Sonar Sweep
 * https://adventofcode.com/2021/day/1
 */

namespace Imevul\AdventOfCode2021\Day0;

require_once '../../../bootstrap.php';

/**
 * @param bool $useTestData True to use input_test.txt (if it exists)
 * @return array<int>
 */
function getConvertedInput(bool $useTestData = FALSE): array {
	return array_map(fn($v) => (int)$v, getInput($useTestData));
}

/**
 * @param array<int> $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	[$result] = array_reduce(
		$input,
		fn($c, $i) => [$c[0] += $i > $c[1], $i],
		[0, INF]
	);

	return $result;
}

/**
 * @param array<int> $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	$result = 0;
	$prev = INF;
	$windowSize = 3;

	for ($i = 0; $i < count($input) - ($windowSize - 1); $i++) {
		$sum = array_sum(array_slice($input, $i, $windowSize));
		$result += $sum > $prev;
		$prev = $sum;
	}

	return $result;
}

$input = getConvertedInput();
output('Solution1: ', part1($input));
output('Solution2: ', part2($input));
