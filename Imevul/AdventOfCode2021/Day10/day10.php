<?php
/*
 * Syntax Scoring
 * https://adventofcode.com/2021/day/10
 */

namespace Imevul\AdventOfCode2021\Day10;

require_once __DIR__ . '/../../../bootstrap.php';

function getConvertedInput(array $input): array {
	return array_map(fn($i) => str_split($i), $input);
}

/**
 * Parse all chunks from a definition. Return the chunks (in order), and any missing symbols needed to complete any incomplete chunks
 * @param array $def Chunk definition
 * @return array{string, array} [Illegal char, missing closing symbols]
 */
function parseChunks(array $def): array {
	$stack = [];
	$pairs = [ '(' => ')', '[' => ']', '{' => '}', '<' => '>' ];

	foreach ($def as $char) {
		if (in_array($char, array_keys($pairs))) {
			$stack[] = $char;
		} else {
			if ($char !== $pairs[array_pop($stack)]) {
				return [$char, []];
			}
		}
	}

	return [NULL, array_map(fn($c) => $pairs[$c], array_reverse($stack))];
}

/**
 * @param array<array> $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	$scoring = [ ')' => 3, ']' => 57, '}' => 1197, '>' => 25137 ];

	return array_sum(array_map(fn($v) => $scoring[parseChunks($v)[0]] ?? 0, $input));
}

/**
 * @param array<array> $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	$scoring = [ ')' => 1, ']' => 2, '}' => 3, '>' => 4 ];

	$lines = array_filter(array_map(fn($v) => array_reduce(parseChunks($v)[1], fn($c, $v) => $c * 5 + $scoring[$v], 0), $input), fn($v) => $v !== 0);
	sort($lines);

	return $lines[floor(count($lines) / 2)];
}

return [test([26397, 288957]), run(empty($skipRun))];
