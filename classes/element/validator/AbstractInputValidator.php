<?php
namespace classes\element\validator;
use classes\element\validator\ValidationResult;

abstract class AbstractInputValidator{
	
	protected $translateUtils;
	
	protected $errors = array();
	
	public function validate($inputProperties){		
		foreach($inputProperties as $key => $value){
						
		}
		return new ValidationResult($this->isValid(), $this->errors);
	}
	
	private function isValid(){
		return empty($this->errors);
	}
	
	public function addError($inputName, $message){
		$this->errors[$inputName] = $message;
	}
	
	
}
