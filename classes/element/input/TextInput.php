<?php
namespace classes\element\input;

use classes\element\input\AbstractInput;
use classes\element\validator\TextInputValidator;
use classes\element\validator\generator\TextInputGeneratorValidator;

class TextInput extends AbstractInput{

	protected $value;
		
	protected $placeholder;
		
	protected $maxLength;
	
	protected $classes = array();
			
	public static function getSimpleName(){
		return "TextInput";
	} 
	
	public static function className(){
		return get_class();
	}
		
	public function preRender(){
	}	
		
	
	public function getType(){
		return "text";
	}
	
	public function createValidatorInstance(){
		return new TextInputValidator();
	}
    
    public function createGeneratorValidatorInstance(){
        return new TextInputGeneratorValidator($this);
    }
				
	public function getValue(){
		return $this->value;
	}
	
	
	public function getPlaceholder(){
		return $this->placeholder;
	}
	
	public function getMaxLength(){
		return $this->maxLength;
	}				
}
