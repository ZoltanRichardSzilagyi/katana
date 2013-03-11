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
	
	public function __construct($inputProperties = null){	
		$this->setProperties($inputProperties);		
	}
	
	public static function className(){
		return get_class();
	}
	
	public function validate(){
		
	}
	
	public function preRender(){
	}	
		
	public function getId(){
		return $this->id;
	}
	
	public function getType(){
		return "text";
	}
		
	public function getName(){
		return $this->name;
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
}
