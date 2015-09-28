<?php

namespace App\Interfaces;

interface SocialMediaAPIAuth
{
    /**
     * implement login
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
}