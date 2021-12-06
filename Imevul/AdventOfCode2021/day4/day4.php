<?php
/*
 * Giant Squid
 * https://adventofcode.com/2021/day/4
 */

namespace Imevul\AdventOfCode2021\Day4;

require_once '../../../bootstrap.php';

/**
 * @param bool $useTestData True to use input_test.txt (if it exists)
 * @return array<int>
 */
function getConvertedInput(bool $useTestData = FALSE): array {
	$data = getInput($useTestData);
	$numbers = array_map(fn($v) => (int)$v, explode(',', array_shift($data)));

	$i = 0;
	$boards = array_map(
		fn($b) => new BingoBoard($i++, $b),
		array_chunk(
			array_map(
				fn($r) => array_map(fn($v) => (int)$v, preg_split('/\s+/', $r, flags: PREG_SPLIT_NO_EMPTY)),
				array_filter($data, fn($r) => !empty($r)))
			, 5
		)
	);

	return [$numbers, $boards];
}

/**
 * @param array{array<int>, array<BingoBoard>} $input The list of input
 * @return int The result
 */
function part1(array $input): int {
	[$numbers, $boards] = $input;

	foreach ($numbers as $number) {
		foreach ($boards as $board) {
			$board->markNumber($number);

			if ($board->isComplete()) {
				return $number * $board->getUnmarkedSum();
			}
		}
	}

	return 0;
}

/**
 * @param array{array<int>, array<BingoBoard>} $input The list of input
 * @return int The result
 */
function part2(array $input): int {
	[$numbers, $boards] = $input;

	/** @var $int $numbers */
	foreach ($numbers as $number) {
		/** @var BingoBoard $board */
		foreach ($boards as $board) {
			$board->markNumber($number);

			if ($board->isComplete()) {
				if (empty(array_filter($boards, fn(BingoBoard $b) => !$b->isComplete()))) {
					return $number * $board->getUnmarkedSum();
				}
			}
		}
	}

	return 0;
}

$input = getConvertedInput(TRUE);
assertEquals([part1($input), part2($input)], [4512, 1924], 'Part');

$input = getConvertedInput();
output('Solution1: ', part1($input));
output('Solution2: ', part2($input));
