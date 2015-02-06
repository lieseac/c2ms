<?php
// define paths
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app' );
define('PUBLIC_PATH',  BASE_PATH . '/public' );

            // remove filename from php_self
define('BASE_URL', rtrim($_SERVER['PHP_SELF'], 'index.php'));
define('CURRENT_URL', substr($_SERVER['REQUEST_URI'], strlen(BASE_URL) ) );

// register classloader
require(APP_PATH . '/libraries/ClassLoader.php');
Libraries\ClassLoader::register();

// start session
session_start();

// set time zones
define('UTC_TIME', new DateTimeZone('UTC'));
define('LOCAL_TIME', new DateTimeZone('Europe/Amsterdam'));

include(APP_PATH . '/helpers.php');

// load routes
include(APP_PATH . '/route.php');