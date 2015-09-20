<?php

/**
* a sigleton approach for the Mustache object
*/
class MustacheHandler
{

	// mustache instance
	private static $_oMustache 	= null;
	
	protected function __construct() {} // non instantiable

	/**
	* creates a mustache object.
	*
	* @return object
	*/
	public static function i() 
	{		
		if (!(self::$_oMustache instanceof Mustache_Engine)) {
			Mustache_Autoloader::register();
			self::$_oMustache 	= new Mustache_Engine;
		}

		return self::$_oMustache;
	}	
}