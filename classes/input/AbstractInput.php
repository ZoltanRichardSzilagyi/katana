<?php
abstract class AbstractInput{
// TODO rename to DomElement
		
	public abstract static function className();
	
	public abstract function getTemplate();
	
	public abstract function getType();
	
	public abstract function getId();
	
	public abstract function isReadOnly();
	
	public abstract function isDisabled();
	
	public abstract function preRender();
	
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
