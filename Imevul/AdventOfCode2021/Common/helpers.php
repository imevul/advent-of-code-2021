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
