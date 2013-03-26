<?php
/**
 * @package Katana
 * @version 1.0
 */
/*
Plugin Name: Katana
Plugin URI: n/a
Description: Katana - Dynamic form editor plugin. 
Author: Zoltán Szilágyi
Version: 1.0
Author URI: n/a
*/
class Katana{
	
	const VERSION = "1.0";
	
	const ID ="katana";
	
	public function __construct(){
		$this->init();
	}	
	
	private function init(){
		$basePath = dirname(__FILE__);
		$this->initUtilClasses($basePath);
		
		add_action("init", array($this, "registerPostTypes"));		
		$this->registerAdminAjaxControllers();
	}
	
	private function initUtilClasses($basePath){
		require_once("/classes/utils/ClassLoader.php");			
		new ClassLoader($basePath);		
				
		ClassLoader::getClassInstance("utils/LanguageUtils", $basePath);
		ClassLoader::getClassInstance("utils/TemplateUtils", $basePath);

	}
	
	public function registerPostTypes(){
		ClassLoader::getCustomPostTypeInstance("FormPostType");
	}
	
	private function registerAjaxControllers(){
		
	}
	
	private function registerAdminAjaxControllers(){
		if(!is_admin()){
			return;
		}
		$controller = ClassLoader::getAjaxControllerInstance("FormEditorController");
		$controller->registerAjaxEvents();
	}
	
	
}

new Katana();