<?php
//namespace katana;

namespace classes;

use classes\utils\ClassLoader;
use classes\utils\LanguageUtils;
use classes\utils\TemplateUtils;
use classes\ajaxcontroller\FormEditorController;
use classes\posttype\FormPostType;
use \Exception;

class Katana{
	
	const VERSION = "1.0";
	
	const ID ="katana";
		
	private static $pluginDirRootPath;
	
	public function __construct($basePath){
		$this->setPluginDirRootPath($basePath);
		$this->registerAutoLoader();	
		$this->init();		
	}
			
	public function registerAutoLoader(){
		spl_autoload_register(__NAMESPACE__."\Katana::autoload");
	}
	
	private static function autoload($class){
		if($class == 'TextInput'){
			debug_print_backtrace();
		}
		if($class!="wp_atom_server" && $class!="WP_User_Search" && $class != "WP_Widget_Meta"){	
			require_once(Katana::$pluginDirRootPath . $class.".php");
		}
	}
	
	private function setPluginDirRootPath($basePath){
		Katana::$pluginDirRootPath = $basePath . "/";
	}
	
	private function init(){
		$this->initUtilClasses();		
		add_action("init", array($this, "registerPostTypes"));				
		$this->registerAdminAjaxControllers();
	}
	
	private function initUtilClasses(){					
		new ClassLoader(Katana::$pluginDirRootPath);
		new LanguageUtils(Katana::$pluginDirRootPath);
		new TemplateUtils(Katana::$pluginDirRootPath);
	}
	
	public function registerPostTypes(){
		new FormPostType();
	}
	
	private function registerAjaxControllers(){
		
	}
	
	private function registerAdminAjaxControllers(){
		if(!is_admin()){
			return;
		}
		/**
		 * @var FormEditorController
		 */
		$controller = new FormEditorController();
		$controller->registerAjaxEvents();
	}
	
	
}