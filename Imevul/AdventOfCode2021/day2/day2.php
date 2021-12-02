<?php
/*
 * Dive!
 * https://adventofcode.com/2021/day/2
 */

namespace Imevul\AdventOfCode2021\Day2;

require_once '../../../bootstrap.php';

/**
 * @param bool $useTestData True to use input_test.txt (if it exists)
 * @return array<int>
 */
function getConvertedInput(bool $useTestData = FALSE): array {
	return array_map(fn($i) => explode(' ', $i), getInput($useTestData));
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	$position = [0, 0];

	$move = function($action) use (&$position) {
		[$command, $amount] = $action;

		switch ($command) {
			case 'forward': $position[0] += $amount; break;
			case 'up':      $position[1] -= $amount; break;
			case 'down':    $position[1] += $amount; break;
		}
	};

	array_walk($input, $move);

	return $position[0] * $position[1];
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	$position = [0, 0, 0];

	$move = function($action) use (&$position) {
		[$command, $amount] = $action;

		switch ($command) {
			case 'forward': $position[0] += $amount; $position[1] += $position[2] * $amount; break;
			case 'up':      $position[2] -= $amount; break;
			case 'down':    $position[2] += $amount; break;
		}
	};

	array_walk($input, $move);

	return $position[0] * $position[1];
}

$input = getConvertedInput();
output('Solution1: ', part1($input));
output('Solution2: ', part2($input));
