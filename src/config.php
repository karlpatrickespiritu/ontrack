<?php

ini_set('default_charset', 'utf-8');

// PREVENT XSS
$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

// ERRORS
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('display_errors', 'On');
ini_set('error_log', 'error.log');