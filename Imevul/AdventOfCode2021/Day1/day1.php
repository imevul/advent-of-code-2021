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
	return count(array_filter($input, fn($v, $k) => $v > $input[$k - 1], ARRAY_FILTER_USE_BOTH)) - 1;
}

/**
 * @param array<int> $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	return count(array_filter($input, fn($v, $k) => $v > $input[$k - 3], ARRAY_FILTER_USE_BOTH)) - 3;
}

return [test([7, 5]), run(empty($skipRun))];
