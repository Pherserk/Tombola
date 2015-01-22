<?php

namespace Pherserk\Tombola\Test;

use Pherserk\Tombola\Row;
use Pherserk\Tombola\Folder;
use Pherserk\Tombola\Exception\FolderException;

class FolderTest extends \PHPUnit_Framework_TestCase
{	
	/**
	 * @covers Folder::addRow  
 	 */
	public function testAddRow()
	{
		$folderNumbers = [
			[1,10,20,30,40],
			[2,11,22,33,77],
			[42,50,60,70,80],
		];

		$rows = [];
		foreach ($folderNumbers as $rowNumber) {
			$row = new Row();
			foreach ($rowNumber as $number) {
				$row->addNumber($number);
			}
			$rows[] = $row;
		}

		$folder = new Folder();
		foreach ($rows as $row) {
			$folder->addRow($row);
		}
	}
	
	/**
     * @expectedException Pherserk\Tombola\Exception\FolderException
     * @covers Folder::addRow  
     */
	public function testLimitOverflowThrowsException()
	{
		$folderNumbers = [
			[1,10,20,30,40],
			[2,11,22,33,77],
			[42,50,60,70,80],
			[10,20,30,40,50],
		];

		$rows = [];
		foreach ($folderNumbers as $rowNumber) {
			$row = new Row();
			foreach ($rowNumber as $number) {
				$row->addNumber($number);
			}
			$rows[] = $row;
		}

		$folder = new Folder();
		foreach ($rows as $row) {
			$folder->addRow($row);
		}
	}

	/**
     * @expectedException Pherserk\Tombola\Exception\FolderException
     * @covers Folder::addRow  
     */
	public function testCantAddNumbersFromSameHalfScoreThreeTimes()
	{
		$folderNumbers = [
			[1,10,20,30,76],
			[2,11,22,33,77],
			[3,12,23,34,78],
		];

		$rows = [];
		foreach ($folderNumbers as $rowNumber) {
			$row = new Row();
			foreach ($rowNumber as $number) {
				$row->addNumber($number);
			}
			$rows[] = $row;
		}

		$folder = new Folder();
		foreach ($rows as $row) {
			$folder->addRow($row);
		}
	}
}