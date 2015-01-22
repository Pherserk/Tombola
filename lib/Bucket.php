<?php

namespace Pherserk\Tombola;

use Pherserk\Tombola\Service\Math;
use Pherserk\Tombola\Exception\BucketException;

class Bucket
{
	protected $halfScores;
	protected $rowsHistory;
	protected $folderHistory;

	public function __construct()
	{
		$numbers = range(1, 90);
		shuffle($numbers);

		foreach ($numbers as $number) {
			$index = Math::numberToHalfScore($number);
			$this->halfScores[$index][] = $number;
		}

		$this->rowsHistory = [];
		$this->folderHistory = [];
	}

	/**
	 * @return int
	 */
	public function extractNumber()
	{
		$halfScoreIndex = $this->getNextHalfScoreIndex();
	
		$number = array_pop($this->halfScores[$halfScoreIndex]);
		
		$this->updateHistories($number);	

		return $number;
	}

	protected function getNextHalfScoreIndex()
	{
		$unavailables = $this->getUnaivalableHalfScoreIndexes();

		$all = array_keys($this->halfScores);

		$availables = array_diff($all, $unavailables); 

		return $this->getBestChoiceFromAivalables($availables);		
	}

	protected function getUnaivalableHalfScoreIndexes()
	{
		$usedInRow = [];
		foreach ($this->rowsHistory as $number) {
			$usedInRow[] = Math::numberToHalfScore($number);
		}

		//TODO it seems that for construction the first check and the
		//best choice strategy make the following control unnecessary
		$usedInFolder = [];
		foreach ($this->folderHistory as $number) {
			$usedInFolder[] = Math::numberToHalfScore($number);
		}
		
		$consumed = [];
		foreach ($this->halfScores as $index => $halfScore) {
			if (count($halfScore) === 0) {
				$consumed[] = $index;
			}
		}

		return array_merge($consumed, $usedInRow);
	}

	protected function getBestChoiceFromAivalables($availables)
	{
		if (count($availables) === 0) {
			throw new BucketException('Number availability exausted');
		}

		$longest = 0;
		$nextHalfScoreIndex = array_rand($availables);
		foreach ($this->halfScores as $index => $halfScore) {
			if (in_array($index, $availables)) {
				if (count($halfScore) > $longest) {
					$longest = count($halfScore);
					$nextHalfScoreIndex = $index;
				}

			}
		}

		return $nextHalfScoreIndex;
	}

	protected function updateHistories($number)
	{
		$this->rowsHistory[] = $number;
		$this->folderHistory[] = $number;

		if(count($this->rowsHistory) === 5) {
			$this->rowsHistory = [];
		}

		if(count($this->folderHistory) === 15) {
			$this->folderHistory = [];
		}
	}
}

