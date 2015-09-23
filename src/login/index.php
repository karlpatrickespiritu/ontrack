<?php

include_once '../app/bootstrap.php';
use App\Handlers\MustacheHandler;
use App\Handlers\TwitterOAuthHandler;

$sContent = MustacheHandler::i()->render('login/index');

echo MustacheHandler::i()->render('build', ['content' => $sContent]);