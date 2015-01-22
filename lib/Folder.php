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
		$halfScores = [];
		foreach ($this->numbersHistory as $number) {
			$halfScore = Math::numberToHalfScore($number);
			if (!isset($halfScores[$halfScore])) {
				$halfScores[$halfScore] = 1;
			} else if($halfScores[$halfScore] === 1){
				$halfScores[$halfScore]++;
			} else {
				Throw new FolderException('Folder contains same half score more than twice');
			}
		}
	}
}