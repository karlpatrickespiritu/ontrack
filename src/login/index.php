<?php

include_once '../config.php';

$oMustache = MustacheHandler::i()->getMustache();
$sContent  = $oMustache->render('login/index');

echo $oMustache->render('build', ['content' => $sContent]);