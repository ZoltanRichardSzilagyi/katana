<?php
ClassLoader::requireClass("element/Element");
abstract class AbstractInput extends Element{
			
	protected $label;	
		
	protected $readOnly = false;
	
	protected $disabled = false;

	protected $validator;
		
	public abstract static function className();
	
	public abstract function getType();
		
	public abstract function preRender();
		
	public function __construct($inputProperties = null){	
		$this->setProperties($inputProperties);		
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

	public function isReadOnly(){
		return $this->readOnly;
	}
	
	public function isDisabled(){
		return $this->disabled;
	}

}
