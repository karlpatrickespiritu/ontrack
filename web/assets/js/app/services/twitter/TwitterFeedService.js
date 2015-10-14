'use strict';

var TwitterFeedService = (function () {
    return {
        getFeed: getFeed
    };

    function getFeed(oParams) {
    	var oParams = oParams || {},
    		$deferred = $.Deferred();

    	$.getJSON('/app/services/twitter/getFeed.php', oParams)
    	 .done(function(response) {
    	 	$deferred.resolve(response);
    	 });

    	 return $deferred.promise();
    }
})();