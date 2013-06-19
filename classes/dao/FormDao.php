<?php
namespace classes\dao;

use classes\dao\Dao;

use classes\entity\form\Form;
use classes\entity\form\FormElement;

use \ArrayObject;

final class FormDao extends Dao{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function get($formId){
		$this->db->escape_by_ref($id);	
		$query = "SELECT name
			FROM wp_ktn_forms WHERE id = {$id}";
		$dbData =  $this->db->get_row($query, ARRAY_A);
		
		$form = new Form($formId, new ArrayObject());
        return $form;
	}
    
    public function save(Form $form){
        
    }
	
}