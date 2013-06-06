<?php
namespace classes\ajaxcontroller;

use \ArrayObject;

use classes\utils\ElementFactory;
use classes\ajaxcontroller\AjaxController;

use classes\dao\FormDao;

use classes\entity\form\Form;
use classes\entity\form\FormElement;

class FormEditorController extends AjaxController{
	
	private $elementFactory;
	
	private $inputElementProperties;
    
    private $formElementsInputData;
    
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
        $this->inputElementProperties['className'] = $this->normalizeClassName($this->inputElementProperties['className']);
	}
	
	private function normalizeClassName($className){
		return str_replace("\\\\", "\\", $className);		
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
        $this->createFormElements();
        $this->formDAO = new FormDao();
            
    }
    
    private function setFormElementsData(){
        if(isset($_POST['elements'])){
            $this->formElementsInputData = $_POST['elements'];
        }
    }
    
    private function validateSaveFormData(){
        return !empty($this->formElementsInputData);
    }
    
    private function normalizeFormElementsClassName(){
        foreach($this->formElementsInputData as $key => $value){
            $className = $value['className']; 
            $this->formElementsInputData[$key]['className'] = $this->normalizeClassName($className);
        };
    }
    
    private function createFormElements(){
        $this->normalizeFormElementsClassName();
        $this->formElements = new ArrayObject();
        foreach ($this->formElementsInputData as $value) {
            $formElement = new FormElement($value);
            $this->formElements->append($formElement);           
        }    
    }
    
	
	
}
