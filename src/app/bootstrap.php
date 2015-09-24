<?php

// set include path depending on the OS
if (strpos(PHP_OS, 'WIN') !== false) {
    // WINDOWS
    ini_set('include_path', '.;' . $_SERVER["DOCUMENT_ROOT"] . ';.;' . $_SERVER["DOCUMENT_ROOT"] . '/app/;');
} else {
    // UNIX
    ini_set('include_path', '.:' . $_SERVER["DOCUMENT_ROOT"] . ':' . $_SERVER["DOCUMENT_ROOT"] . 'app/');
}

ini_set('default_charset', 'utf-8');

// ERRORS
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('display_errors', 'On');
ini_set('error_log', 'error.log');

// autoloaders
include_once 'app/vendor/autoload.php';
include_once 'app/vendor/abraham/twitteroath/autoload.php';