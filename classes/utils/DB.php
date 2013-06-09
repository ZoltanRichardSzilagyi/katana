<?php
namespace \classes\utils;

class DB{
	
	private $db;
	
	public function __construct(){
		global $wpdb;
		$this->db = $wpdb;	
	}
	
	public function get_row($query){
		return $this->db->get_row($query, ARRAY_A);
		// TODO check last error
	}
	
	public function escape_by_ref(&$item){
		$this->db->escape_by_ref($item);
	}
	
	
	
}
