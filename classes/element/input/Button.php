<?php
namespace classes\element\input;
use classes\element\Element;
class Button extends Element{
	
	protected $value;
		
	protected $label;
	
	public static function getSimpleName(){
		return "Button";
	} 	
	
	public static function className(){
		return get_class();
	}
	
	// TODO create
	public function createValidatorInstance(){
		return null;
	}			
	
	
	public function getValue(){
		return $this->value;
	}
	
	public function getLabel(){
		return $this->label;
	}
	
	public function preRender(){
		
	}
	
}
