<?php

namespace Pherserk\Tombola\Service;

class Math
{
	public static function numberToHalfScore($number)
	{
		if ($number < 10) {
			return 0;
		}

		if ($number === 90) {
			return 8;
		}

		return floor($number/10);
	}
}