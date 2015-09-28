<?php

/**
 * Singleton handler for the TwitterOAuth
 *
 * @author karlpatrickespiritu <https://github.com/karlpatrickespiritu>, <wiwa.espiritu@gmail.com>
 **/

namespace App\Handlers;

use App\Extensions\Singleton;
use App\Interfaces\SocialMediaAPIAuth;
use App\Config\Api\TwitterAPI;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterHandler extends Singleton implements SocialMediaAPIAuth
{

    // the twitterOAth instance
    private $_oTwitterOAth = null;

    /**
     * Protected constructor so that this class cannot be instantiated.
     *
     * @see https://dev.twitter.com/web/sign-in/implementing
     **/
    protected function __construct()
    {
        session_start();
        $this->_oTwitterOAth = new TwitterOAuth(TwitterAPI::KEY, TwitterAPI::SECRET);
    }

    /**
     * Redirects the user to Twitter's API login page. 
     *
     * @see https://dev.twitter.com/web/sign-in/implementing
     * @see https://twitteroauth.com/redirect.php
     * */
    public function login()
    {
        // TODO: create a singleton $_SESSION class or find a library.
        session_start();

        $aRequestToken    = $this->getRequestToken();
        $sOathToken       = (isset($aRequestToken['oauth_token'])) ? $_SESSION['oauth_token'] = $aRequestToken['oauth_token']: '';
        $sOathTokenSecret = (isset($aRequestToken['oauth_token_secret'])) ? $_SESSION['oauth_token_secret'] = $aRequestToken['oauth_token_secret']: '';

        if ($sOathToken && $sOathTokenSecret) {
            $sTwitterLoginUrl = $this->_oTwitterOAth->url('oauth/authorize', ['oauth_token' => $sOathToken]);
            return header("Location: $sTwitterLoginUrl");
        }

        return false;
    }

    /**
     * End the api session.
     *
     * @return mixed
     * */
    public function endSession() {}

    /**
     * Obtain a request token.
     *
     * @param   string  the oath_verifier that was returned by twitter after logging in
     * @return  array
     * */
    public function getRequestToken()
    {
        return $this->_oTwitterOAth->oauth('oauth/request_token', ['oauth_callback' => TwitterAPI::CALLBACK_URL]);
    }

    /**
     * Obtain a access token.
     *
     * @see     https://dev.twitter.com/web/sign-in/implementing
     * @param   string  
     * @return  array
     * */
    public function getAccessToken($sOathVerifier)
    {
        session_start();
        $sOathToken       = (isset($_SESSION['oauth_token'])) ? $_SESSION['oauth_token']: '';
        $sOathTokenSecret = (isset($_SESSION['oauth_token_secret'])) ? $_SESSION['oauth_token_secret']: '';

        if (!empty($sOathVerifier) || $sOathToken || $sOathTokenSecret) {
            $this->_oTwitterOAth = new TwitterOAuth(TwitterAPI::KEY, TwitterAPI::SECRET, $sOathToken, $sOathTokenSecret);

            return $this->_oTwitterOAth->oauth('oauth/access_token', ['oauth_verifier' => $sOathVerifier]);
        }

        return false;
    }

    /**
     * After user has successfully logged in to Twitter, Twitter returns to our `oath_callback` url with 
     * some `$_GET` params including an `oath_verifier` which will be used to get the access_token later.
     * This function handles that Twitter return and sets the users's session on the app. If this function
     * runs successfully, we are now authorized to get the user's Twitter data.
     *
     * @see     https://dev.twitter.com/web/sign-in/implementing
     * @param   string  the oath_verifier that was returned by twitter after logging in
     * @return  mixed
     * */
    public function handleLoginCallback($sOathToken, $sOathVerifier)
    {
        if (!empty($sOathVerifier) && !empty($sOathToken) && $sOathToken === $_SESSION['oauth_token']) {
            $aAccessToken = $this->getAccessToken($sOathVerifier);
            if (isset($aAccessToken['oauth_token']) && isset($aAccessToken['oauth_token_secret'])) {
                $_SESSION['access_token'] = $aAccessToken;

                $this->_oTwitterOAth = new TwitterOAuth(TwitterAPI::KEY, TwitterAPI::SECRET, $aAccessToken['oauth_token'], $aAccessToken['oauth_token_secret']);

                // GOTO home :)
                var_dump($this->getUserBasicData()); exit;
            }
        }

        return false;
    }

    /**
     * get logged in user basic data
     *
     * @param   string  
     * @return  array
     * */
    public function getUserBasicData()
    {
        $aUser = $this->_oTwitterOAth->get("account/verify_credentials");
        if ($this->_oTwitterOAth->getLastHttpCode() === 200) {
            return $aUser;
        }

        return false;
    }
}