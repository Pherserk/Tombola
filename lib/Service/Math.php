<?php

namespace Pherserk\Tombola\Service;

class Math
{
	/**
	 * @param int $number
	 * @return int
	 */
	public static function numberToHalfScore($number)
	{
		if ($number < 10) {
			return 0;
		}

		if ($number === 90) {
			return 8;
		}

		return intval(floor($number/10));
	}

	public static function findDoubles($array)
	{
		return self::findRepetitions(2, $array);
	}

	public static function findTriples($array)
	{
		return self::findRepetitions(3, $array);
	}

	protected static function findRepetitions($times, $array) {

		$values = array_unique($array);

		$counts = [];
		foreach($values as $value) {
			$counts[] = ['value' => $value, 'count' => 0];
		}

		foreach ($array as $value) {
			foreach ($counts as $key => $count) {
				if ($count['value'] === $value) {
					$counts[$key]['count']++;
				}
			}
		}

		$repetitions = [];
		foreach ($counts as $count) {
			if ($count['count'] === $times) {
				$repetitions[] = $count['value'];
			}
		}
	
		return $repetitions;
	}
}