<?php
/*
 * Sonar Sweep
 * https://adventofcode.com/2021/day/1
 */

namespace Imevul\AdventOfCode2021\Day1;

require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @param array $input
 * @return array<int>
 */
function getConvertedInput(array $input): array {
	return array_map('intval', $input);
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
	array_walk($input, fn(&$v, $k) => $v = array_sum(array_slice($input, $k, 3)));
	[$result] = array_reduce(
		$input,
		fn($c, $i) => [$c[0] += $i > $c[1], $i],
		[0, INF]
	);

	return $result;
}

test([7, 5]);
return run();
