<?php
abstract class AbstractInputValidator{
	
	protected $translateUtils;
	
	protected $errors = array();
	
	public function validate($inputProperties){		
		foreach($inputProperties as $key => $value){
						
		}
	}
	
	public function getValidationResult(){
		return $this->errors;
	}
	
	public function addError($inputName, $message){
		$this->errors[$inputName] = $message;
	}
	
	
}
