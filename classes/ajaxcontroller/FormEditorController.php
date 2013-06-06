<?php
namespace classes\ajaxcontroller;

use classes\utils\ElementFactory;
use classes\ajaxcontroller\AjaxController;

use classes\dao\FormDao;

class FormEditorController extends AjaxController{
	
	private $elementFactory;
	
	private $inputElementProperties;
    
    private $formElements;
    
    private $formDAO;
				
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
		
		$validationResult = $inputElement->validateGenerator();
		$retVal = array(
			'properties' => $properties,
			'content' => $inputElement->toHtml(),
			'valid' => $validationResult->isValid(),
			'errors' => $validationResult->getErrors()
		);
		echo json_encode($retVal);
		exit;
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
    
    public function saveForm(){
        $this->setFormElementsData();
        if(!$this->validateSaveFormData()){
            // TODO error handling
            die();
        }
        $this->formDAO = new FormDao();
            
    }
    
    private function setFormElementsData(){
        if(isset($_POST['elements'])){
            $this->formElements = $_POST['elements'];
        }
    }
    
    private function validateSaveFormData(){
        return !empty($this->formElements);
    }
    
	
	
}
