<?php
class TemplateUtils{
	
	public function __construct($basePath){
		if(TemplateUtils::$instance == null){			
			$this->templatesPath = $basePath . "/templates/";
			TemplateUtils::$instance = $this;
			TemplateUtils::$styleBaseUrl =  plugins_url(Katana::ID) . "/css/";
			TemplateUtils::$scriptBaseUrl =  plugins_url(Katana::ID) . "/js/";			
		}else{
			throw new Exception("TemplateUtils already instantiated", 1);
		}
			
	}	
	
	/**
	 * @var TemplateUtils
	 */
	private static $instance;	
		
	private $templatesPath;
	
	private static $styleBaseUrl;
	
	private static $scriptBaseUrl;

	public static function fetchTemplate($templateName, $templateParams = null){	
		if($templateParams != null){
			extract($templateParams->getValues());
		}
		require(TemplateUtils::$instance->getTemplatesPath() . $templateName . ".php");				
	}

	public function getTemplatesPath(){
		return $this->templatesPath;
	}
	
	public static function attachStyle($styleHandler, $styleName){
			$cssUrl = TemplateUtils::$styleBaseUrl .  $styleName . ".css";
			wp_enqueue_style($styleHandler, $cssUrl);
	}
	
	public static function attachScript($jsHandler, $jsName, $dependencies = array()){
			$jsUrl = TemplateUtils::$scriptBaseUrl .  $jsName . ".js";
			wp_enqueue_script($jsHandler, $jsUrl, $dependencies); 
	}
	
	

}
