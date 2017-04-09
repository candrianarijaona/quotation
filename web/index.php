<?php

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

if (file_exists(dirname(__DIR__) . '/.env')) {
    $dotenv = new \Dotenv\Dotenv(dirname(__DIR__));
    $dotenv->overload();
}

// Instantiate the app
$settings = require __DIR__ . '/../app/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register middleware
require __DIR__ . '/../app/middleware.php';

// Register routes
require __DIR__ . '/../app/routes.php';

// Register the database connection with Eloquent
$capsule = $app->getContainer()->get('db');
$capsule->bootEloquent();

// Run!
$app->run();
