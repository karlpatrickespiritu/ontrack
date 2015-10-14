(function(app, $) {
    "use strict";
    
    // single-variable pattern | localize variables
    app.controllers = app.controllers || {};

    app.controllers.GmapController = (function() {

        var GmapController = app.controllers.GmapController, // cached parent
            $map = $('#map'), 	    // the DOM element map
            oUserGeoDefaults = {    // temporary defaults if browser/OS doesn't support geolocation. TODO:: find a way
                iLat: 10.3028159,
                iLng: 123.891343
            };

        /**
         * initialize method
         * @access public
         */
        function init() {
            GeolocationService.getCoordinates()
                .then(function(coords) {
                    if (coords) {
                        // create map with user coordinates as the center.
                        new google.maps.Map(GmapController.$map[0], {
                            center: {lat: coords.latitude, lng: coords.longitude},
                            zoom: 15
                        });
                    } else {
                        // create map with the default coordinates
                        new google.maps.Map(GmapController.$map[0], {
                            center: {lat: oUserGeoDefaults.iLat, lng: oUserGeoDefaults.iLng},
                            zoom: 15
                        });
                    }
                })
                .fail(function(reason) {
                    console.log(reason);
                });
        };


        return {
            init: init,
            oUserGeoDefaults: oUserGeoDefaults,
            $map: $map
        }
    })(); // end of controller

}(window.ontrack = window.ontrack || {}, jQuery));