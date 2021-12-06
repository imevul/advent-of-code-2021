<?php
/*
 * Hydrothermal Venture
 * https://adventofcode.com/2021/day/5
 */

namespace Imevul\AdventOfCode2021\Day5;

require_once __DIR__ . '/../../../bootstrap.php';

function getConvertedInput(array $input): array {
	return array_map(fn($l) => array_map(fn($p) => array_map('intval', explode(',', $p)), explode(' -> ', $l)), $input);
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

return [test([5, 12]), run(empty($skipRun))];
