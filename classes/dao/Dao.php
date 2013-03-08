<?php
abstract class Dao{
		
	/**
	 * @var wpdb
	 */
	protected $db;
	
	public final function setDb($db){
		$this->db = $db;
	}
	
}
