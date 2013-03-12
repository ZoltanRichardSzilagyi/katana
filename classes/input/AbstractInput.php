<?php
abstract class AbstractInput{
// TODO rename to DomElement
		
	public abstract static function className();
	
	public abstract function getType();
	
	public abstract function getId();
	
	public abstract function preRender();
	
	public abstract function validate();
	
	public function __construct($inputProperties = null){	
		$this->setProperties($inputProperties);		
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

}
