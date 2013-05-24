
<?php
/**
 * @package Katana
 * @version 1.0
 */
/*
Plugin Name: Katana
Plugin URI: n/a
Description: Katana - Form editor plugin. 
Author: Zoltán Szilágyi
Version: 1.0
Author URI: n/a
*/
use classes\Katana;
require_once(dirname(__FILE__) . "/classes/Katana.php");
new Katana(dirname(__FILE__));
