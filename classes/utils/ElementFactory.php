<?php
namespace classes\utils;

use \ReflectionClass;
use \ArrayObject;

use classes\utils\LanguageUtils;

use classes\utils\elements\ElementDescriptor;

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
	
	public static function getSampleElements(){
		$sampleInputs = new ArrayObject();
		$sampleInputs->append(self::getSampleTextInput());
		$sampleInputs->append(self::getSampleNumberInput());
		$sampleInputs->append(self::getSampleCurrencyInput());
		$sampleInputs->append(self::getSampleButton());
		return $sampleInputs;
	}

	private static function getSampleTextInput(){
		$properties = array();
		$properties['className'] = TextInput::className();
		$properties['id'] = "name";		
		$properties['name'] = "name";
		$properties['template'] = "sample";
		$properties['value'] = "Gordon Freeman";
		$properties['label'] = "Your name";
		$properties['maxLength'] = "64";
		$properties['placeholder'] = "Your name";						
		
		$input = self::getByType($properties);        
        $elementOptions = self::getSampleTextInputOptions();
        $elementDescriptor = new ElementDescriptor($input, $elementOptions);
		return $elementDescriptor;
	}
    
    private static function getSampleTextInputOptions(){
        return array(
            'type' => TextInput::className(),
            'simpleName' => TextInput::getSimpleName(),
            'templates' => array('default', 'edited')
        );
    }
	
	private static function getSampleNumberInput(){
		$properties = array();
		$properties['className'] = NumberInput::className();
		$properties['id'] = "age";		
		$properties['name'] = "age";
		$properties['template'] = "sample";
		$properties['value'] = "22";
		$properties['label'] = "Your age";
		$properties['maxLength'] = "2";
		$properties['placeholder'] = "Your age";
        
        $input = self::getByType($properties);        
        $elementDescriptor = new ElementDescriptor($input);
        return $elementDescriptor;        
	}
	
	private static function getSampleCurrencyInput(){
		$properties = array();
		$properties['className'] = CurrencyInput::className();
		$properties['id'] = "price";		
		$properties['name'] = "price";
		$properties['template'] = "sample";
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
        
        $input = self::getByType($properties);        
        $elementDescriptor = new ElementDescriptor($input);
        return $elementDescriptor;        

	}
	
	private static function getSampleButton(){
		$properties = array();
		$properties['className'] = Button::className();
		$properties['id'] = "ok";		
		$properties['name'] = "ok";
		$properties['template'] = "sample";
		$properties['value'] = "ok";
		$properties['label'] = "Ok";

        $input = self::getByType($properties);        
        $elementDescriptor = new ElementDescriptor($input);
        return $elementDescriptor;
	}	
	
}
