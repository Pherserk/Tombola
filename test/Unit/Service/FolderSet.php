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
		$folderSet = new FolderSet;

		$error = false;
		try {
			$folderSet->generate();
		} catch (\Exception $e) {
			$error = true;
		}

		$this->assertFalse($error);
	} 
}