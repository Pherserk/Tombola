<?php

namespace Pherserk\Tombola\Test;

use Pherserk\Tombola\Bucket;
use Pherserk\Tombola\Row;
use Pherserk\Tombola\Exception\BucketException;
use Pherserk\Tombola\Exception\RowException;

class BucketTest extends \PHPUnit_Framework_TestCase
{	
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

	public function testFoldersGeneration()
	{	
		$bucket = new Bucket();
		$rows = [];
		$errors = 0;

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

		$this->assertEquals(0, $errors);
	}
}