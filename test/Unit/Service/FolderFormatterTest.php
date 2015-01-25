<?php

namespace Pherserk\Tombola\Test;

use Pherserk\Tombola\Service\FolderFormatter;

class FolderFormatterTest extends \PHPUnit_Framework_TestCase
{
	public function testFormatAsArrayReturnsNullFilledRowsAndOrderedColumns()
	{
		$folder = $this->buildMockedFolder();
		
		$formattedFolder = FolderFormatter::formatAsArray($folder);

		$firstFormattedFolderRow = $formattedFolder['rows'][0];

		$expectedFormattedFolderRow = [1, null, null, 30, 40, null, 60, null, 80];

		$this->assertArrayEquals($expectedFormattedFolderRow, $firstFormattedFolderRow);
	}

	protected function buildMockedFolder()
	{
		$row = $this->getMockBuilder('Pherserk\Tombola\Row')
			->getMock();
		$row->expects($this->once())
			->method('getCells')
			->will($this->returnValue([2,30,41,60,81]));

		$row2 = $this->getMockBuilder('Pherserk\Tombola\Row')
			->getMock();
		$row2->expects($this->once())
			->method('getCells')		
			->will($this->returnValue([1,20,50,70,80]));

		$row3 = $this->getMockBuilder('Pherserk\Tombola\Row')
			->getMock();
		$row3->expects($this->once())
			->method('getCells')		
			->will($this->returnValue([31,40,51,71,62]));

		$rows = [$row, $row2, $row3];

		$folder = $this->getMockBuilder('Pherserk\Tombola\Folder')
			->getMock();
		$folder->expects($this->once())
			->method('getRows')
			->will($this->returnValue($rows));

		return $folder;
	}

	protected function assertArrayEquals($expected, $current)
	{
		$equals = true;

		foreach ($expected as $key => $value) {
			if  ($value != $current[$key]) {
				$equals = false;
			}
		}

		$this->assertTrue($equals);
	}
}