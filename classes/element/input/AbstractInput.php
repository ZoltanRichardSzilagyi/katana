<?php
namespace classes\element\input;
use classes\element\Element;
abstract class AbstractInput extends Element{
			
	protected $label;	
		
	protected $readOnly = false;
	
	protected $disabled = false;
				
	public abstract function getType();
				
			
	public function getLabel(){
		return $this->label;
	}
				
	public function isReadOnly(){
		return $this->readOnly;
	}
	
	public function isDisabled(){
		return $this->disabled;
	}

}
