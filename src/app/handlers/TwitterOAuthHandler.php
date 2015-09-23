<?php
/**
 * sigleton for the TwitterOAuth object
 *
 * @author karlpatrickespiritu <https://github.com/karlpatrickespiritu>, <wiwa.espiritu@gmail.com>
 */

namespace App\Handlers;

use App\Extensions\Singleton;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterOAuthHandler extends Singleton
{
    // twitter API config
    private $_aConfig = [];

    // the twitterOAth instance
    private $_oTwitterOAth = null;

    /**
     * protected constructor so that this class cannot be instantiated.
     */
    protected function __construct()
    {
        $this->_aConfig = include_once 'app/config/twitter.php';

        $this->_oTwitterOAth = new TwitterOAuth(
            $this->_aConfig['API']['app']['key'],
            $this->_aConfig['API']['app']['secret'],
            $this->_aConfig['API']['access']['token'],
            $this->_aConfig['API']['access']['secret']
        );
    }
}