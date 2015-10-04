<?php

include_once '../../../app/bootstrap.php';

use App\Handlers\TwitterHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

$oRequest = Request::capture();
$oResponse = new Response();

$oParams = $oRequest->input('oParams', []);

echo json_encode($oResponse); exit;