<?php

namespace Pherserk\Tombola;

use Pherserk\Tombola\Service\Math;
use Pherserk\Tombola\Exception\BucketException;

class HalfScoresHistory
{
	protected $rowsHistory;
	protected $folderHistory;

	public function __construct()
	{
		$this->rowsHistory = [];
		$this->folderHistory = [];
	}

	/**
	 * @param int $number
	 */
	public function add($number)
	{		
		$this->rowsHistory[] = $number;
		$this->folderHistory[] = $number;

		if(count($this->rowsHistory) === 5) {
			$this->rowsHistory = [];
		}

		if(count($this->folderHistory) === 15) {
			$this->folderHistory = [];
		}
	}	

	/**
	 * @return int
	 */
	public function getRowHistory()
	{
		return $this->rowsHistory;
	}

	/**
	 * @return int
	 */
	public function getFolderHistory()
	{
		return $this->folderHistory;
	}
}

