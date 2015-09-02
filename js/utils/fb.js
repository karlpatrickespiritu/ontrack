var fb = (function () {
	'use strict';

	// declare private properties here..
	var _oFbCredentials = {
		iAppId: '523864777765137',
		bXfbml: true,
		bCookie: true,
		sVersion: 'v2.4'
	};

	// declare public propeties here..
	var oFb = null;

	/*
	* initialize method
	* @access public
	**/
	function init () {
		this.oFb = FB;
	    this.oFb.init({
	    	appId: _oFbCredentials.iAppId,
	      	xfbml: _oFbCredentials.bXfbml,
	      	version: _oFbCredentials.sVersion,
	      	cookie: _oFbCredentials.bCookie
	      });

        this.checkLoginStatus();
	}

	/*
	* check login user info
	* @access public
	**/
	function checkLoginStatus () {
        this.oFb.getLoginStatus(function(response) {
            if (response.status === "connected") {
                fb.oFb.api('/me', {fields: 'friends'}, function(response) {
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
		this.oFb.login(function () {
            fb.checkLoginStatus();
		}, {
            scope: 'public_profile, user_friends, email, read_custom_friendlists',
            return_scopes: true
        });
	}

	return { 
	  init: init,
      checkLoginStatus: checkLoginStatus,
	  login: login,
	  oFb: oFb
	}

})();