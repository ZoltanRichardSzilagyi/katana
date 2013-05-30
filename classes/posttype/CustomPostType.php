<?php
namespace classes\posttype;
abstract class CustomPostType{

	protected $postTypeData;
	
	protected $postTypeId;
	
	public function __construct(){
		$this->initPostTypeData();
		$this->registerPostType();
	}
		
	/**
     * Return with the post type descriptor data
     */
	public function getPostTypeData(){
		return $this->postTypeData;
	}
	
	/**
     * Return with the id of the post type
     */
	public function getPostTypeId(){
		return $this->postTypeId;
	}
	
	/**
     * Initializing the post type data, to create the custom post type
     */
	protected abstract function initPostTypeData();
	
	/**
     * Add the meta boxes of the post type to the system
     */
	public abstract function addmetaBoxes();
		
	/**
     * Register post type
     */
	final private function registerPostType(){
		register_post_type($this->postTypeId, $this->postTypeData);
	}
	
	/**
     * Register meta box
     */
	final protected function registerMetaBox($metaBoxId, $label){
		add_meta_box($metaBoxId, $label, 
		array($this, $metaBoxId), $this->postTypeId );
	}	
	
}
