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

	    this.oFb.getLoginStatus(function(response) {
	    	fb.checkLoginResponse(response);
		});
	}

	/*
	* check login user info
	* @access public
	**/
	function checkLoginResponse (oLoginStatusResponse) {
		if (oLoginStatusResponse.status === "connected") {
			this.oFb.api('/me', function(response) {
				console.log(response);
		    });
		} else {
			console.log('facebook account not logged in');
		}
	}	

	/*
	* login method
	* @access public
	**/
	function login () {
		this.oFb.login(function (response) {
			this.checkLoginResponse(response);
		});
	}

	return { 
	  init: init,
	  checkLoginResponse: checkLoginResponse,
	  login: login,
	  oFb: oFb
	}

})();