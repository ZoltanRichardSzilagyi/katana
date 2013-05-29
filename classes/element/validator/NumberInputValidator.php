<?php 
namespace classes\element\validator;
use classes\element\validator\AbstractInputValidator;

class NumberInputValidator extends AbstractInputValidator{
	
	private function validateName($value){
		if(empty($value)){
			$this->addError("name", "You have to specify the name of the input!");			
		}
	}
	

	
}
