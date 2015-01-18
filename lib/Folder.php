<?php

namespace Pherserk\Tombola;

use Pherserk\Tombola\Exception\FolderException;
use Pherserk\Tombola\Service\Math;

class Folder
{
	/* @var Row[] */
	protected $rows;

	public function __construct()
	{
		$this->rows = array();
	}

	/**
	 * @param Row $row
	 * @throws FolderException
	 */
	public function addRow(Row $row)
	{
		if (count($this->rows) >= 3) {
			throw new FolderException('Folder is full');
		}
		$this->rows[] = $row;
	}

	/**
	 * @return Row[]
	 */
	public function getRows()
	{
		return $this->rows;
	}

	/**
	 * @return array
	 */
	public function asMatrix()
	{
		$matrix = array();
		foreach ($this->rows as $row) {
			$matrix[] = $row->getCompleteRowArray();
		}
		return $matrix;
	}
}