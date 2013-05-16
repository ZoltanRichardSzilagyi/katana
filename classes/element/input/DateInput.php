<?php
namespace katana\classes\element\input;
use katana\classes\element\input\TextInput;
class DateInput extends TextInput{
	
	protected $locale;
		
	public static function className(){
		return get_class();
	}		
	
	public function preRender(){
	}
		
	public function getLocale(){
		return $this->locale;
	}		

}
