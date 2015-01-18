<?php

namespace Pherserk\Tombola;

use Pherserk\Tombola\Service\Math;
use Pherserk\Tombola\Exception\BucketException;

class Bucket
{
	protected $halfScores;
	protected $history;

	public function __construct()
	{
		$numbers = range(1, 90);
		shuffle($numbers);

		foreach ($numbers as $number) {
			$index = Math::numberToHalfScore($number);
			$this->halfScores[$index][] = $number;
		}

		//Halfscores order matter (do not shuffle!)

		$this->history = [];
	}

	public function extractNumber()
	{
		$halfScoreIndex = $this->getNextHalfScoreIndex();
	
		$number = array_pop($this->halfScores[$halfScoreIndex]);
		$this->history[] = $number;

		if(count($this->history) === 5) {
			$this->history = [];
		}
		

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
		$used = [];
		foreach ($this->history as $number) {
			$used[] = Math::numberToHalfScore($number);
		}

		$consumed = [];
		foreach ($this->halfScores as $index => $halfScore) {
			if (count($halfScore) === 0) {
				$consumed[] = $index;
			}
		}

		return array_merge($consumed, $used);
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
}

