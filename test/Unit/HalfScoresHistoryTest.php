<?php

namespace Pherserk\Tombola\Test;

use Pherserk\Tombola\HalfScoresHistory;

class HalfScoresHistoryTest extends \PHPUnit_Framework_TestCase
{	

	/**
	 * @covers ExtractionHistory::addNumber  
 	 */
	public function testAdd()
	{
		$extractionHistory = new HalfScoresHistory();
		$extractionHistory->add(4);

		$this->assertEquals(4, $extractionHistory->getRowHistory()[0]);
	}
}