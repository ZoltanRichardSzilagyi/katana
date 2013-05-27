<?php
namespace classes\element;

use classes\utils\ValueHolder;
use classes\utils\TemplateUtils;
use classes\utils\LanguageUtils;
use \ReflectionObject;

abstract class Element{

	protected $id;
	
	protected $name;
	
	protected $page;
	
	protected $template;
	
	protected $validator;
	
	private $excludedProperties = array(
		'validator' => true
	);		
	
	public function __construct($inputProperties = null){	
		$this->setProperties($inputProperties);		
	}	
	
	public abstract static function className();
	
	public function validate(){
		$this->validator->validate($this->getPropertiesList());
	}
			
	public function getValidator(){
		return $this->validator; 
	}
	
	public function setValidator(AbstractInputValidator $validator){
		$this->validator = $validator;
	}
	
	public function getName(){
		return $this->name;
	}	
	
	public function getId(){
		return $this->id;
	}
	
	public function getPage(){
		return $this->page;
	}

	public function getTemplate(){
		return $this->template;
	}

	public function getPropertiesList(){
		$reflectionObject = new ReflectionObject($this);
		$properties = $reflectionObject->getProperties();
		$propertiesList = array();
		foreach($properties as  $property){
			$property->setAccessible(true);
			$propertiesList[$property->name] = $property->getValue($this);				
		}
		return $propertiesList;
	}
	
	protected function setProperties($inputProperties){
		if($inputProperties == null){
			return;
		}
		foreach($inputProperties as $key => $value){
			$this->$key = $value;
		}
	}
	
	public abstract function preRender();		

		
	public function render(){
		$this->preRender();
		
		$this->templateValues = new ValueHolder();
		$this->templateValues->add("input", $this);
		$template = $this->translateTemplateToPath();
		TemplateUtils::fetchTemplate($this->translateTemplateToPath(), $this->templateValues);
	}
	
	private function translateTemplateToPath(){
		return str_replace(".", "/", $this->getTemplate());
	}
	
	public function toHtml(){
		ob_start();
		$this->render();
		return ob_get_clean();
	}
	
}