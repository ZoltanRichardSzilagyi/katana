<?php
namespace classes\utils;
use classes\Katana;
class LanguageUtils{
	
	private static $instance = null;
			
	public function __construct($basePath){
		if(LanguageUtils::$instance == null){
			$this->loadLanguages($basePath);	
		}else{
			throw new Exception("Languageloader already instantiated", 1);
		}
	}
	
	private function loadLanguages($basePath){
		$languagesDirPath = $basePath . "/languages";
		load_plugin_textdomain(Katana::ID, false, $languagesDirPath);
	}
	
	public static function translate($text){
		return __($text, Katana::ID);
	}
}