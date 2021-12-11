<?php
/*
 * Dumbo Octopus
 * https://adventofcode.com/2021/day/11
 */

namespace Imevul\AdventOfCode2021\Day11;

require_once __DIR__ . '/../../../bootstrap.php';

function getConvertedInput(array $input): array {
	return array_map(fn($r) => array_map('intval', str_split($r)), $input);
}

/**
 * Simulate one step of the octopuses
 * @param array<int, int> $map Map of energy levels
 * @return int Number of flashes this step
 */
function simulate(array &$map): int {
	array_walk_recursive($map, fn(&$v) => $v++);

	$flashes = 0;
	$queue = [];

	foreach ($map as $y => $row) {
		foreach ($row as $x => $value) {
			if ($value > 9) {
				$flashes++;
				$queue[] = [$x, $y];
			}
		}
	}

	while (!empty($queue)) {
		[$x, $y] = array_shift($queue);
		foreach (range($y - 1, $y + 1) as $y2) {
			foreach (range($x - 1, $x + 1) as $x2) {
				if ([$x, $y] !== [$x2, $y2] && isset($map[$y2][$x2])) {
					$map[$y2][$x2]++;

					if ($map[$y2][$x2] === 10) {
						$flashes++;
						$queue[] = [$x2, $y2];
					}
				}
			}
		}
	}

	array_walk_recursive($map, fn(&$v) => $v = $v > 9 ? 0 : $v);

	return $flashes;
}

/**
 * @param array<int, int> $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	$result = 0;

	for ($i = 1; $i <= 100; $i++) {
		$result += simulate($input);
	}

	return $result;
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	for ($i = 1; $i <= 1000; $i++) {
		if (simulate($input) === 100) {
			return $i;
		}
	}

	return 0;
}

return [test([1656, 195]), run(empty($skipRun))];
