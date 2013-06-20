<?php
namespace classes\dao;

use classes\dao\Dao;

use classes\entity\form\Form;
use classes\entity\form\FormElement;

use \ArrayObject;
use \Exception;

final class FormDao extends Dao{

	public function get($formId){
		$this->db->escape($formId);	
		$query = "SELECT *
			FROM wp_ktn_forms WHERE id = {$formId}";
		
		try{
		  $dbData =  $this->db->get($query, ARRAY_A);
        }catch(Exception $e){
            // TODO log exception
        }		
		
		$form = new Form($formId, $dbData);
        return $form;
	}
    
    public function save(Form $form){
        
    }
	
}