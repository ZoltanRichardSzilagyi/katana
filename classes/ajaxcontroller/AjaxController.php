<?php
namespace katana\classes\ajaxcontroller;
abstract class AjaxController{
		
	public abstract function getClassName();	
		
	public abstract function registerAjaxEvents();

	protected function addPublicEvent($methodName){
		$hookName = $this->createHookName($methodName);	
		add_action('wp_ajax_nopriv_' . $hookName, array($this, $methodName));				
	}
	
	protected function addAdminEvent($methodName){
		$hookName = $this->createHookName($methodName);
		add_action('wp_ajax_' . $hookName, array($this, $methodName));
	}
	
	private function createHookName($methodName){
		return $this->getClassName() . "_" . $methodName;
	}
	
	
		
}
