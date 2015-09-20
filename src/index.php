<?php

include_once 'config.php';

$sContent = MustacheHandler::i()->render('home/index');

echo MustacheHandler::i()->render('build', ['content' => $sContent]); exit;