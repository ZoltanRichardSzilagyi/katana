<?php 
ClassLoader::requireClass("input/validator/AbstractInputValidator");
class CurrencyInputValidator extends AbstractInputValidator{
	
	private function validateName($value){
		if(empty($value)){
			$this->addError("name", "You have to specify the name of the input!");			
		}
	}
	

	
}
