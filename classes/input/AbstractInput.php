<?php
abstract class AbstractInput{
		
	protected $readOnly = false;
	
	protected $disabled = false;
	
	protected $template;
	
	protected $name;
	
	protected $id;	
	
	protected $label;
		
	protected $validator;
	
	protected $page;
		
	public abstract static function className();
	
	public abstract function getType();
		
	public abstract function preRender();
	
	public function __construct($inputProperties = null){	
		$this->setProperties($inputProperties);		
	}	
	
	public function getName(){
		return $this->name;
	}	
	
	public function getId(){
		return $this->id;
	}
	
	public function getLabel(){
		return $this->label;
	}
	
		
	public function validate(){
		$this->validator->validate($this->getPropertiesList());
	}
	
	public function getValidator(){
		return $this->validator; 
	}
	
	public function setValidator($validator){
		$this->validator = $validator;
	}
	
	public function getPage($page){
		return $this->page;
	}
	
	public function setPage($page){
		$this->page = $page;
	}
		
	public function getTemplate(){
		return $this->template;
	}

	public function isReadOnly(){
		return $this->readOnly;
	}
	
	public function isDisabled(){
		return $this->disabled;
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
		TemplateUtils::fetchTemplate("inputs/" . $this->getTemplate(), $this->templateValues);
	}
	
	public function toHtml(){
		ob_start();
		$this->render();
		return ob_get_clean();
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

}
