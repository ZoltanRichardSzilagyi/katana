<?php
namespace classes\posttype;
abstract class CustomPostType{

	protected $postTypeData;
	
	protected $postTypeId;
	
	public function __construct(){
		$this->initPostTypeData();
		$this->registerPostType();
	}
		
	public function getPostType(){
		return $this->postTypeData;
	}
	
	public function getPostTypeId(){
		return $this->postTypeId;
	}
	
	protected abstract function initPostTypeData();
	
	public abstract function addmetaBoxes();
		
	final private function registerPostType(){
		register_post_type($this->postTypeId, $this->postTypeData);
	}
	
	final protected function registerMetaBox($metaBoxId, $label){
		add_meta_box($metaBoxId, $label, 
		array($this, $metaBoxId), $this->postTypeId );
	}	
	
}
