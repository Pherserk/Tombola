<?php

namespace Pherserk\Tombola\Test;

use Pherserk\Tombola\Row;
use Pherserk\Tombola\Folder;

class FolderTest extends \PHPUnit_Framework_TestCase
{	
	/**
	 * @covers Folder::addRow  
	 */
	public function testAddRow()
	{
		$rows = [];
		for ($i=0; $i<3; $i++) {
			$row = new Row();
			for ($k = 0; $k<5; $k++) {
				$row->addNumber(($k + 1) * 11);
			}
			$rows[] = $row;
		}

		$folder = new Folder();
		foreach ($rows as $row) {
			$folder->addRow($row);
		}
	}
	
	/**
	 * @expectedException \Pherserk\Tombola\Exception\FolderException
	 * @covers Folder::addRow
	 */
	public function testLimitOverflowThrowsException()
	{
		$rows = [];
		for ($i=0; $i<4; $i++) {
			$row = new Row();
			for ($k = 0; $k<5; $k++) {
				$row->addNumber(($k+1) * 11);
			}
			$rows[] = $row;
		}

		$folder = new Folder();
		foreach ($rows as $row) {
			$folder->addRow($row);
		}
	}
}