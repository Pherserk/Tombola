<?php

namespace Pherserk\Tombola;

use Pherserk\Tombola\Exception\FolderException;
use Pherserk\Tombola\Service\Math;

class Folder
{
	/* @var array[array[int]] */
	protected $rows;
	protected $halfScoresHistory;

	public function __construct()
	{
		$this->rows = [];

		for ($i=0; $i<3; $i++) {
			$this->rows[] = null;
		}	

		$this->numbersHistory = [];
	}

	/**
	 * @param Row $row
	 */
	public function addRow(Row $row)
	{
		$added = false;
		foreach ($this->rows as $index => $rowToFill) {
			if (is_null($rowToFill)) {
				$this->rows[$index] = $row;
				$added = true;
				break;
			}
		}

		if (!$added) {
			throw new FolderException('Folder is full');
		}

		$this->numbersHistory = array_merge($this->numbersHistory, $row->getCells());
		$this->checkNumbersHistory();

		return $this;
	}

	/**
	 * @return array[Row]
	 */
	public function getRows()
	{
		return $this->rows;
	}

	protected function checkNumbersHistory()
	{
		if (count($this->numbersHistory) !== 15) {
			return;
		}

		$halfScores = [];
		foreach ($this->numbersHistory as $number) {
			$halfScores[] = Math::numberToHalfScore($number);
		}

		$triples = Math::findTriples($halfScores);

		if (count($triples) > 0) {
			throw new FolderException('Folder can\'t contain same halfscore more than twice');
		}
	}
}