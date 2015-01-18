<?php

namespace Pherserk\Tombola\Test;

use Pherserk\Tombola\Service\Math;

class MathTest extends \PHPUnit_Framework_TestCase
{
	public function testNumberToHalfScore()
	{
		$this->assertEquals(0, Math::numberToHalfScore(9));
		$this->assertEquals(1, Math::numberToHalfScore(13));
		$this->assertEquals(3, Math::numberToHalfScore(33));
		$this->assertEquals(8, Math::numberToHalfScore(90));
	} 
}