<?php
namespace classes\element\input;
use classes\element\input\TextInput;
class DateInput extends TextInput{
	
	protected $locale;
	
	public static function getSimpleName(){
		return "DateInput";
	} 	
		
	public static function className(){
		return get_class();
	}
	
	// TODO create
	public function createValidatorInstance(){
		return null;
	}
    
    // TODO create
    public function createGeneratorValidatorInstance(){
        return null;
    }

	public function preRender(){
	}
		
	public function getLocale(){
		return $this->locale;
	}		

}
