<?php
namespace classes\dao;

use classes\dao\Dao;

use classes\entity\form\Form;
use classes\entity\form\FormElement;

final class FormDao extends Dao{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function get($id){
		$this->db->escape_by_ref($id);	
		$query = "SELECT name
			FROM wp_ktn_forms WHERE id = {$id}";
		return $this->db->get_row($query, ARRAY_A);
	}
    
    public function save(Form $form){
        
    }
	
}
