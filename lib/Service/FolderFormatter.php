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

		$orderedRows = self::orderColumns($filledRows);

		$hash = '';
		foreach ($orderedRows as $orderedRow) {
			$hash .= md5(implode(',', $orderedRow));
		}
		$hash = md5($hash);

		return ['hash' => $hash, 'rows' => $orderedRows];
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

	protected static function orderColumns($rows)
	{
		$orderedRows = [];

		$columns = [];
		for ($i = 0; $i < 9; $i++) {
			$columns[] = [
				$rows[0][$i],
				$rows[1][$i],
				$rows[2][$i],
			];
		}

		foreach ($columns as $key => $column) {
			$nonEmptyCells = array_diff($column, [null]);

			if (count($nonEmptyCells) > 1) {
				$max = max($nonEmptyCells);
				$min = min($nonEmptyCells);

				$maxPosition = array_search($max, $column);
				$minPosition = array_search($min, $column);

				if ($maxPosition < $minPosition) {
					$columns[$key][$maxPosition] = $min;
					$columns[$key][$minPosition] = $max;
				}				
			}
		}

		for ($i = 0; $i < 3; $i++) {
			$orderedRows[] = [
				$columns[0][$i], $columns[1][$i], $columns[2][$i], 
				$columns[3][$i], $columns[4][$i], $columns[5][$i], 
				$columns[6][$i], $columns[7][$i], $columns[8][$i]
			];
		}

		return $orderedRows;
	}

}
