<?php
/**
 * Singleton handler for the TwitterOAuth
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
     * Protected constructor so that this class cannot be instantiated.
     *
     * @see https://dev.twitter.com/web/sign-in/implementing
     **/
    protected function __construct()
    {
        session_start();
        $aConfig = $this->getConfig();

        // default bootstrap initialization for TwitterOath library 
        $this->_oTwitterOAth = new TwitterOAuth(
            $aConfig['API']['app']['key'],
            $aConfig['API']['app']['secret']
        );
    }

    /**
     * Returns our Twitter configuration.
     *
     * @return array
     * */
    public function getConfig()
    {
        return (array) $this->_aConfig = include_once 'app/config/twitter.php';
    }

    /**
     * Redirects the user to Twitter's API login page. 
     *
     * @see https://dev.twitter.com/web/sign-in/implementing
     * @see https://twitteroauth.com/redirect.php
     * */
    public function redirectLogin()
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
     * Obtain a request token.
     *
     * @param   string  the oath_verifier that was returned by twitter after logging in
     * @return  array
     * */
    public function getRequestToken()
    {
        $sCallBackUrl = $this->_aConfig['API']['app']['callback_url'];
        return $this->_oTwitterOAth->oauth('oauth/request_token', ['oauth_callback' => $sCallBackUrl]);
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

        if ($sOathToken || $sOathTokenSecret || !empty($sOathVerifier)) {
            // re-instantiate twitteroath library using the oauth_token & oauth_token_secret
            $this->_oTwitterOAth = new TwitterOAuth(
                $this->_aConfig['API']['app']['key'],
                $this->_aConfig['API']['app']['secret'],
                $sOathToken,
                $sOathTokenSecret
            );

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
            $_SESSION['access_token'] = $aAccessToken;

            // re-instantiate twitteroath library using the oauth_token & oauth_token_secret
            $this->_oTwitterOAth = new TwitterOAuth(
                $this->_aConfig['API']['app']['key'],
                $this->_aConfig['API']['app']['secret'],
                $aAccessToken['oauth_token'],
                $aAccessToken['oauth_token_secret']
            );

            $aUser = $this->_oTwitterOAth->get("account/verify_credentials");
            var_dump($aUser); exit;
        }

        return false;
    }
}