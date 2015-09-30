<?php

/**
 * Singleton handler for the TwitterOAuth
 *
 * @author karlpatrickespiritu <https://github.com/karlpatrickespiritu>, <wiwa.espiritu@gmail.com>
 **/

namespace App\Handlers;

use App\Handlers\AppSessionHandler;
use App\Utils\URL;
use App\Extensions\Singleton;
use App\Interfaces\SocialMediaAPIAuth;
use App\Config\Api\TwitterAPI;
use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\App;

class TwitterHandler extends Singleton implements SocialMediaAPIAuth
{

    /**
     * the twitterOAth instance
     * @var TwitterOAuth|null
     */
    private $_oTwitterOAth = null;

    /**
     * types of twitteroauth initialization.
     * @var int
     */
    const OAUTH_BASIC = 0;
    const OAUTH_VERIFIED = 1;
    const OAUTH_VERIFIER = 2;
    const OAUTH_VERIFIER_CONVERTED = 3;

    /**
     * Protected constructor so that this class cannot be instantiated.
     *
     * @see https://dev.twitter.com/web/sign-in/implementing
     */
    protected function __construct()
    {
        if ($this->getLoggedInAccessToken()) {
            $this->_initializeTwitterOauth(self::OAUTH_VERIFIED);
        } else {
            $this->_initializeTwitterOauth(self::OAUTH_BASIC);
        }
    }

    /**
     * Initialize TwitterOauth depending is the user is logged in or not.
     *
     * @param   int  $sOathType the type of initizalization of TwitterOath
     * @return  bool
     */
    private function _initializeTwitterOauth($sOathType = self::OAUTH_BASIC)
    {
        if ($sOathType == self::OAUTH_BASIC) {
            $this->_oTwitterOAth = new TwitterOAuth(TwitterAPI::KEY, TwitterAPI::SECRET);
        } elseif ($sOathType == self::OAUTH_VERIFIED) {
            $aAccessToken = $this->getLoggedInAccessToken();
            $this->_oTwitterOAth = new TwitterOAuth(TwitterAPI::KEY, TwitterAPI::SECRET, $aAccessToken['oauth_token'], $aAccessToken['oauth_token_secret']);
        } elseif ($sOathType == self::OAUTH_VERIFIER) {
            $sOathToken = AppSessionHandler::i()->get('oauth_token');
            $sOathTokenSecret = AppSessionHandler::i()->get('oauth_token_secret');
            $this->_oTwitterOAth = new TwitterOAuth(TwitterAPI::KEY, TwitterAPI::SECRET, $sOathToken, $sOathTokenSecret);
        } elseif ($sOathType == self::OAUTH_VERIFIER_CONVERTED) {
            $sOathVerifier = AppSessionHandler::i()->get('oauth_verifier');
            $aAccessToken = $this->getAccessToken($sOathVerifier);
            if (isset($aAccessToken['oauth_token']) && isset($aAccessToken['oauth_token_secret'])) {
                $this->_oTwitterOAth = new TwitterOAuth(TwitterAPI::KEY, TwitterAPI::SECRET, $aAccessToken['oauth_token'], $aAccessToken['oauth_token_secret']);
            }
        }

        $this->_oTwitterOAth->setTimeouts(10, 15);

        return $this->_oTwitterOAth instanceof TwitterOAuth;
    }

    /**
     * Redirects the user to Twitter's API login page.
     *
     * @see https://dev.twitter.com/web/sign-in/implementing
     * @see https://twitteroauth.com/redirect.php
     */
    public function login()
    {
        $aRequestToken = $this->getRequestToken();
        if ($aRequestToken) {
            $sTwitterLoginUrl = $this->_oTwitterOAth->url('oauth/authorize', ['oauth_token' => $aRequestToken['oauth_token']]);
            URL::redirect($sTwitterLoginUrl);
        }

        return false;
    }

    /**
     * End the api session.
     *
     * @param   string  $sUrlRedirect where the page would redirect after ending the session
     * @return  void
     */
    public function endSession($sUrlRedirect = '/')
    {
        AppSessionHandler::i()->remove('oauth_token');
        AppSessionHandler::i()->remove('oauth_token_secret');
        AppSessionHandler::i()->remove('oauth_verifier');
        AppSessionHandler::i()->remove('access_token');
        URL::redirect($sUrlRedirect);
    }

    /**
     * Obtain a request token.
     *
     * @param   string  the oath_verifier that was returned by twitter after logging in
     * @return  mixed
     * */
    public function getRequestToken()
    {
        $aRequestToken = $this->_oTwitterOAth->oauth('oauth/request_token', ['oauth_callback' => TwitterAPI::CALLBACK_URL]);

        if ($this->_oTwitterOAth->getLastHttpCode() === 200) {
            AppSessionHandler::i()->set('oauth_token', $aRequestToken['oauth_token']);
            AppSessionHandler::i()->set('oauth_token_secret', $aRequestToken['oauth_token_secret']);

            return $aRequestToken;
        }

        return false;
    }

    /**
     * Obtain an access token (before logging in to twitter access token).
     *
     * @see     https://dev.twitter.com/web/sign-in/implementing
     * @param   string
     * @return  mixed
     */
    public function getAccessToken($sOathVerifier)
    {
        if ($sOathVerifier) {
            $this->_initializeTwitterOauth(self::OAUTH_VERIFIER);

            $aAccessToken = $this->_oTwitterOAth->oauth('oauth/access_token', ['oauth_verifier' => $sOathVerifier]);
            if ($this->_oTwitterOAth->getLastHttpCode() === 200) {
                AppSessionHandler::i()->set('access_token', $aAccessToken);
                return $aAccessToken;
            }
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
     * @param   string  the oath_token that was returned by twitter after logging in
     * @param   string  the oath_verifier that was returned by twitter after logging in
     * @return  bool
     */
    public function handleLoginCallback($sOathToken, $sOathVerifier)
    {
        if (!empty($sOathVerifier) && !empty($sOathToken) && ($sOathToken === AppSessionHandler::i()->get('oauth_token'))) {
            AppSessionHandler::i()->set('oauth_verifier', $sOathVerifier);
            return $this->_initializeTwitterOauth(self::OAUTH_VERIFIER_CONVERTED);
        }

        return false;
    }

    /**
     * Checks if user has already logged in using Twitter.
     *
     * @return bool
     */
    public function hasLoggedIn()
    {
        return (bool) AppSessionHandler::i()->get('access_token');
    }

    /**
     * Returns the access token used for accessing logged in user's API.
     *
     * @return mixed
     */
    public function getLoggedInAccessToken()
    {
        return AppSessionHandler::i()->get('access_token');
    }

    /**
     * get logged in user basic data
     *
     * @param   string
     * @return  array
     */
    public function getUserBasicData()
    {
        $statuses = $this->_oTwitterOAth->get("statuses/home_timeline", array("count" => 25, "exclude_replies" => true));
        d($statuses); exit;
        $aUser = $this->_oTwitterOAth->get("account/verify_credentials");
        if ($this->_oTwitterOAth->getLastHttpCode() === 200) {
            return $aUser;
        }

        return false;
    }
}