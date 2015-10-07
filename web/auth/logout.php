<?php

include_once '../app/bootstrap.php';

use App\Handlers\TwitterHandler;

TwitterHandler::i()->endSession();