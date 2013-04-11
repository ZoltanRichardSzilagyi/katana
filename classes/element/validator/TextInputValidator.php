<?php 
ClassLoader::requireClass("element/validator/AbstractInputValidator");
class TextInputValidator extends AbstractInputValidator{
	
	private function name($value){
		if(empty($value)){
			$this->addError("name", "You have to specify the name of the input!");			
		}
	}
	

	
}
