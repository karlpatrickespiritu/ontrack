(function(controllers, $) {
    "use strict";

    controllers.GmapController = (function() {

        var GmapController = controllers.GmapController,
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
                .fail(function(res) {
                    console.log(res);
                });
        };


        return {
            init: init,
            oUserGeoDefaults: oUserGeoDefaults,
            $map: $map
        }
    })(); // end of controller

}(window.app.controllers = window.app.controllers || {}, jQuery));