<?php
ClassLoader::requireClass("input/AbstractInput");
class TextInput extends AbstractInput{

	protected $value;
		
	protected $placeholder;
		
	protected $maxLength;
	
	protected $classes = array();
			
	public static function className(){
		return get_class();
	}
		
	public function preRender(){
	}	
		
	
	public function getType(){
		return "text";
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
