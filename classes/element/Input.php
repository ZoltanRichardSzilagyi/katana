<?php
interface Input{
	
	public function getType();
		
	public function getValue();	
		
	public function setValue($value);		
		
	public function getLabel();
	
	public function setLabel($label);
	
	public function getPlaceHolder();
	
	public function setPlaceHolder($placeHolder);
	
	public function render();
	
	public function getClasses();
	
	public function setClasses($classes);
	
	public function getMaxLength();
	
	public function setMaxLength($maxLength);
	
}
