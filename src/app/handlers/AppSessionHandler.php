<?php

/**
 * This is just a very simple wrapper for PHP's Session.
 *
 * TODO: Implement appropriate security measures to prevent
 * session hijacking. Or just implement a PHP session library :)
 *
 * @author karlpatrickespiritu <https://github.com/karlpatrickespiritu>, <wiwa.espiritu@gmail.com>
 */

namespace App\Handlers;

use App\Extensions\Singleton;
use App\Utils\Security;

class AppSessionHandler extends Singleton
{
    public $_bLoggedIn = false;

    protected function __construct()
    {
        session_start();
    }

    public function stop()
    {
        session_unset();
        session_destroy();
        session_register_shutdown();
    }

    /**
     * TODO: start user session
     */
    public function start()
    {
    }

    public function set($sKey, $mValue)
    {
        return $_SESSION[$sKey] = $mValue;
    }

    public function get($sKey)
    {
        return $_SESSION[$sKey];
    }

    public function remove($sKey)
    {
        return $_SESSION[$sKey];
    }
}