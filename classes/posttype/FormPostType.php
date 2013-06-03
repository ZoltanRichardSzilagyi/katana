<?php
namespace classes\posttype;

use classes\Katana;

use classes\utils\LanguageUtils;
use classes\utils\ElementFactory;
use classes\utils\TemplateUtils;
use classes\utils\ValueHolder;

use classes\dao\FormDao;

class FormPostType extends CustomPostType{
	
	protected $postTypeId = "katana_forms";
		
	/**
	 * @var FormDao
	 */
	private $formDao;
	
	/**
	 * @var ValueHolder
	 */
	private $templateValues;
	
	public function __construct__(){
		parent::__construct();		
	}

	protected function initPostTypeData(){
		$labels = array(
			'name' => __("Katana forms", Katana::ID),
		    'singular_name' => __("Katana forms"),
		    'add_new' => LanguageUtils::translate("Create new form"),
		    'add_new_item' => LanguageUtils::translate("Create new form"),
		    'edit_item' => LanguageUtils::translate("Edit form"),
		    'new_item' => LanguageUtils::translate("Create new form"),
		    'all_items' => LanguageUtils::translate("List forms"),
		    'view_item' => LanguageUtils::translate("View form"),
		    'search_items' => LanguageUtils::translate("Search form"),
		    'not_found' =>  LanguageUtils::translate("Form not found"),
		    'not_found_in_trash' => LanguageUtils::translate("Form not found in trash"), 
		    'parent_item_colon' => '',
		    'menu_name' => __("Katana forms", Katana::ID),
		
		);		
		$this->postTypeData = array(
	    	'labels' => $labels,
	    	'public' => false,
	    	'publicly_queryable' => true,
	    	'show_ui' => true, 
	    	'show_in_menu' => true, 
	    	'query_var' => true,
	    	'rewrite' => array('slug' => 'katana-forms'),
	    	'capability_type' => 'post',
	    	'has_archive' => false, 
	    	'hierarchical' => false,
		    'menu_position' => null,
		    'supports' => array( 'title'),
		    'taxonomies' => array('katana-forms'),
		    'register_meta_box_cb' => array($this, 'addMetaBoxes')
	  	);
	}
	
	public function addmetaBoxes(){
		$this->registerMetaBox("formEditorMetabox", Katana::ID);
	}
	
	public function formEditorMetabox($post){
		$this->formDao = new FormDao();				
		$form = $this->formDao->get($post->ID);
		
		// $elementFactory = new ElementFactory();
		// $sampleInputs = $elementFactory->getSampleInputs();
// 		
		// $this->templateValues = new ValueHolder();
		// $this->templateValues->add("sampleInputs", $sampleInputs);												
		// TemplateUtils::fetchTemplate("formEditor", $this->templateValues);
		TemplateUtils::fetchTemplate("formEditor");
	}	
}
