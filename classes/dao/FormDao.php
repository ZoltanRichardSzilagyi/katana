<?php
final class FormDao extends Dao{
	
	public function get($id){
		$this->db->escape_by_ref($id);	
		$query = "SELECT name
			FROM wp_ktn_forms WHERE id = {$id}";
		return $this->db->get_row($query, ARRAY_A);
	}
	
}
