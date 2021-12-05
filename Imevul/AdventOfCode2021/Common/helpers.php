<?php

/**
 * Get the puzzle input in a format we can handle.
 * @param bool $useTestData True to use input_test.txt (if it exists)
 * @return array<int>
 */
function getInput(bool $useTestData = FALSE): array {
	$filename = $useTestData ? 'input_test.txt' : 'input.txt';

	return explode(PHP_EOL, file_get_contents($filename));
}

/**
 * Create a 2D array with specified dimensions
 * @param int $fromX Start X-index
 * @param int $sizeX X-size
 * @param int|null $fromY Start Y-index (NULL = same as X-index)
 * @param int|null $sizeY Y-Size (NULL = same as X-size)
 * @param mixed $default Default value of each cell
 * @return array
 */
function createMap(int $fromX, int $sizeX, ?int $fromY = NULL, ?int $sizeY = NULL, mixed $default = 0): array {
	$fromY ??= $fromX;
	$sizeY ??= $sizeX;

	return array_fill($fromY, $sizeY, array_fill($fromX, $sizeX, $default));
}

/**
 * Compare two values. If the inputs are arrays, compare each element against each other.
 * @param mixed $v1 First value
 * @param mixed $v2 Second value
 * @return int|array 0 if they are equal. 1 if $v1 > $v2. -1 if $v2 > $v1.
 */
function compare(mixed $v1, mixed $v2): int|array {
	if (is_array($v1) && is_array($v2)) {
		return array_map('compare', $v1, $v2);
	}

	if ($v1 === $v2) return 0;
	return $v1 > $v2 ? 1 : -1;
}

/**
 * Output a timestamped line with values.
 * @param mixed ...$args Values to print (must be auto-convertable to string)
 */
function output(...$args): void {
	echo sprintf('[%s] %s', date('H:i:s'), implode(' ', $args)) . PHP_EOL;
}

/**
 * @param mixed ...$args Values to print
 */
function d(...$args): void {
	echo sprintf('[%s]', date('H:i:s')) . PHP_EOL;
	var_dump(...$args);
}

/**
 * @param mixed ...$args Values to print
 */
function dd(...$args): void {
	var_dump(...$args);
	die;
}
