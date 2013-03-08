<?php
class TemplateUtils{
	
	public function __construct($basePath){
		if(TemplateUtils::$instance == null){			
			$this->templatesPath = $basePath . "/templates/";
			TemplateUtils::$instance = $this;
		}else{
			throw new Exception("TemplateUtils already instantiated", 1);
		}
			
	}	
	
	/**
	 * @var TemplateUtils
	 */
	private static $instance;	
		
	public $templatesPath;
	
	public static function fetchTemplate($templateName, $templateParams = null){	
		if($templateParams != null){
			extract($templateParams->getValues());
		}
		require(TemplateUtils::$instance->getTemplatesPath() . $templateName . ".php");				
	}
	
	public function getTemplatesPath(){
		return $this->templatesPath;
	}
	
	

}
