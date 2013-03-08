<?php
class ValueHolder{
	
	private $values = array();
	
	public function getValues(){
		return $this->values;
	}
	
	public function add($key, $value){
		$this->values[$key] = $value;
	}
	
}
