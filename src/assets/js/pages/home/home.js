'use strict';
(function (window, $, document) {
    $(function () {
        var $page = $('#homepage'),
            $twitterLoginBtn = $('#twitter-login-btn');

        $twitterLoginBtn.on('click', function (e) {
            e.preventDefault();
            TwitterController.login();
        });

    });
}(window, window.jQuery, document));