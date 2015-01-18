<?php

namespace Pherserk\Tombola;

use Pherserk\Tombola\Service\Math;
use Pherserk\Tombola\Exception\RowException;

class Row
{
	/* @var array */
	protected $cells;

	/* @var array */
	protected $halfScores;

	public function __construct()
	{
		$this->cells = [];
		$this->halfScores = [];
	}

	public function addNumber($number)
	{
		$numberHalfScore = Math::numberToHalfScore($number);

		if (in_array($numberHalfScore, $this->halfScores)) {
			throw new RowException('Cannot add two numbers from the same halfscore');
		}

		if (in_array($number, $this->cells)) {
			throw new RowException('Cannot add the same value twice');
		}

		if ($number <= 0 || $number > 90) {
			throw new RowException('Out of range value');
		}

		if (count($this->cells) >= 5) {
			throw new RowException('Row is full');
		}

		$this->cells[] = $number;
		$this->halfScores[] = $numberHalfScore;
	}

	public function getCells()
	{
		asort($this->cells);

		return $this->cells;
	}

	/**
	 * @return array
	 */
	public function getCompleteRowArray()
	{
		$completeRow = array_fill(0, 9, 0);
		foreach ($this->cells as $cell) {
			$index = Math::numberToHalfScore($cell);
			$completeRow[$index] = $cell;
		}

		return $completeRow;
	}
}