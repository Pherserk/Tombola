<?php

namespace Pherserk\Tombola\Test;

use Pherserk\Tombola\Service\Math;

class MathTest extends \PHPUnit_Framework_TestCase
{
	public function testNumberToHalfScore()
	{
		$this->assertEquals(0, Math::numberToHalfScore(9));
		$this->assertEquals(2, Math::numberToHalfScore(20));
		$this->assertEquals(3, Math::numberToHalfScore(39));
		$this->assertEquals(8, Math::numberToHalfScore(90));
	} 

	public function testFindDoubles()
	{
		$array = [1, 2, 3, 2, 1];
		$doubles = Math::findDoubles($array);

		$this->assertContains(2, $doubles);
		$this->assertContains(1, $doubles);
	}

	public function testFindTriples()
	{
		$array = [1, 1, 1, 2, 2, 3 , 3, 2];
		$triples = Math::findTriples($array);

		$this->assertContains(2, $triples);
		$this->assertCount(2, $triples);
	}
}