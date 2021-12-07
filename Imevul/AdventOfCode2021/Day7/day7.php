<?php
/*
 * The Treachery of Whales
 * https://adventofcode.com/2021/day/7
 */

namespace Imevul\AdventOfCode2021\Day7;

require_once __DIR__ . '/../../../bootstrap.php';

function getConvertedInput(array $input): array {
	return array_map('intval', explode(',', $input[0]));
}

/**
 * Get the cost for all crabs to move to a specific position
 * @param int $position Target position
 * @param array<int> $crabs Array of crabs
 * @param bool $incRate True to use incremental fuel cost
 * @return int
 */
function getCost(int $position, array $crabs, bool $incRate = FALSE): int {
	return array_sum(array_map(fn($c) => $incRate ? (abs($position - $c) * (abs($position - $c) + 1) / 2) : abs($position - $c), $crabs));
}

/**
 * @param array<int> $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	return array_reduce(range(min(...$input), max(...$input)), fn($c, $v) => min($c, getCost($v, $input)), INF);
}

/**
 * @param array $input<int> The list of input
 * @return int The result
 */
function part2(array $input): int {
	return array_reduce(range(min(...$input), max(...$input)), fn($c, $v) => min($c, getCost($v, $input, TRUE)), INF);
}

return [test([37, 168]), run(empty($skipRun))];
