<?php

/**
 * URL utility. Feel free to add functions here.
 *
 * @author karlpatrickespiritu <https://github.com/karlpatrickespiritu>, <wiwa.espiritu@gmail.com>
 */

namespace App\Utils;

class URL
{
    private function __construct() {}

    public static function redirect($sUrl)
    {
        header("Location: $sUrl");
        exit;
    }
}