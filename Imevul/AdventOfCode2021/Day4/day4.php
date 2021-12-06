<?php
/*
 * Giant Squid
 * https://adventofcode.com/2021/day/4
 */

namespace Imevul\AdventOfCode2021\Day4;

require_once __DIR__ . '/../../../bootstrap.php';

function getConvertedInput(array $input): array {
	$numbers = array_map('intval', explode(',', array_shift($input)));

	$i = 0;
	$boards = array_map(
		fn($b) => new BingoBoard($i++, $b),
		array_chunk(
			array_map(
				fn($r) => array_map('intval', preg_split('/\s+/', $r, flags: PREG_SPLIT_NO_EMPTY)),
				array_filter($input, fn($r) => !empty($r)))
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

return [test([4512, 1924]), run()];
