<?php

namespace Pherserk\Tombola\Test;

use Pherserk\Tombola\Row;
use Pherserk\Tombola\Exception\RowException;

class RowTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers Row::addNumber
	 */
	public function testAddNumber()
	{
		$row = new Row();
		for ($i=0; $i<5; $i++) {
			$row->addNumber(($i +1) * 11);
		}
	}

	/**
	 * @expectedException \Pherserk\Tombola\Exception\RowException
	 * @covers Row::addNumber
	 */
	public function testAddingameNumberTwiceThrowsException()
	{
		$row = new Row();
		$row->addNumber(3);
		$row->addNumber(3);
	}

	/**
	 * @expectedException \Pherserk\Tombola\Exception\RowException
	 * @covers Row::addNumber
	 */
	public function testAddingameTwoNumbersFromSameHalfScoreThrowsException()
	{
		$row = new Row();
		$row->addNumber(30);
		$row->addNumber(31);
	}

	/**
	 * @expectedException \Pherserk\Tombola\Exception\RowException
	 * @cover Row::addNumber
	 */
	public function testNumberLimitOverflowThrowsException()
	{
		$row = new Row();
		for ($i=0; $i<6; $i++) {
			$row->addNumber($i + 1);
		}
	} 

	/**
	 * @expectedException \Pherserk\Tombola\Exception\RowException
	 * @cover Row::addNumber
	 */
	public function testOutOfRangeNumberThrowsException()
	{
		$row = new Row();
		$row->addNumber(0);
	}
}