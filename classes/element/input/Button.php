<?php
ClassLoader::requireClass("element/Element");
class Button{
	
	protected $value;
		
	protected $label;
	
	public static function className(){
		return __CLASS__;
	}
	
	public function getValue(){
		return $this->value;
	}
	
	public function getLabel(){
		return $this->label;
	}
	
}
