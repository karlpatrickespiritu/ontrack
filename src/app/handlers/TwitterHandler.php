<?php
/**
 * singleton handler for the TwitterOAuth
 *
 * @author karlpatrickespiritu <https://github.com/karlpatrickespiritu>, <wiwa.espiritu@gmail.com>
 */

namespace App\Handlers;

use App\Extensions\Singleton;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterHandler extends Singleton
{
    // twitter API config
    private $_aConfig = [];

    // the twitterOAth instance
    private $_oTwitterOAth = null;

    /**
     * protected constructor so that this class cannot be instantiated.
     *
     * @see     https://dev.twitter.com/web/sign-in/implementing
     * @param   bool    if TwitterOath instance must use oauth_token and oauth_token_secret instead of access token and access token secret
     */
    protected function __construct($bOAuth = false)
    {
        session_start();
        $this->_aConfig = include_once 'app/config/twitter.php';

        $this->_oTwitterOAth = new TwitterOAuth(
            $this->_aConfig['API']['app']['key'],
            $this->_aConfig['API']['app']['secret'],
            $bOAuth ? $_SESSION['oauth_token']: $this->_aConfig['API']['access']['token'],
            $bOAuth ? $_SESSION['oauth_token_secret']: $this->_aConfig['API']['access']['secret']
        );
    }

    /**
     * returns the configuration.
     *
     * @return array
     * */
    public function getConfig()
    {
        return $this->_aConfig;
    }

    /**
     * Executes Twitter's login API via OATH 1.1
     *
     * @see https://dev.twitter.com/web/sign-in/implementing
     * @see https://twitteroauth.com/redirect.php
     * */
    public function login()
    {
        $aRequestToken = $this->getRequestToken();

        // if request token was returned, redirect the user to twitter API login page
        if ($this->_oTwitterOAth->getLastHttpCode() === 200) {

            // TODO create a singleton $_SESSION class or find a library and replace this block of code
            session_start();
            $_SESSION['oauth_token']        = $aRequestToken['oauth_token'];
            $_SESSION['oauth_token_secret'] = $aRequestToken['oauth_token_secret'];

            $sTwitterLoginUrl = $this->_oTwitterOAth->url('oauth/authorize', ['oauth_token' => $aRequestToken['oauth_token']]);
            return header("Location: $sTwitterLoginUrl");
        }

        return false;
    }

    /**
     * obtain a request token.
     *
     * @see     https://dev.twitter.com/web/sign-in/implementing
     * @return  array
     * */
    public function getRequestToken()
    {
        $sCallBackUrl = $this->_aConfig['API']['app']['callback_url'];
        return $this->_oTwitterOAth->oauth('oauth/request_token', ['oauth_callback' => $sCallBackUrl]);
    }

    /**
     *  obtain a access token.
     *
     * @see     https://dev.twitter.com/web/sign-in/implementing
     * @param   string
     * @return  array
     * */
    public function getAccessToken($sOathVerifier)
    {
        if (!empty($sOathVerifier) && is_string($sOathVerifier)) {
            return $this->_oTwitterOAth->oauth('oauth/access_token', ['oauth_verifier' => $sOathVerifier]);
        }

        return false;
    }

    public function getLoggedInUser()
    {
        // TODO check SessionHandler
        return $this->_oTwitterOAth->get("account/verify_credentials");
    }
}