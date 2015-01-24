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
}
