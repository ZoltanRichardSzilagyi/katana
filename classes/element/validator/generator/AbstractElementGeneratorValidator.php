<?php
namespace classes\element\validator\generator;

use classes\utils\LanguageUtils;

use classes\element\validator\ValidationResult;
use classes\element\Element;

abstract class AbstractElementGeneratorValidator{
        
    protected $element;
		
	protected $errors = array();
    
    
    protected abstract function validateCustomFields();
    
    public function __construct(Element $element){
        $this->element = $element;
    }
    
	public function validate(){
        $this->validateDefaultFields();
	    $this->validateCustomFields();
        return new ValidationResult($this->isValid(), $this->errors);
	}
    
    public function addError($inputName, $message){
        $this->errors[$inputName] = LanguageUtils::translate($message);
    }    
    
    
    
    private function validateDefaultFields(){
        $this->validateName();
        $this->validateTemplate();
    }
    
    protected function validateName(){
        if($this->element->getName() == null){
            $this->addError("name", "Missing name!");
        }
    }
    
    protected function validateTemplate(){
        if($this->element->getId() == null){
            $this->addError("template", "Select a template!");
        }        
    }
            	
	private function isValid(){
		return empty($this->errors);
	}
	
	
	
}
