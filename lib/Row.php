<?php

namespace Pherserk\Tombola;

use Pherserk\Tombola\Service\Math;
use Pherserk\Tombola\Exception\RowException;

class Row
{
	/* @var array[int] */
	protected $cells;

	/* @var array[int] */
	protected $halfScores;

	public function __construct()
	{
		$this->cells = [];
		$this->halfScores = [];

		for ($i=0; $i<5; $i++) {
			$this->cells[] = null;
		}	
	}

	/**
	 * @param int $number
	 */
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

		$added = false;
		foreach ($this->cells as $index => $cellTofill) {
			if (is_null($cellTofill)) {
				$this->cells[$index] = $number;
				$this->halfScores[] = $numberHalfScore;
				$added = true;

				break;
			}
		}

		if (!$added) {
			throw new RowException('Row is full');
		}
	}

	/**
	 * @return array[int]
	 */
	public function getCells()
	{
		asort($this->cells);

		return $this->cells;
	}
}