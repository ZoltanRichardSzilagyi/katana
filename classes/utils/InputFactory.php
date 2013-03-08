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
		$properties['readOnly'] = "name";
						
		return InputFactory::getByType($properties);
	}
	
	
}
