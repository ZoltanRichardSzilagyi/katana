<?php
namespace classes\element\section;
use classes\element\Element;
class FormPager extends Element{
	
	public static function getSimpleName(){
		return "FormPager";
	} 	
	
	private $prevButton;
	
	private $nextButton;
		
}