<?php
namespace classes\entity\form;

use \ArrayObject;
use \classes\utils\json\JSONSerializable;

class Form implements JSONSerializable{
    
    private $formId = null;
    
    private $formElements = null;
    
    public function __construct($formDescriptor, ArrayObject $formElements = null){
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
    
    public function toJSONSerialize(){
        $toJSON = array();
        $toJSON["formId"] = $this->formId;
        // TODO serialize form elements
    }
}
