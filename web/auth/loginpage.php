<?php

include_once '../app/bootstrap.php';

use App\Handlers\MustacheHandler;
use App\Handlers\TwitterHandler;
use App\Utils\URL;

if (TwitterHandler::i()->hasLoggedIn()) {
    URL::redirect('/');
}

$sContent = MustacheHandler::i()->render('login/loginform');

MustacheHandler::i()->show('build', ['content' => $sContent]);