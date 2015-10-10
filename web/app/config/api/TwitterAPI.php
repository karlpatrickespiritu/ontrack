<?php

/**
 * Twitter configuration constants.
 * TODO: transfer these sensitive files to AWS using heroku.
 *
 * @author karlpatrickespiritu <https://github.com/karlpatrickespiritu>, <wiwa.espiritu@gmail.com>
 */

namespace App\Config\Api;

class TwitterAPI
{
    const KEY = 'qziqppX1DevJ5BtYYFTrBAcdR';
    const SECRET = 'NU1YDQhju3STuOjAGey51ToIGWuddNmGAmlxwbUlP287tsACBk';

    const OWNER = 'espiritu_karl';
    const OWNER_ID = '1570030916';
    const CALLBACK_URL = 'http://ontrack.com/login/twitter';

    const ACCESS_TOKEN = '1570030916-Rau5BIZQG6VcNkngrl74ecWynehfa2tFPFjwiZz';
    const ACCESS_TOKEN_SECRET = 'jy8BDJ7iz0qjL6OhCz9CyR6JEEV2GDiFzWf4FEJ8icjosj';

    /**
     * no instance allowed.
     **/
    private function __construct()
    {
    }
}