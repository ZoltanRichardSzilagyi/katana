<?php
class ElementFactory{
	
	public static function getByType($inputPropertiesHolder){
		$inputType = $inputPropertiesHolder['className'];
		ClassLoader::requireAllInput();
		// TODO remove switch, secure check $className value and getInputInstance
		switch ($inputType) {
			case TextInput::className():
				return ClassLoader::getInputInstance(TextInput::className(), $inputPropertiesHolder);	
			break;
			
			case NumberInput::className():
				return ClassLoader::getInputInstance(NumberInput::className(), $inputPropertiesHolder);	
			break;
			
			case CurrencyInput::className():
				return ClassLoader::getInputInstance(CurrencyInput::className(), $inputPropertiesHolder);	
			break;
			
			case Button::className():
				return ClassLoader::getInputInstance(Button::className(), $inputPropertiesHolder);
			break;				
			
			default:
				return null;
			break;
		}
	}
	
	public static function getSampleInputs(){  
		ClassLoader::requireAllInput();	
		
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
		$properties['template'] = TextInput::className() . "Sample";
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
		$properties['template'] = NumberInput::className() . "Sample";
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
		$properties['template'] = CurrencyInput::className() . "Sample";
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
		$properties['template'] = "/input/sample/" . Button::className();
		$properties['value'] = "ok";
		$properties['label'] = "Ok";
		return self::getByType($properties);
	}
		
	
	
	
	
	
}
