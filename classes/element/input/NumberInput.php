<?php
namespace classes\element\input;
use classes\element\input\TextInput;
class NumberInput extends TextInput{
	
	public static function getSimpleName(){
		return "NumberInput";
	} 	
		
	public static function className(){
		return get_class();
	}		
	
	public function preRender(){
	}
		
}