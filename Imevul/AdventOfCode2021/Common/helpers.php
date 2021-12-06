<?php

if (!defined('BASE_PATH')) {
	define('BASE_PATH', realpath(__DIR__ . '/../../..'));
}

/**
 * Get the puzzle input in a format we can handle.
 * @param bool $useTestData True to use input_test.txt (if it exists)
 * @return array<int>
 */
function getInput(?string $dir = NULL, bool $useTestData = FALSE): array {
	$filename = $useTestData ? 'input_test.txt' : 'input.txt';
	$dir = !empty($dir) ? "$dir\\"  : '';

	return explode(PHP_EOL, file_get_contents(realpath($dir . $filename)));
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

/**
 * Asserts that two values are equal.
 * @param mixed $v1 First value
 * @param mixed $v2 Second value
 * @param string|null $name Optional name of assertion
 * @return bool
 */
function assertEquals(mixed $v1, mixed $v2, ?string $name = NULL): bool {
	if (is_array($v1) && is_array($v2)) {
		$i = 1;
		return array_reduce(
			array_map(
				function($w1, $w2) use ($name, &$i) {
					return assertEquals($w1, $w2, $name . ($i++));
				}, $v1, $v2
			),
			fn($c, $v) => $c && $v,
			TRUE
		);
	}

	return assert($v1 === $v2, sprintf('%s: Failed to assert that %s === %s', $name, $v1, $v2));
}

function runParts(bool $useTestData = FALSE): array {
	$key = array_search(__FUNCTION__, array_column(debug_backtrace(), 'function')) + 1;
	$file = realpath(debug_backtrace()[$key]['file']);
	$dir = dirname($file);
	$namespace = str_replace(BASE_PATH, '', $dir);
	$isMain = realpath(getcwd()) == $dir;
	$getConvertedInput = $namespace . '\\getConvertedInput';
	$part1 = $namespace . '\\part1';
	$part2 = $namespace . '\\part2';
	$input = $getConvertedInput(getInput($dir, $useTestData));
	return [[$part1($input), $part2($input)], $isMain];
}

/**
 * Assert that using test data for part1 and part2 in the caller namespace matches the expected result
 * @param array $expected Expected data
 * @return bool
 */
function test(array $expected): bool {
	[$parts] = runParts(TRUE);

	return assertEquals($parts, $expected, 'Part');
}

/**
 * Run part1 and part2 in the caller namespace and return the result
 * @return array
 */
function run(): array {
	[$parts, $output] = runParts();

	if ($output) {
		output('Part1', $parts[0]);
		output('Part2', $parts[1]);
	}

	return $parts;
}
