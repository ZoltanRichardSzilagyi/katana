<?php
namespace classes\utils;

use classes\utils\ClassLoader;
use classes\utils\LanguageUtils;
use \ReflectionClass;
use \ArrayObject;

use classes\element\input\Button;
use classes\element\input\CurrencyInput;
use classes\element\input\DateInput;
use classes\element\input\NumberInput;
use classes\element\input\TextInput;
class ElementFactory{
	
	public static function getByType($inputPropertiesHolder){
		$inputType = $inputPropertiesHolder['className'];		
		$class = new ReflectionClass($inputType);		
		$constructor = $class->getConstructor();		
		return $class->newInstanceArgs(array($inputPropertiesHolder));
	}
	
	public static function getSampleInputs(){  
		$sampleInputs = new ArrayObject();
		$sampleInputs[TextInput::className()] = self::getSampleTextInput();
		$sampleInputs[NumberInput::className()] = self::getSampleNumberInput();
		$sampleInputs[CurrencyInput::className()] = self::getSampleCurrencyInput();
		$sampleInputs[Button::className()] = self::getSampleButton();
		return $sampleInputs;
	}

	private static function getSampleTextInput(){
		$properties = array();
		$properties['className'] = TextInput::className();
		$properties['id'] = "name";		
		$properties['name'] = "name";
		$properties['template'] = "TextInputSample";
		$properties['value'] = "Gordon Freeman";
		$properties['label'] = "Your name";
		$properties['maxLength'] = "64";
		$properties['placeholder'] = "Your name";						
		return self::getByType($properties);
	}
	
	private static function getSampleNumberInput(){
		$properties = array();
		$properties['className'] = NumberInput::className();
		$properties['id'] = "age";		
		$properties['name'] = "age";
		$properties['template'] = "NumberInputSample";
		$properties['value'] = "22";
		$properties['label'] = "Your age";
		$properties['maxLength'] = "2";
		$properties['placeholder'] = "Your age";
		return self::getByType($properties);
	}
	
	private static function getSampleCurrencyInput(){
		$properties = array();
		$properties['className'] = CurrencyInput::className();
		$properties['id'] = "price";		
		$properties['name'] = "price";
		$properties['template'] = "CurrencyInputSample";
		$properties['value'] = "1054333";
		$properties['label'] = "Price";
		$properties['maxLength'] = "15";
		$properties['placeholder'] = "Item price";
		$properties['locale'] = "Magyar forint";
		$properties['symbol'] = "HUF";
		$properties['decimal'] = ".";
		$properties['precision'] = "0";
		$properties['thousand'] = ",";
		$properties['format'] = "%v %s";
		return self::getByType($properties);
	}
	
	private static function getSampleButton(){
		$properties = array();
		$properties['className'] = Button::className();
		$properties['id'] = "ok";		
		$properties['name'] = "ok";
		$properties['template'] = "/input/sample/Button";
		$properties['value'] = "ok";
		$properties['label'] = "Ok";
		return self::getByType($properties);
	}
		
	
	
	
	
	
}
