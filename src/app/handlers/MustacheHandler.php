<?php

/**
 * singleton handler for the Mustache
 *
 * @author karlpatrickespiritu <https://github.com/karlpatrickespiritu>, <wiwa.espiritu@gmail.com>
 */

namespace App\Handlers;

use App\Extensions\Singleton;
use Mustache_Autoloader;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

class MustacheHandler extends Singleton
{
    // mustache instance
    private $_oMustache = null;

    // Assets to be loaded by mustache
    private $_aAssets = [
        'js' => [],
        'css' => [],
    ];

    /**
     * protected constructor so that this class cannot be instantiated.
     *
     */
    protected function __construct()
    {
        Mustache_Autoloader::register();
        $this->_oMustache = new Mustache_Engine([
            'loader' => new Mustache_Loader_FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . '/app/views')
        ]);
    }

    /**
     * returns the mustache instance.
     *
     * @return object
     */
    public function getMustache()
    {
        return $this->_oMustache;
    }


    /**
     * mustache's render function
     *
     * @return object
     */
    public function render()
    {
        $aParams = func_get_args();
        return $this->_oMustache->render(@$aParams[0], @$aParams[1]);
    }

    /**
     * add ccs files to mustache template
     *
     * @param    mixed
     * @return    object
     */
    public function addCSS($mCSS)
    {
        if (empty($mCSS) || !$mCSS)
            return false;

        // file path
        if (is_string($mCSS))
            self::_addAssets('css', $mCSS);

        // array of file paths
        if (is_array($mCSS)) {
            foreach ($mCSS as $sCSS) {
                self::_addAssets('css', $sCSS);
            }
        }
    }

    /**
     * return the added files.
     *
     * @return array
     */
    public function getAssets()
    {
        return $this->_aAssets;
    }

    /**
     * add assets.
     *
     * @param    string
     * @param    string
     * @return    void
     */
    private function _addAssets($sFileType, $sFilePath)
    {
        if (
            is_string($sFilePath) &&
            is_string($sFileType) &&
            array_key_exists($sFileType, $this->_aAssets) &&
            !in_array($sFilePath, $this->_aAssets[$sFileType])
        ) {
            $this->_aAssets[$sFileType][] = $sFilePath;
            // TODO:: render files on mustache
        }

        return false;
    }
}