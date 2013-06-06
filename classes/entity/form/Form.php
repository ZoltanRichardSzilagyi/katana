<?php
namespace classes\entity\form;

use \ArrayObject;

class Form{
    
    private $formId;
    
    private $formElements;
    
    public function __construct($formDescriptor, ArrayObject $formElements){
        $this->formElements = $formElements;
    }
}
