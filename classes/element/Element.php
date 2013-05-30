<?php
namespace classes\element;

use classes\utils\ValueHolder;
use classes\utils\TemplateUtils;
use classes\utils\LanguageUtils;
use \ReflectionObject;

/**
 * Base class of every element, section or input, etc type
 */
abstract class Element{

	protected $id;
	
	protected $name;
	
	protected $page;
	
	protected $template;
		
	private $excludedProperties = array(
		'validator' => true
	);		
	
	public function __construct($inputProperties = null){	
		$this->setProperties($inputProperties);		
	}	
	
	/**
	 * The simple name of an input
	 * e.g: TextInput, CurrencyInput
	 */
	public abstract static function getSimpleName();
	
	
	/**
	 * The class name of the input (namespace included)
	 */
	public abstract static function className();
	
	public abstract function createValidatorInstance();
	
	// TODO rename to ValidateProperties
	public function validate(){
		$validator = $this->createValidatorInstance();
		return $validator->validate($this->getPropertiesList());
	}
				
	public function getName(){
		return $this->name;
	}	
	
	public function getId(){
		return $this->id;
	}
	
	public function getPage(){
		return $this->page;
	}

	public function getTemplate(){
		return $this->template;
	}

	/**
     * Return with the properties of the input
     */
	public function getPropertiesList(){
		$reflectionObject = new ReflectionObject($this);
		$properties = $reflectionObject->getProperties();
		$propertiesList = array();
		foreach($properties as  $property){
			$property->setAccessible(true);
			$propertiesList[$property->name] = $property->getValue($this);				
		}
		return $propertiesList;
	}
	
	protected function setProperties($inputProperties){
		if($inputProperties == null){
			return;
		}
		foreach($inputProperties as $key => $value){
			$this->$key = $value;
		}
	}
	
	public abstract function preRender();		
		
	/**
     * Rendering and sending to the output the template of the input
     */
	public function render(){
		$this->preRender();
		
		$this->templateValues = new ValueHolder();
		$this->templateValues->add("input", $this);
		TemplateUtils::fetchTemplate($this->createTemplatePath(), $this->templateValues);
	}
	
	private function createTemplatePath(){
		return "elements/{$this->getSimpleName()}/{$this->getTemplate()}";
	}
	
	public function toHtml(){
		ob_start();
		$this->render();
		return ob_get_clean();
	}
	
}