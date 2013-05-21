<?php
namespace classes\element\input;
use classes\element\Element;
class Button extends Element{
	
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
	
	public function preRender(){
		
	}
	
}
