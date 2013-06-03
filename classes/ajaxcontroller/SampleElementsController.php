<?php
namespace classes\ajaxcontroller;

use classes\utils\ElementFactory;
use classes\ajaxcontroller\AjaxController;

class SampleElementsController extends AjaxController{
    
    private $sampleInputs;
        
    public function getClassName(){
        return get_class();
    }
    
    public function registerAjaxEvents(){
        $this->addAdminEvent("getSampleInputs");   
    }
    
    public function getSampleInputs(){
        $this->createSampleInputs();
        echo json_encode($this->sampleInputs);
        die();
    }
    
    private function createSampleInputs(){
        $elementFactory = new ElementFactory();
        $this->sampleInputs = $elementFactory->getSampleInputs();        
    }

}