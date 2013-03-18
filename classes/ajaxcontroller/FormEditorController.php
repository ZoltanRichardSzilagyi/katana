<?php
class FormEditorController extends AjaxController{
	// TODO szétszedni a controllereket, és regisztrálásnál példányosítani, szabv. metódust hívni
	public function getClassName(){
		return get_class();
	}
	
	public function registerAjaxEvents(){
		$this->addAdminEvent("generateInput");	
	}
	
	public function generateInput(){
		$inputElementType = $this->getInputElementType();
		if($inputElementType == null){
			exit;
		}
		
		echo '<input type="text" value="in progress ... :)" name="sample'.rand(0, 16384).'" />';
		exit;
	}
	
	private function getInputElementType(){
		return isset($_GET['inputElementType']) ? $_GET['inputElementType'] : null; 
	}
	
}
