<?php
namespace classes\ajaxcontroller;

use classes\utils\ElementFactory;
use classes\ajaxcontroller\AjaxController;

class SampleElementsController extends AjaxController{
    
    private $sampleElements;
        
    public function getClassName(){
        return get_class();
    }
    
    public function registerAjaxEvents(){
        $this->addAdminEvent("getSampleElements");   
    }
    
    public function getSampleElements(){
        $this->createSampleElements();
        echo json_encode($this->sampleElements);
        die();
    }
    
    private function createSampleElements(){
        $elementFactory = new ElementFactory();
        $this->sampleElements = $elementFactory->getSampleElements();        
    }

}