/**
 * @file
 * Browser's Geolocation wrapper class.
 *
 */

'use strict';

var GeolocationService = (function () {
    return {
        getCoordinates: getCoordinates
    };


    /**
     * get user's coordinates.
     *
     * @param fnCallback
     */
    function getCoordinates() {
        var $deferred = $.Deferred();

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    $deferred.resolve(position.coords);
                },
                function () {
                    $deferred.reject({
                        message: 'Geolocation is not enabled on this browser.'
                    });
                }
            );
        } else {
            $deferred.reject({
                message: 'It seems that your browser/OS doesn\'t support Geolocation yet.'
            });
        }

        return $deferred.promise();
    }
})();