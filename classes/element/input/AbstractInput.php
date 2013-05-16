<?php
namespace katana\classes\element\input;
use katana\classes\element\Element;
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
