<?php
ClassLoader::requireInputType("TextInput");
class NumberInput extends TextInput{
		
	public static function className(){
		return get_class();
	}		
	
	public function preRender(){
	}
		
}