<?php

namespace Pherserk\Tombola\Test;

use Pherserk\Tombola\Bucket;
use Pherserk\Tombola\Row;
use Pherserk\Tombola\Folder;
use Pherserk\Tombola\Exception\BucketException;
use Pherserk\Tombola\Exception\RowException;
use Pherserk\Tombola\Exception\FolderException;

class BucketTest extends \PHPUnit_Framework_TestCase
{	

	/**
	 * @covers Bucket::extractNumber  
 	 */
	public function testExtractNumberEurystic()
	{
		$errors = 0;
		for ($try = 0; $try<100; $try++) {
			try {
				$b = new Bucket();
				for($i = 0; $i<90; $i++) {
					$n = $b->extractNumber();
				}
			} catch (BucketException $e) {
				$errors++;
			}
		}	

		$this->assertEquals(0, $errors);
	}

	/**
	 * @covers Bucket::extractNumber  
 	 */
	public function testFoldersGeneration()
	{	
		$bucket = new Bucket();
		$errors = 0;

		$rows = [];
		for ($k=0; $k<18; $k++) {
			$row = new Row();
			for ($i=0;$i<5;$i++) {
				try {
					$number = $bucket->extractNumber();
					$row->addNumber($number);
				} catch(RowException $e) {
					$errors++;
				}					
			}
			$rows[] = $row;
		}	

		$folders = [];
		for($i=0; $i<6; $i++) {
			$folder = new Folder();
			try {
				$folder->addRow(array_pop($rows));
				$folder->addRow(array_pop($rows));
				$folder->addRow(array_pop($rows));
			} catch(FolderException $e) {
				$errors++;
			}	

			$folders[] = $folder;
		}			

		$this->assertEquals(0, $errors);
	}
}