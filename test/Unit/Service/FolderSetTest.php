<?php

namespace Pherserk\Tombola\Test;

use Pherserk\Tombola\Service\FolderSet;

class FolderSetTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers FolderSet::generate
	 */
	public function testGenerate()
	{
		$folderSet = new FolderSet();

		$error = false;
		try {
			$folderset = $folderSet->generate();			
		} catch (\Exception $e) {
			$error = true;
			echo $e->getMessage();
		}

		$this->assertCount(6, $folderset);
		$this->assertFalse($error);
	} 
}
