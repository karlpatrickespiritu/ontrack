<?php

namespace App\Interfaces;

interface SocialMediaAPIAuth
{
    /**
     * Implement login
     *
     * @return mixed
     **/
    public function login();

    /**
     * End the api session.
     *
     * @return mixed
     **/
    public function endSession();

    /**
     * Check if user has logged in using a social media.
     *
     * @return bool
     */
    public function hasLoggedIn();
}