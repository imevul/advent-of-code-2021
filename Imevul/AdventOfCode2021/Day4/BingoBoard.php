<?php

namespace Imevul\AdventOfCode2021\Day4;

use Console_Color2;
use Console_Table;

class BingoBoard {

	public int $index;

	/** @var array<int> */
	public array $data;

	/** @var array<bool> */
	public array $marked = [];

	public int $numRows;
	public int $numColumns;

	protected bool $complete = FALSE;

	public function __construct(int $index, array $data) {
		$this->index = $index;
		$this->data = $data;
		$this->numRows = count($data);
		$this->numColumns = count($data[0]);
		$this->marked = array_fill(0, $this->numRows, array_fill(0, $this->numColumns, false));
	}

	public function markNumber(int $number): void {
		foreach ($this->data as $y => $row) {
			foreach ($row as $x => $value) {
				if ($value == $number) {
					$this->marked[$y][$x] = TRUE;
				}
			}
		}
	}

	public function isMarked(int $x, int $y): bool {
		return $this->marked[$y][$x] ?? FALSE;
	}

	public function isComplete(): bool {
		return $this->complete = $this->complete || (
			in_array($this->numColumns, array_map('array_sum', array_map(null, ...array_values($this->marked))))
			|| in_array($this->numRows, array_map('array_sum', $this->marked))
		);
	}

	public function getUnmarkedSum(): int {
		return array_sum(array_map(fn($r, $r2) => array_sum(array_map(fn($v, $v2) => $v2 ? 0 : $v, $r, $r2)), $this->data, $this->marked));
	}

	public function __toString(): string {
		$color = new Console_Color2();
		$table = new Console_Table(color: TRUE);
		$table->addData(array_map(fn($r, $r2) => array_map(fn($v, $v2) => $v2 ? $color->convert("%2 $v %n") : $v, $r, $r2), $this->data, $this->marked));

		return sprintf("Table %s (%s)\n%s", $this->index, $this->isComplete(), $table->getTable());
	}

}
