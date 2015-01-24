<?php

namespace Pherserk\Tombola\Service;

use Pherserk\Tombola\Bucket;
use Pherserk\Tombola\Row;
use Pherserk\Tombola\Folder;


class FolderSet
{
	/**
	 * @return array[Row]
	 */
	public static function generate()
	{
		$bucket = new Bucket();

		$rows = [];
		for ($k=0; $k<18; $k++) {
			$row = new Row();
			for ($i=0;$i<5;$i++) {
				$number = $bucket->extractNumber();
				$row->addNumber($number);
			
			}
			$rows[] = $row;
		}	

		$folders = [];
		for($i=0; $i<6; $i++) {

			$folder = new Folder();
			$folder
				->addRow(array_pop($rows))
				->addRow(array_pop($rows))
				->addRow(array_pop($rows));
						
			$folders[] = $folder;
		}		

		return $folders;	
	}
}
