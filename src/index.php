<?php

include_once 'config.php';
use App\Handlers\MustacheHandler;

$sContent = MustacheHandler::i()->render('home/index');

echo MustacheHandler::i()->render('build', ['content' => $sContent]); exit;