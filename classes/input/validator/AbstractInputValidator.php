<?php
abstract class AbstractInputValidator{
	
	protected $translateUtils;
	
	protected $errors = array();
	
	public function validate($inputValues){		
		foreach($inputValues as $key->$value){
						
		}
	}
	
	public function getValidationResult(){
		return $this->errors;
	}
	
	public function addError($inputName, $message){
		$this->errors[$inputName] = $message;
	}
	
	
}
