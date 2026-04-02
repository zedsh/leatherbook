<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$logData = [
    'time'    => date('Y-m-d H:i:s'),
    'method'  => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
    'uri'     => $_SERVER['REQUEST_URI'] ?? '/',
    'get'     => $_GET,
    'post'    => $_POST,
    'body'    => file_get_contents('php://input'),
    'headers' => getallheaders() ?: [],
    'cookies' => $_COOKIE,
];
file_put_contents(__DIR__ . '/test.txt', json_encode($logData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n---\n", FILE_APPEND);

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
