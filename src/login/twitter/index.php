<?php

include_once '../../app/bootstrap.php';
use App\Handlers\TwitterHandler;
use Illuminate\Http\Request;

session_start();
$oRequest       = Request::capture();
$sOathToken     = $oRequest->input('oauth_token', '');
$sOathVerifier  = $oRequest->input('oauth_verifier', '');

if ($sOathToken !== '' && $sOathVerifier !== '' && $sOathToken === $_SESSION['oauth_token']) {
    $aAccessToken = TwitterHandler::i(true)->getAccessToken($sOathVerifier);
    $_SESSION['access_token'] = $aAccessToken;
    var_dump($_SESSION['access_token']); exit;
} else {
    TwitterHandler::i()->login();
}