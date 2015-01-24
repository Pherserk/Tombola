<?php

namespace Pherserk\Tombola;

use Pherserk\Tombola\Exception\BucketException;
use Pherserk\Tombola\ExtractionHistory;
use Pherserk\Tombola\Service\Math;

class Bucket
{
	protected $halfScores;
	protected $extractionHistory;

	public function __construct()
	{
		$numbers = range(1, 90);
		shuffle($numbers);

		foreach ($numbers as $number) {
			$index = Math::numberToHalfScore($number);
			$this->halfScores[$index][] = $number;
		}
		
		$this->extractionHistory = new ExtractionHistory();		
	}

	/**
	 * @return int
	 */
	public function extractNumber()
	{
		$halfScoreIndex = $this->getNextHalfScoreIndex();
	
		$number = array_pop($this->halfScores[$halfScoreIndex]);
		
		$this->extractionHistory->add($number);	

		return $number;
	}

	protected function getNextHalfScoreIndex()
	{
		$unavailables = $this->getUnaivalableHalfScoreIndexes();

		$all = array_keys($this->halfScores);

		$availables = array_diff($all, $unavailables); 

		if (count($availables) === 0) {
			throw new BucketException('Number availability exausted');
		}

		return $this->getBestChoiceFromAivalables($availables);		
	}

	protected function getUnaivalableHalfScoreIndexes()
	{
		$usedInRow = [];
		foreach ($this->extractionHistory->getRowHistory() as $number) {
			$usedInRow[] = Math::numberToHalfScore($number);
		}

		$usedInFolder = [];
		foreach ($this->extractionHistory->getFolderHistory() as $number) {
			$usedInFolder[] = Math::numberToHalfScore($number);
		}

		$usedTwiceInFolder = Math::findDoubles($usedInFolder);

		$consumed = [];
		foreach ($this->halfScores as $index => $halfScore) {
			if (count($halfScore) === 0) {
				$consumed[] = $index;
			}
		}

		return array_merge($consumed, $usedInRow, $usedTwiceInFolder);
	}

	protected function getBestChoiceFromAivalables($availables)
	{		
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
}
