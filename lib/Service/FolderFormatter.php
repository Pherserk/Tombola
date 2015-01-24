<?php

namespace Pherserk\Tombola\Service;

use Pherserk\Tombola\Folder;
use Pherserk\Tombola\Service\Math;

class FolderFormatter
{
	/**
	 * @param Folder $folder
	 * @return array
	 */
	public static function formatAsArray(Folder $folder)
	{
		$filledRows = self::fillEmptySpaces($folder);

		return $filledRows;
	}

	/**
	 * @param Folder $folder
	 * @return array
	 */
	protected static function fillEmptySpaces(Folder $folder) 
	{
		$formattedFolder = [];
		$rows = $folder->getRows();

		$filledRows = [];
		foreach ($rows as $row) {
			$filledRow = array_fill(0, 9, null);

			$cells = $row->getCells();
			foreach ($cells as $number) {
				$filledRow[Math::numberToHalfScore($number)] = $number;
			}

			$filledRows[] = $filledRow;
		}		

		return $filledRows;
	}

}
