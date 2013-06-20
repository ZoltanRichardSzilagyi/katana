<?php
namespace classes\utils;

class DB{
	    
	/**
     * @var wpdb
     */
	private $db;
	
	public function __construct(){
		global $wpdb;
		$this->db = $wpdb;	
	}
	
	/**
     * Retrieve an entire SQL result set from the database (i.e., many rows)
     * Executes a SQL query and returns the entire SQL result.
     */
	public function getList($query){
		$result = $this->db->get_results($query, ARRAY_A);
        $this->checkErrors();
        return $result;
	}
    
    /**
     * Retrieve one row from the database.
     */
    public function get($query){
        $result = $this->db->get_row($query, ARRAY_A);   
    }
        
    /**
     * Retrieve one variable from the database.
     */
    public function getValue($query){
        $value = $this->db->get_var($query);
        $this->checkErrors();
        return $value;
    }
    
    /**
     *  Prepares a SQL query for safe execution. Uses sprintf()-like syntax.
     */
    public function prepare($query, $args){
        return $this->db->prepare($query, $args);
    }    
	
	public function escape(&$item){
		$this->db->escape_by_ref($item);
	}
    
    private function checkErrors(){
        if(!empty($this->db->last_error)){
            throw new Exception($this->db->last_error, 1);            
        }        
    }
    
    public function getLastError(){
        return $this->db->last_error;
    }
	
	
	
}
