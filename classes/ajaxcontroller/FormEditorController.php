<?php
namespace classes\ajaxcontroller;

use classes\utils\ClassLoader;
use classes\utils\ElementFactory;
use classes\ajaxcontroller\AjaxController;

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
		
		$validationResult = $inputElement->validate();
		$retVal = array(
			'properties' => $properties,
			'content' => $inputElement->toHtml(),
			'valid' => $validationResult->isValid(),
			'errors' => $validationResult->getErrors()
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
		$this->normalizeClassName();
	}
	
	private function normalizeClassName(){
		$className = $this->inputElementProperties['className'];
		$normalizedClassName = str_replace("\\\\", "\\", $className);
		$this->inputElementProperties['className'] = $normalizedClassName;
		
	}
	
	private function getElementFactoryInstance(){
		$this->elementFactory = new ElementFactory();		
	}
	
	
}
