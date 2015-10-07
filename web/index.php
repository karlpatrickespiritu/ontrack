<?php

include_once 'app/bootstrap.php';

use App\Handlers\MustacheHandler;
use App\Handlers\TwitterHandler;
use App\Utils\URL;

if (!TwitterHandler::i()->hasLoggedIn()) {
    URL::redirect('/login');
}

$sContent = MustacheHandler::i()->render('home/index', [
	'bLoggedIn' => TwitterHandler::i()->hasLoggedIn(),
]);

MustacheHandler::i()->show('build', ['content' => $sContent]);