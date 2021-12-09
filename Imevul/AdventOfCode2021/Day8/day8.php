<?php
/*
 * Seven Segment Search
 * https://adventofcode.com/2021/day/8
 */

namespace Imevul\AdventOfCode2021\Day8;

use MathPHP\SetTheory\Set;

require_once __DIR__ . '/../../../bootstrap.php';

function getConvertedInput(array $input): array {
	return array_map(
		fn($p) => [
			array_map(fn($s) => new Set(str_split($s)), explode(' ', $p[0])),
			array_map(fn($s) => new Set(str_split($s)), explode(' ', $p[1]))
		],
		array_map(
			fn($i) => explode(' | ', $i),
			$input)
	);
}

/**
 * Find which digit it is, based on a pattern and previously registered patterns
 * @param Set $pattern Pattern to figure out
 * @param array $digits Previously figured out patterns
 * @return int
 */
function findDigit(Set $pattern, array $digits): int {
	$stats = fn(Set $p, Set $d) => [$p->intersect($d)->count(), $p->difference($d)->count()];
	$digit = [
		2 => 1,
		3 => 7,
		4 => 4,
		5 => fn() => array_key_first(array_filter([
			2 => $stats($pattern, $digits[4]) == [2, 3],
			3 => $stats($pattern, $digits[1]) == [2, 3],
			5 => $stats($pattern, $digits[4]) == [3, 2],
		], fn($v) => $v)),
		6 =>  fn() => array_key_first(array_filter([
			6 => $stats($pattern, $digits[1]) == [1, 5],
			9 => $stats($pattern, $digits[4]) == [4, 2],
			0 => $stats($pattern, $digits[1]) == [2, 4],
		], fn($v) => $v)),
		7 => 8,
	][$pattern->count()];

	return is_callable($digit) ? $digit() : $digit;
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	return array_sum(array_map(fn($i) => count(array_filter($i[1], fn($o) => in_array($o->count(), [1 => 2, 4 => 4, 7 => 3, 8 => 7]))), $input));
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	$result = 0;

	foreach ($input as [$patterns, $outputs]) {
		usort($patterns, fn(Set $p1, Set $p2) => compare($p1->length(), $p2->length()));
		$digits = array_reduce($patterns, fn($c, $p) => $c + [findDigit($p, $c) => $p], []);

		$result += array_reduce(
			array_map(fn($o) => array_search($o, $digits), $outputs),
			fn($c, $d) => $c * 10 + $d
		);
	}

	return $result;
}

return [test([26, 61229]), run(empty($skipRun))];
