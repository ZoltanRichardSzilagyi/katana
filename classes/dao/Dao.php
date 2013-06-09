<?php
namespace classes\dao;

use classes\utils\DB;

abstract class Dao{
    		
    /**
	 * @var DB
	 */
    protected $db;
			
	public function __construct(){
		$this->db = new DB();
	}
}
