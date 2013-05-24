<?php
namespace classes\utils;
use \ReflectionClass;
use \Exception;
use \ArrayObject;
class ClassLoader{
		
	public function __construct($classPath){
		if(ClassLoader::$instance == null){			
			$this->classPath = $classPath . "/classes/";
			ClassLoader::$instance = $this;
		}else{
			throw new Exception("Classloader already instantiated", 1);
		}
			
	}	
	
	/**
	 * @var ClassLoader
	 */
	private static $instance;	
		
	public $classPath;
	
	public static function getClassPath(){
		return ClassLoader::$instance->classPath;
	}
		
	private static function requireClass($className){
		require_once(ClassLoader::$instance->classPath . $className . ".php");
	}
	
	private static function createInstance($className, $constructorArgs = null, $dependencies = array()){
		$object = null;			
		
		$class = new ReflectionClass($className);		
		$constructor = $class->getConstructor();		
		if($constructor != null && $constructorArgs != null){			
			if(!is_array($constructorArgs)){
				$constructorArgs = array($constructorArgs);
			}			
			$object = $class->newInstanceArgs($constructorArgs);
		}else{
			$object = $class->newInstance();
		}
		
		if(!empty($dependencies)){
			ClassLoader::setObjectDepencies($object, $dependencies);
		}
		return $object;
	}
	
	private static function setObjectDepencies($object, $depencies){
		// TODO use reflection
		foreach($depencies as $propertyName => $propertyValue){
			$setterName = "set" . $propertyName;
			$object->$setterName = $propertyValue;
		}
	}
		
	public static function getClassInstance($className, $constructorArgs = null){
		ClassLoader::requireClass($className);
		if(strpos($className, "/") !== false){
			$classNameStartPos = strrpos($className, "/")+1;
			$className = substr($className, $classNameStartPos);
		}
		$instance = ClassLoader::createInstance($className, $constructorArgs);
		return $instance;
	}
	
	public static function getCustomPostTypeInstance($daoClassName){
		ClassLoader::requireClass("posttype/CustomPostType");
		ClassLoader::requireClass("posttype/" . $daoClassName);
		$postType = ClassLoader::createInstance($daoClassName);
		return $postType;
	}
	
	public static function getUtilsInstance($className){
		ClassLoader::requireClass("utils/" . $className);
		$utilClass = ClassLoader::createInstance($className);
		return $utilClass;
	}
	
	public static function getAjaxControllerInstance($className){
		ClassLoader::requireClass("ajaxcontroller/AjaxController");	
		ClassLoader::requireClass("ajaxcontroller/" . $className);
		return ClassLoader::createInstance($className);
	}	
			
	public static function getDaoInstance($daoClassName){
		global $wpdb;
		ClassLoader::requireClass("dao/Dao");
		ClassLoader::requireClass("dao/" . $daoClassName);
		$dao = ClassLoader::createInstance($daoClassName);
		$dao->setDb($wpdb);
		return $dao;
	}
	
	public static function getValueHolderInstance(){
		throw new Exception("ValueHolder deprecated!", 1);		
		ClassLoader::requireClass("utils/ValueHolder");
		return ClassLoader::createInstance("ValueHolder");
	}
		
	public static function requireInputType($inputType){
		ClassLoader::requireClass("element/input/" . $inputType);
	}
	
	public static function getInputInstance($inputType, $inputPropertiesHolder){			
		ClassLoader::requireInputType($inputType);
		return ClassLoader::createInstance($inputType, array($inputPropertiesHolder));
	}
	
	public static function getInputValidatorInstance($inputType){
		$validatorClassName = $inputType . "Validator";
		ClassLoader::requireInputValidator($validatorClassName);
		return ClassLoader::createInstance($validatorClassName);
	}
	
	private static function requireInputValidator($validatorClassName){
		ClassLoader::requireClass("element/validator/" . $validatorClassName);
	}
			
			
}
