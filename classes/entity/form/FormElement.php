<?php
namespace classes\entity\form;

class FormElement{
    
    private $page;
    
    private $elementDescriptor;
    
    public function __construct($elementData){
        if(!isset($elementData['page'])){
            throw new Exception("Invalid form element data", 1);            
        }
        $this->page = $elementData['page'];
        $this->elementDescriptor = serialize($elementData);
    }
    
    public function getPage(){
        return $this->page;
    }
    
    public function getElementDescriptor(){
        return $this->elementDescriptor;
    }
    
}
