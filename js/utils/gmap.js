var gmap = (function () {
	'use strict';
	
	var	$map  = $('#map'), // the DOM element map
	 	oMap  = undefined, // the google map object

		// temporary defaults if browser/OS doesn't support geolocation
		oUserGeo	= {
			iLat: 10.3028159,
			iLng: 123.891343
		};

	/*
	* initialize method
	* @access public
	**/
	var init = function () {

		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(
			  function (position) {
			    oUserGeo.iLat = position.coords.latitude;
			    oUserGeo.iLng = position.coords.longitude;
			  },
			  function () {
			    console.log('Geolocation is not enabled on this browser.');
			  }
			);
		} else {
			console.log('It seems that your browser/OS doesn\'t support Geolocation yet.');
		}

		// create map
		this.oMap = new google.maps.Map(this.$map[0], {
		    center: {lat: oUserGeo.iLat, lng: oUserGeo.iLng},
		    zoom: 15
		  });
	};


	return {
	  init: init,
	  oMap: oMap,
	  oUserGeo: oUserGeo,
	  $map: $map
	}

})();