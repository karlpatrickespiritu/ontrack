<?php

include_once 'app/bootstrap.php';

use App\Handlers\MustacheHandler;
use App\Handlers\TwitterHandler;

$oMustache = MustacheHandler::i();
$oTwitter = TwitterHandler::i();

$sContent = $oMustache->render('home/index', [
	'bLoggedIn' => $oTwitter->hasLoggedIn(),
]);

$oMustache->show('build', ['content' => $sContent]);