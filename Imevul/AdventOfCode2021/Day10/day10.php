<?php
/*
 * Syntax Scoring
 * https://adventofcode.com/2021/day/10
 */

namespace Imevul\AdventOfCode2021\Day10;

use ParseError;

require_once __DIR__ . '/../../../bootstrap.php';

function getConvertedInput(array $input): array {
	return $input;
}

/**
 * Parse all chunks from a string definition. Return the chunks (in order), and any missing symbols needed to complete any incomplete chunks
 * @param string $def Chunk definition
 * @return array{array, array}
 */
function parseChunks(string $def): array {
	$stack = [];
	$chunks = [];
	$pairs = [
		'(' => ')',
		'[' => ']',
		'{' => '}',
		'<' => '>',
	];

	foreach (str_split($def) as $i => $char) {
		if (in_array($char, array_keys($pairs))) {
			$stack[] = $char;
			$chunks[] = $char;
		} else {
			$expected = $pairs[array_pop($stack)];

			if ($char !== $expected) {
				throw new ParseError(json_encode([$i, $expected, $char]));
			}
		}
	}

	return [$chunks, array_reverse(array_map(fn($c) => $pairs[$c], $stack))];
}

/**
 * @param array<string> $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	$scoring = [
		')' => 3,
		']' => 57,
		'}' => 1197,
		'>' => 25137,
	];

	return array_sum(
		array_map(
			function($v) use ($scoring) {
				try {
					parseChunks($v);
					return 0;
				} catch (ParseError $e) {
					return $scoring[json_decode($e->getMessage())[2]];
				}
			},
			$input
		)
	);
}

/**
 * @param array<string> $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	$scoring = [
		')' => 1,
		']' => 2,
		'}' => 3,
		'>' => 4,
	];

	$lines = array_filter(
		array_map(
			function($v) use ($scoring) {
				try {
					$c = parseChunks($v);
					return [
						...$c,
						array_reduce($c[1], fn($c, $v) => $c * 5 + $scoring[$v], 0)
					];
				} catch (ParseError) { return NULL; }
			},
			$input
		),
		fn($v) => $v !== NULL
	);

	usort($lines, fn($l1, $l2) => compare($l1[2], $l2[2]));

	return $lines[floor(count($lines) / 2)][2];
}

return [test([26397, 288957]), run(empty($skipRun))];
