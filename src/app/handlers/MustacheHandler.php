<?php

/**
* sigleton for the Mustache object
*
* @author karlpatrickespiritu <https://github.com/karlpatrickespiritu>, <wiwa.espiritu@gmail.com>
*/

class MustacheHandler
{

	// self instance
	private static $_oInstance 	= null;

	// mustache instance
	private static $_oMustache 	= null;

	// mustache options
	public static $aMustacheOptions = [];

	// CSS files
	private static $_aFiles = [
		'js' => [],
		'css' => [],
	];

	/**
	* constructor
	*
	*/
	protected function __construct() 
	{		
		Mustache_Autoloader::register();

		self::$_oMustache = new Mustache_Engine([
			'loader' => new Mustache_Loader_FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . '/templates')
		]);
	}

	/**
	* prevent users to clone the instance
	*
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


	/**
	* mustache's render function
	*
	* @return object
	*/
	public function render () 
	{
		$aParams = func_get_args();
		return self::$_oMustache->render(@$aParams[0], @$aParams[1]);
	}

	/**
	* add CSS files to build template
	*
	* @param 	mixed
	* @return 	object
	*/
	public function addCSS ($mCSS) 
	{
		if (empty($mCSS) || !$mCSS)
			return false;

		if (is_string($mCSS))
			self::_addFile('css', $mCSS);

		if (is_array($mCSS)) {
			foreach ($mCSS as $sCSS) {
				self::_addFile('css', $sCSS);
			}
		}
	}

	/**
	* return the added files.
	*
	* @return array
	*/
	public function getFiles () 
	{
		return self::$_aFiles;
	}

	/**
	* add files.
	*
	* @param 	string
	* @param 	string
	* @return 	void
	*/
	private function _addFile ($sFileType, $sFilePath) 
	{
		if (
			is_string($sFilePath) || 
			is_string($sFileType) || 
			array_key_exists($sFileType, self::$_aFiles) ||
			!in_array($sFilePath, self::$_aFiles[$sFileType])
		) {
			self::$_aFiles[$sFileType][] = $sFilePath;
			// TODO:: render files on mustache
		}

		return false;
	}
}