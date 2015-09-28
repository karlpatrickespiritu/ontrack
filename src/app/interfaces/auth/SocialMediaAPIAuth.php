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
     * implement logout
     *
     * @return mixed
     **/
	public function logout();
}