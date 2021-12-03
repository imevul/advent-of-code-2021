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
 * Move the submarine according to some predefined actions and commands
 * @param array<string, int> $input Array of actions
 * @param array<Callable> $commands Array of command => Callable that specifies how the submarines position is modified for each command
 * @return int
 */
function moveSubmarine(array $input, array $commands): int {
	$position = [0, 0, 0];	// Horizontal, Depth, (Aim)

	foreach ($input as [$command, $action]) {
		$commands[$command]($position, $action);
	}

	return $position[0] * $position[1];
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	return moveSubmarine($input, [
		'forward' => fn(&$p, $a) => $p[0] += $a,
		'up'      => fn(&$p, $a) => $p[1] -= $a,
		'down'    => fn(&$p, $a) => $p[1] += $a
	]);
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	return moveSubmarine($input, [
		'forward' => function (&$p, $a) {
			$p[0] += $a;
			$p[1] += $p[2] * $a;
		},
		'up'      => fn(&$p, $a) => $p[2] -= $a,
		'down'    => fn(&$p, $a) => $p[2] += $a
	]);
}

$input = getConvertedInput(TRUE);
$parts = [part1($input), part2($input)];
assert($parts[0] === 150, "Part1: Failed to assert that $parts[0] === 150");
assert($parts[1] === 900, "Part2: Failed to assert that $parts[1] === 900");

$input = getConvertedInput();
output('Solution1: ', part1($input));
output('Solution2: ', part2($input));
