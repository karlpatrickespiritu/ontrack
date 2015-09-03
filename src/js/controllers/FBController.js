'use strict';

var FBController = (function () {

	/*
	* initialize method
	* @access public
	**/
	function init () {
        FB.init({
	    	appId: FBConfig.iAppId,
	      	xfbml: FBConfig.bXfbml,
	      	version: FBConfig.sVersion,
	      	cookie: FBConfig.bCookie
	      });

        return FBController.checkLoginStatus();
	}

	/*
	* check login user info
	* @access public
	**/
	function checkLoginStatus () {
        return FB.getLoginStatus(function(response) {
            if (response.status === "connected") {
                FB.api('/me', {fields: 'posts', access_token: FBConfig.sToken}, function(response) {
                    console.log(response);
                });
            } else {
                console.log('facebook account not logged in');
            }
        });
	}	

	/*
	* login method
	* @access public
	**/
	function login () {
        return FB.login(function () {
            fb.checkLoginStatus();
		}, {
            scope: 'public_profile, user_friends, email, read_custom_friendlists, user_birthday',
            return_scopes: true
        });
	}

	return { 
	  init: init,
      checkLoginStatus: checkLoginStatus,
	  login: login
	}
	
})();