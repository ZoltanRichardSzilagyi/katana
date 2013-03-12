<?php
class DateInput extends TextInput{
	
	protected $locale;
		
	public static function className(){
		return get_class();
	}		
	
	public function preRender(){
	}
	
	public function validate(){
	
	}
	
	public function getLocale(){
		return $this->locale;
	}		

}
