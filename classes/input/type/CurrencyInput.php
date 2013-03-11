<?php
class CurrencyInput extends TextInput{
	
	protected $locale;
	
	protected $symbol;
	
	protected $decimal;
	
	protected $decimalPlaces;
	
	protected $grouping;
	
	
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
	
	public function getLocale(){
		return $this->locale;
	}
	
	public function getSymbol(){
		return $this->symbol;
	}		
	
	public function getDecimal(){
		return $this->decimal;
	}
	
	public function getDecimalPlaces(){
		return $this->decimalPlaces;
	}
	
	public function getGrouping(){
		return $this->grouping;
	}
	
}