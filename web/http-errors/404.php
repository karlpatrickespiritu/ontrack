<?php

include_once '../app/bootstrap.php';

use App\Handlers\MustacheHandler;

$sContent = MustacheHandler::i()->render('http-codes/404');

echo MustacheHandler::i()->render('build', ['content' => $sContent]);