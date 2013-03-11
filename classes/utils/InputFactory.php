<?php
class InputFactory{
		
	public static function getInputs($inputPropertiesHolderList){
		$inputs = new ArrayObject();
		$inputPropetiesIterator = $inputPropertiesHolderList->getIterator();
		while($inputPropetiesIterator->valid()){
 
		}
		return $inputs;
	}
	
	public static function getByType($inputPropertiesHolder){
		$inputType = $inputPropertiesHolder['className'];
		switch ($inputType) {
			case TextInput::className():
				return InputFactory::getTextInput($inputPropertiesHolder);	
			break;
			
			case NumberInput::className():
				return ClassLoader::getInputInstance(NumberInput::className(), $inputPropertiesHolder);	
			break;
			
			case CurrencyInput::className():
				return ClassLoader::getInputInstance(CurrencyInput::className(), $inputPropertiesHolder);	
			break;			
			
			default:
				return null;
			break;
		}
	}
	
	public static function getTextInput($inputPropertiesHolder){
		return ClassLoader::getInputInstance(TextInput::className(), $inputPropertiesHolder);
	}
	
	
	public static function getSampleInputs(){
		ClassLoader::requireAllInput();	
		$sampleInputs = new ArrayObject();
		$sampleInputs[TextInput::className()] = InputFactory::getSampleTextInput();
		$sampleInputs[NumberInput::className()] = InputFactory::getSampleNumberInput();
		$sampleInputs[CurrencyInput::className()] = InputFactory::getSampleCurrencyInput();
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
		$properties['placeHolder'] = "Your name";
		$properties['readOnly'] = true;						
		return InputFactory::getByType($properties);
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
		$properties['placeHolder'] = "Your age";
		$properties['readOnly'] = true;
		return InputFactory::getByType($properties);
	}
	
	private static function getSampleCurrencyInput(){
		$properties = array();
		$properties['className'] = CurrencyInput::className();
		$properties['id'] = "age";		
		$properties['name'] = "age";
		$properties['template'] = CurrencyInput::className() . "Sample";
		$properties['value'] = "10";
		$properties['label'] = "Price";
		$properties['maxLength'] = "2";
		$properties['placeHolder'] = "Your age";
		$properties['readOnly'] = true;
		$properties['locale'] = "Magyar forint";
		$properties['symbol'] = "HUF";
		$properties['decimal'] = ".";
		$properties['decimalPlaces'] = "2";
		$properties['grouping'] = ",";
		return InputFactory::getByType($properties);
	}	
	
		
	
	
}
