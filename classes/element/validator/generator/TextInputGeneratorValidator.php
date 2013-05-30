<?php 
namespace classes\element\validator\generator;

use classes\element\validator\generator\AbstractElementGeneratorValidator;

class TextInputGeneratorValidator extends AbstractElementGeneratorValidator{
    
    public function __construct($input){
        parent::__construct($input);
    }
    
    protected function validateCustomFields(){
           
    }
	
	private function validateMaxlength(){
		if($this->input->getMaxLength() != null){
		    if(!is_numeric($this->input->getMaxLength())){
		      $this->addError("maxLength", "Invalid maxlength value!");    
		    }
						
		}
	}
	

	
}
