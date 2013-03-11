<?php
class NumberInput extends TextInput{
	
	
	public function __construct($inputProperties = null){	
		$this->setProperties($inputProperties);		
	}
	
	public static function className(){
		return get_class();
	}		
	
	public function preRender(){
	}
	
	public function validate(){
	
	}		
	
}