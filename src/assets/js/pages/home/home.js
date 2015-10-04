'use strict';
(function (window, $, document) {
    $(function () {
        var $page = $('#homepage'),
        	oFeeds = {};

        TwitterFeedService
        	.getFeed()
        	.then(function(response) {
        		oFeeds = response;
        		console.log(oFeeds);
        	});

    });
}(window, window.jQuery, document));