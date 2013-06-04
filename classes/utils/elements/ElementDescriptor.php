<?php
namespace classes\utils\elements;
use classes\element\Element;

class ElementDescriptor{
        
    public $element;
    
    public $elementOptions;

    public function __construct(Element $element, $elementOptions = null){
        $this->element = $element->toHtml();
        $this->elementOptions = $elementOptions;
    }
    
}
