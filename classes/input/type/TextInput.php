<?php
class TextInput extends AbstractInput{
		
	protected $id;
		
	protected $type;

	protected $readOnly = false;
	
	protected $disabled = false;
	
	protected $template;
	
	protected $name;
	
	protected $value;
	
	protected $label;
	
	protected $placeHolder;
		
	protected $maxLength;
	
	protected $classes = array();
	
	public function getId(){
		return $this->id;
	}
	
	public function getType(){
		return "text";
	}
	
	public function isReadOnly(){
		return $this->readOnly;
	}
	
	public function isDisabled(){
		return $this->disabled;
	}
		
	public function getName(){
		return $this->name;
	}
	
	public function getTemplate(){
		return $this->template;
	}
	
	public function getValue(){
		return $this->value;
	}
	
	public function getLabel(){
		return $this->label;
	}
	
	public function getPlaceHolder(){
		return $this->placeHolder;
	}
	
	public function getMaxLength(){
		return $this->maxLength;
	}
		
	public function __construct($inputProperties = null){	
		$this->setProperties($inputProperties);		
	}
	
	public function preRender(){
	}	
	
	public static function className(){
		return get_class();
	}
					
	
}
