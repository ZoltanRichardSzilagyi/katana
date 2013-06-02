<?php
namespace classes\dao;
abstract class Dao{
    
    protected $db;
			
	public function __construct(){
		global $wpdb;
		$this->db = $wpdb;
	}
}
