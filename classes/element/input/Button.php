<?php
namespace katana\classes\element\input;
use katana\classes\element\Element;
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
