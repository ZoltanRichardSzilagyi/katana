<?php
class FormEditorController extends AjaxController{
	
	private $inputFactory;
	
	private $inputElementProperties;
				
	public function getClassName(){
		return get_class();
	}
	
	public function registerAjaxEvents(){
		$this->addAdminEvent("generateInput");	
	}
	
	public function generateInput(){
		$this->setInputProperties();	
		$this->getInputFactoryInstance();

		$inputElement = InputFactory::getByType($this->inputElementProperties);
				
		$properties = $inputElement->getPropertiesList();
		$inputContent = $inputElement->toString();
		$retVal = array(
			'properties' => $properties,
			'content' => $inputContent
		);
		echo json_encode($retVal);
		exit;
	}
		
	private function setInputProperties(){		
		if(isset($_POST['inputElementProperties'])){
			$this->inputElementProperties = $_POST['inputElementProperties'];
		}
	}	
	
	private function getInputFactoryInstance(){
		$this->inputFactory = ClassLoader::getUtilsInstance("InputFactory");		
	}
	
}
