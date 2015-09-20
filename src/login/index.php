<?php

include_once '../config.php';

$oMustache = MustacheHandler::i()->getMustache();

echo $oMustache->render('partials/header');
echo $oMustache->render('home/index');
echo $oMustache->render('partials/footer');