<?php
namespace classes\entity\form;

use \ArrayObject;

class Form{
    
    private $formId;
    
    private $formElements;
    
    public function __construct($formDescriptor, ArrayObject $formElements){
          $this->setFormId($formDescriptor);
        $this->formElements = $formElements;
    }
    
    private function setFormId($formDescriptor){
        if(is_array($formDescriptor)){
            // TODO set properties
        }else{
            $this->formId = $formDescriptor;
        }
    }
    
    public function getFormId(){
        return $this->formId;
    }
    
    public function getFormElements(){
        return $this->formElements;
    }
}
