<?php
namespace katana;

use katana\classes\utils\ClassLoader;
use katana\classes\utils\LanguageUtils;
use katana\classes\utils\TemplateUtils;
use katana\classes\ajaxcontroller\FormEditorController;
use katana\classes\posttype\FormPostType;
use \Exception;

class Katana{
	
	const VERSION = "1.0";
	
	const ID ="katana";
	
	private static $pluginDirRootPath;
	
	public function __construct(){
		$this->setPluginDirRootPath();
		spl_autoload_register(__NAMESPACE__."\Katana::autoload");	
		$this->init();		
	}
	
	public static function autoload($class){
		// FIXME this bug	
		if($class!="wp_atom_server" && $class!="WP_User_Search"){
			var_dump($class);						
			require_once(Katana::$pluginDirRootPath . $class.".php");
		}
	}
	
	private function setPluginDirRootPath(){
		$pluginNamePos = strrpos(dirname(__FILE__), self::ID);
		Katana::$pluginDirRootPath = substr(dirname(__FILE__),0, $pluginNamePos);
	}
	
	private function init(){
		// TODO 	
		$basePath = str_replace("classes", "", dirname(__FILE__));
		$this->initUtilClasses($basePath);		
		add_action("init", array($this, "registerPostTypes"));				
		$this->registerAdminAjaxControllers();
	}
	
	private function initUtilClasses($basePath){					
		new ClassLoader($basePath);
		new LanguageUtils($basePath);
		new TemplateUtils($basePath);
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
		$controller = new FormEditorController();
		$controller->registerAjaxEvents();
	}
	
	
}