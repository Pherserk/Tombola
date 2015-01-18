<?php

namespace Pherserk\Tombola;

use Pherserk\Tombola\Exception\FolderException;

class Folder
{
	/* @var array[array[int]] */
	protected $rows;

	public function __construct()
	{
		$this->rows = [];

		for ($i=0; $i<3; $i++) {
			$this->rows[] = null;
		}	
	}

	/**
	 * @param Row $row
	 */
	public function addRow(Row $row)
	{
		$added = false;
		foreach ($this->rows as $index => $rowToFill) {
			if (is_null($rowToFill)) {
				$this->rows[$index] = $row;
				$added = true;
				break;
			}
		}

		if (!$added) {
			throw new FolderException('Folder is full');
		}
	}

	/**
	 * @return array[Row]
	 */
	public function getRows()
	{
		return $this->rows;
	}
}