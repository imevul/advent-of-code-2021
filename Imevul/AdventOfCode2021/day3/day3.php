<?php

namespace Imevul\AdventOfCode2021\Day3;

require_once '../../../bootstrap.php';

/**
 * @param bool $useTestData True to use input_test.txt (if it exists)
 * @return array<string>
 */
function getConvertedInput(bool $useTestData = FALSE): array {
	return getInput($useTestData);
}

/**
 * Get a specific metric from the input based on a filter
 * @param array<string> $input The list of binary numbers
 * @param callable $filter A filter to apply based on the bit statistics for each position
 * @param bool $keepOnlyFiltered True to remove any entries that don't match the filter between each bit
 * @return array{string, string}
 */
function getMetric(array $input, callable $filter, bool $keepOnlyFiltered = false): array {
	$filterBits = '';

	for ($i = 0, $count = strlen($input[0]); count($input) > 1 && $i < $count; $i++) {
		$bitStats = array_reduce($input, function($b, $n) use ($i) { $b[$n[$i]]++; return $b; }, [0, 0]);
		$filterBits[$i] = $filter($bitStats) ? 1 : 0;
		$input = $keepOnlyFiltered ? array_filter($input, fn($n) => $n[$i] == $filterBits[$i]) : $input;
	}

	return [array_values($input)[0], $filterBits];
}

/**
 * @param array<string> $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	[$_, $gamma] = getMetric($input, fn($b) => $b[1] >= $b[0]);
	[$_, $epsilon] = getMetric($input, fn($b) => $b[0] > $b[1]);

	return bindec($gamma) * bindec($epsilon);
}

/**
 * @param array<string> $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	[$oxygen] = getMetric($input, fn($b) => $b[1] >= $b[0], TRUE);
	[$scrubber] = getMetric($input, fn($b) => $b[0] > $b[1], TRUE);

	return bindec($oxygen) * bindec($scrubber);
}

$input = getConvertedInput();
output('Solution1: ', part1($input));
output('Solution2: ', part2($input));
