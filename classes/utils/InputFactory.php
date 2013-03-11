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
		$sampleInputs[NumberInput::className()] = InputFactory::getSampleNumbertInput();		
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
	
	private static function getSampleNumbertInput(){
		$properties = array();
		$properties['className'] = TextInput::className();
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
	
	
}
