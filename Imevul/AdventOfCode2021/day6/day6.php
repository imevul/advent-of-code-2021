<?php
/*
 * Lanternfish
 * https://adventofcode.com/2021/day/6
 */

namespace Imevul\AdventOfCode2021\Day6;

require_once '../../../bootstrap.php';

/**
 * @param bool $useTestData True to use input_test.txt (if it exists)
 * @return array<int>
 */
function getConvertedInput(bool $useTestData = FALSE): array {
	return array_map(fn($v) => (int)$v, explode(',', getInput($useTestData)[0]));
}

/**
 * Simulate a set of fishes over a period of time. Return how many fish there are after that period is up.
 * @param array<int> $input Input fishes
 * @param int $numDays Number of days to simulate
 * @return int
 */
function simulateFish(array $input, int $numDays): int {
	$fishes = array_fill(0, 9, 0);
	array_walk($input, function($v) use (&$fishes) { $fishes[$v]++; });

	for ($i = 0; $i < $numDays; $i++) {
		$numFish = array_shift($fishes);
		$fishes[6] = ($fishes[6] ?? 0) + $numFish;
		$fishes[8] = $numFish;
	}

	return array_sum($fishes);
}

/**
 * @param array<int> $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	return simulateFish($input, 80);
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	return simulateFish($input, 256);
}

$input = getConvertedInput(TRUE);
assertEquals([part1($input), part2($input)], [5934, 26984457539], 'Part');

$input = getConvertedInput();
output('Solution1: ', part1($input));
output('Solution2: ', part2($input));
