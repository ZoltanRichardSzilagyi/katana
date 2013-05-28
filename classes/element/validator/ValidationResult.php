<?php
namespace classes\element\validator;

class ValidationResult{
	
	private $valid;
	
	private $errors;
	
	public function __construct($valid, $errors){
		$this->valid = $valid;
		$this->errors = $errors;
	}
	
	public function isValid(){
		return $this->valid;
	}
	
	public function getErrors(){
		return $this->errors;
	}
	
	
}
