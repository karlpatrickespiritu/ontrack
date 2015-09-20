<?php

/**
* a sigleton approach for the Mustache object
*
* @author karlpatrickespiritu <wiwa.espiritu@gmail.com>, <https://github.com/karlpatrickespiritu>
*/
class MustacheHandler
{

	// self instance
	private static $_oInstance 	= null;

	// mustache instance
	private static $_oMustache 	= null;
	
	/**
	* constructor
	*
	* @return void
	*/
	protected function __construct() 
	{		
		include_once 'app/libs/vendor/mustache/mustache/src/Mustache/AutoLoader.php';
		Mustache_Autoloader::register();

		self::$_oMustache = new Mustache_Engine([
			'loader' => new Mustache_Loader_FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . '/templates')
		]);
	}

	/**
	* prevent users to clone the instance
	*
	* @return void
	*/
    public function __clone()
    {
        throw new Exception('Only one instance is allowed.');
    }

	/**
	* create singleton instance.
	*
	* @return object
	*/
	public static function i()
	{
		if (!(self::$_oInstance instanceof self)) {
			self::$_oInstance = new self;
		}

		return self::$_oInstance;
	}

	/**
	* returns the mustache instance.
	*
	* @return object
	*/
	public function getMustache () 
	{
		return self::$_oMustache;	
	}
}