<?php

namespace Imevul\AdventOfCode2021\Common;

class Set {

	protected array $values;

	public function __construct(array $data = []) {
		$this->setValues($data);
	}

	protected function update(): void {
		sort($this->values);
	}

	public function getValues(): array {
		return $this->values;
	}

	public function setValues(array $values): void {
		$this->values = array_unique($values);
		$this->update();
	}

	public function add(mixed $value): void {
		$this->values[] = $value;
		$this->values = array_unique($this->values);
		$this->update();
	}

	public function remove(mixed $value): void {
		$this->values = array_diff($this->values, [$value]);
		$this->update();
	}

	public function has(mixed $value): bool {
		return in_array($value, $this->values);
	}

	public function count(): int {
		return count($this->values);
	}

	public function overlap(?Set $set): Set {
		if ($set === NULL) {
			return new Set;
		}

		return new Set(array_intersect($this->values, $set->getValues()));
	}

	public function diff(?Set $set): Set {
		if ($set === NULL) {
			return new Set($this->values);
		}

		return new Set(array_diff($this->values, $set->getValues()));
	}

	public function contains(?Set $set): bool {
		if ($set === NULL) {
			return TRUE;
		}

		return $set->overlap($this)->count() == $set->count();
	}

	public function compareValues(?Set $set): array {
		return [$this->overlap($set)->count(), $this->diff($set)->count()];
	}

	public function equals(?Set $set): bool {
		return $this === $set;
	}

	public function compareTo(?Set $set): int {
		if ($this === $set) return 0;
		if ($this->count() === $set->count()) return 0;
		return $this->count() > $set->count() ? 1 : -1;
	}

	public function __toString(): string {
		return json_encode($this->values);
	}

}
