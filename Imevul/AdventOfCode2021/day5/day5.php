<?php
/*
 * Hydrothermal Venture
 * https://adventofcode.com/2021/day/5
 */

namespace Imevul\AdventOfCode2021\Day5;

require_once '../../../bootstrap.php';

/**
 * @param bool $useTestData True to use input_test.txt (if it exists)
 * @return array<int>
 */
function getConvertedInput(bool $useTestData = FALSE): array {
	return array_map(fn($l) => array_map(fn($p) => array_map(fn($v) => (int)$v, explode(',', $p)), explode(' -> ', $l)), getInput($useTestData));
}

/**
 * Get the maximum size of the map, based on the points in the input
 * @param array $input Input points
 * @return int
 */
function getMaxSize(array $input): int {
	$max = 0;
	foreach ($input as [$from, $to]) {
		$max = max($max, $from[0]);
		$max = max($max, $from[1]);
		$max = max($max, $to[0]);
		$max = max($max, $to[1]);
	}

	return $max + 1;
}

/**
 * Draw a line on the map, increasing the number of each point
 * @param array<array> $map Map reference
 * @param array{int, int} $from Starting point
 * @param array{int, int} $to Ending point
 * @return void
 */
function drawLine(array &$map, array $from, array $to): void {
	$diff = compare($to, $from);

	$map[$from[1]][$from[0]]++;
	do {
		$from[0] += $diff[0];
		$from[1] += $diff[1];
		$map[$from[1]][$from[0]]++;
	} while ($from != $to);
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	$input = array_filter($input, fn($p) => $p[0][0] == $p[1][0] || $p[0][1] == $p[1][1]);
	return part2($input);
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	$map = createMap(0, getMaxSize($input));

	foreach ($input as [$from, $to]) {
		drawLine($map, $from, $to);
	}

	return array_reduce($map, fn($c1, $y) => $c1 + array_reduce($y, fn($c2, $x) => $x >= 2 ? $c2 + 1 : $c2, 0), 0);
}

$input = getConvertedInput(TRUE);
assertEquals([part1($input), part2($input)], [5, 12], 'Part');

$input = getConvertedInput();
output('Solution1: ', part1($input));
output('Solution2: ', part2($input));
