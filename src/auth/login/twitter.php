<?php

include_once '../../app/bootstrap.php';

use App\Handlers\TwitterHandler;
use App\Handlers\AppSessionHandler;
use Illuminate\Http\Request;
use App\Utils\URL;

$oRequest = Request::capture();
$sOathToken = $oRequest->input('oauth_token', '');
$sOathVerifier = $oRequest->input('oauth_verifier', '');

if (TwitterHandler::i()->hasLoggedIn()) {
    URL::redirect('/');
} elseif ($sOathToken !== '' && $sOathVerifier !== '') {
    if (TwitterHandler::i()->handleLoginCallback($sOathToken, $sOathVerifier)) {
        URL::redirect('/');
    }
} else {
    TwitterHandler::i()->login();
}