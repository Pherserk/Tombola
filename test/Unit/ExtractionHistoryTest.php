<?php

namespace Pherserk\Tombola\Test;

use Pherserk\Tombola\ExtractionHistory;

class ExtractionHistoryTest extends \PHPUnit_Framework_TestCase
{	

	/**
	 * @covers ExtractionHistory::addNumber  
 	 */
	public function testAdd()
	{
		$extractionHistory = new ExtractionHistory();
		$extractionHistory->add(4);

		$this->assertEquals(4, $extractionHistory->getRowHistory()[0]);
	}
}