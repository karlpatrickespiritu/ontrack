<?php

include_once '../../app/bootstrap.php';
use App\Handlers\TwitterHandler;
use Illuminate\Http\Request;

$oRequest       = Request::capture();
$sOathToken     = $oRequest->input('oauth_token', '');
$sOathVerifier  = $oRequest->input('oauth_verifier', '');

if ($sOathToken !== '' && $sOathVerifier !== '') {
	TwitterHandler::i()->handleLoginCallback($sOathToken, $sOathVerifier);
} else {
    TwitterHandler::i()->login();
}