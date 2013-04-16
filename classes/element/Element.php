<?php
abstract class Element{

	protected $id;
	
	protected $name;
	
	protected $page;
	
	protected $template;
	
	public abstract static function className();
	
	private $excludedProperties = array(
		'validator' => true
	);			
	
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

		
	public function render(){
		$this->preRender();
		
		$this->templateValues = ClassLoader::getValueHolderInstance();
		$this->templateValues->add("input", $this);
		TemplateUtils::fetchTemplate("elements/" . $this->getTemplate(), $this->templateValues);
	}
	
	public function toHtml(){
		ob_start();
		$this->render();
		return ob_get_clean();
	}
	
}