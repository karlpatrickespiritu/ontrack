var fb = (function () {
	'use strict';

	// declare private properties here..
	var _oFbCredentials = {
        /*// live: ontrack
		iAppId: '523864777765137',
        sSecret: 'ef9bdcc0095f35cc06f7dfeb4d0ff1f4',*/

        // dev: ontrack - Test1
		iAppId: '525036400981308',
		sSecret: '98e4e490a11b0262f22101714bc52c8b',

        // access token - dev
        sToken: 'CAACEdEose0cBAM3GF7s18Y20JwWggV6vVDTQCJLMAqYDJyMqS4xMUX2Glv4Ebn0cBD8Pp8UmSZBr7yPJpqZCwo1Mdksyn5LUQ9fUhtDWu6HUu0RgQAL5HFi27vlkTrdUp5uyYnPk5SnCfQUGR4Sq2CmYpe740rjWI6JHSdZBUvvLb9NG75wX0MQ94HsD1JauWXXihKyFgZDZD',

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
                fb.oFb.api('/me', {fields: 'posts', access_token: _oFbCredentials.sToken}, function(response) {
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
            scope: 'public_profile, user_friends, email, read_custom_friendlists, user_birthday',
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