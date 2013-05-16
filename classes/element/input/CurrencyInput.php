<?php
namespace katana\classes\element\input;
use katana\classes\element\input\TextInput;
class CurrencyInput extends TextInput{
	
	protected $locale;
	
	protected $symbol;
	
	protected $decimal;
	
	protected $precision;
	
	protected $thousand;
	
	protected $format;
	
	
	
	public static function className(){
		return get_class();
	}		
	
	public function preRender(){
	}
		
	public function getLocale(){
		return $this->locale;
	}
	
	public function getSymbol(){
		return $this->symbol;
	}		
	
	public function getDecimal(){
		return $this->decimal;
	}
	
	public function getPrecision(){
		return $this->precision;
	}
	
	public function getThousand(){
		return $this->thousand;
	}
	
	public function getFormat(){
		return $this->format;
	}
	
}