<?php
/*
 * Smoke Basin
 * https://adventofcode.com/2021/day/9
 */

namespace Imevul\AdventOfCode2021\Day9;

require_once __DIR__ . '/../../../bootstrap.php';

function getConvertedInput(array $input): array {
	return array_map(fn($i) => array_map('intval', $i), array_map('str_split', $input));
}

/**
 * Find all low points
 * @param array $input
 * @return array
 */
function findLowPoints(array $input): array {
	$maxY = count($input);
	$maxX = count($input[0]);

	$points = [];
	for ($y = 0; $y < $maxY; $y++) {
		for ($x = 0; $x < $maxX; $x++) {
			if (
				$input[$y][$x] < ($input[$y][$x - 1] ?? INF) &&
				$input[$y][$x] < ($input[$y][$x + 1] ?? INF) &&
				$input[$y][$x] < ($input[$y - 1][$x] ?? INF) &&
				$input[$y][$x] < ($input[$y + 1][$x] ?? INF)
			) {
				$points[] = [[$x, $y], $input[$y][$x]];
			}
		}
	}

	return $points;
}

/**
 * Find all low points and the points belonging to the same basin
 * @param array $input
 * @return array
 */
function findBasins(array $input): array {
	$lowPoints = findLowPoints($input);

	foreach ($lowPoints as &$lowPoint) {
		$lowPoint[2] = findBasin($input, [$lowPoint[0]]);
	}

	return $lowPoints;
}

/**
 * Find the basin for a specific low point
 * @param array $input
 * @param array $points Starting points to check
 * @return array
 */
function findBasin(array $input, array $points = []): array {
	$checked = [];

	while (count($points) > 0) {
		$newPoints = [];
		foreach ($points as [$x, $y]) {
			$candidates = [
				[$x - 1, $y],
				[$x + 1, $y],
				[$x, $y - 1],
				[$x, $y + 1],
			];

			foreach ($candidates as [$x2, $y2]) {
				if (($input[$y2][$x2] ?? INF) < 9) {
					if (!in_array([$x2, $y2], $points) && !in_array([$x2, $y2], $checked) && !in_array([$x2, $y2], $newPoints)) {
						$newPoints[] = [$x2, $y2];
					}
				}
			}
		}

		$checked = array_merge($checked, $points);
		$points = $newPoints;
	}

	return $checked;
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	return array_sum(array_map(fn($p) => $p[1] + 1, findLowPoints($input)));
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	$basins = findBasins($input);

	usort($basins, fn($p1, $p2) => count($p1[2]) === count($p2[2]) ? 0 : (count($p1[2]) > count($p2[2]) ? -1 : 1));

	return count($basins[0][2]) * count($basins[1][2]) * count($basins[2][2]);
}

return [test([15, 1134]), run(empty($skipRun))];
