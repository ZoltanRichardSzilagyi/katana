<?php 
ClassLoader::requireClass("element/validator/AbstractInputValidator");
class NumberInputValidator extends AbstractInputValidator{
	
	private function validateName($value){
		if(empty($value)){
			$this->addError("name", "You have to specify the name of the input!");			
		}
	}
	

	
}
