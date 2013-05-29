<?php
namespace classes\dao;
abstract class Dao{
	
	public function __construct(){
		global $wpdb;
		$this->db = $wpdb;
	}
}
