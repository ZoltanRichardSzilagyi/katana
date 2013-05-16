<?php
namespace katana\classes\ajaxcontroller;
use katana\classes\utils\ClassLoader;

class FormEditorController extends AjaxController{
	
	private $elementFactory;
	
	private $inputElementProperties;
				
	public function getClassName(){
		return get_class();
	}
	
	public function registerAjaxEvents(){
		$this->addAdminEvent("generateInput");
		$this->addAdminEvent("saveForm");	
	}
	
	public function generateInput(){
		$this->exitAtEmptyInputProperties();
		$this->setInputProperties();	
		$this->getElementFactoryInstance();
		$inputElement = $this->elementFactory->getByType($this->inputElementProperties);
		$properties = $inputElement->getPropertiesList();
		// TODO wrap inputproperties array, add getClassName and other standard methods
		$validator = ClassLoader::getInputValidatorInstance($this->inputElementProperties['className']);
		$inputElement->setValidator($validator);
		
		$inputElement->validate();
		$validationResult = $inputElement->getValidator()->getValidationResult();
		$retVal = array(
			'properties' => $properties,
			'content' => $inputElement->toHtml(),
			'valid' => $inputElement->getValidator()->isValid(),
			'errors' => $validationResult
		);
		echo json_encode($retVal);
		exit;
	}
	
	public function saveForm(){
		// TODO
	}
			
	private function exitAtEmptyInputProperties(){
		if(!$this->isInputPropertiesSended()){
			exit;
		}		
	}
	
	private function isInputPropertiesSended(){
		return isset($_POST['inputElementProperties']);
	}
	
	private function setInputProperties(){		
		if(isset($_POST['inputElementProperties'])){
			$this->inputElementProperties = $_POST['inputElementProperties'];
		}
	}	
	
	private function getElementFactoryInstance(){
		$this->elementFactory = ClassLoader::getUtilsInstance("ElementFactory");		
	}
	
	
}
