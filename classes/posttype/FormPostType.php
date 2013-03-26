<?php
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
		$this->registerMetaBox("formEditorMetabox", "Katana");
	}
	
	public function formEditorMetabox($post){
		$this->formDao = ClassLoader::getDaoInstance("FormDao");
		$this->templateValues = ClassLoader::getValueHolderInstance();
		
		$form = $this->formDao->get($post->ID);
		
		$inputFactory = ClassLoader::getUtilsInstance("InputFactory");
		$sampleInputs = $inputFactory->getSampleInputs();
		$this->templateValues->add("sampleInputs", $sampleInputs);
		
		TemplateUtils::attachStyle("formEditorAdmin", "formEditorAdmin");
		$this->attachScripts();		
		TemplateUtils::fetchTemplate("formEditor", $this->templateValues);				

	}
	
	private function attachScripts(){
		TemplateUtils::attachScript("jquery-ui", "jquery-ui/js/jquery-ui-1.10.0.custom", array('jquery'));	
		TemplateUtils::attachScript("formEditor", "formEditor/formEditor", array('jquery', 'jquery-ui'));			
		TemplateUtils::attachScript("accounting", "accounting/accounting", array('jquery', 'formEditor'));
		TemplateUtils::attachStyle("jquery-ui", "ui/jquery-ui-1.10.0.custom.min");
						
	}
	
}
