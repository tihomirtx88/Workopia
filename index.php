<?php 
require __DIR__ . './vendor/autoload.php';
require './helpers.php';

// Import Router class
// require basePath('Framework/Router.php');

// Database connection
// require basePath('Framework/Database.php');

use Framework\Database;
use Framework\Router;

// Create instance of router 
$router = new Router();

// Import routes 
$routes = require basePath('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method =  $_SERVER['REQUEST_METHOD'];
// inspect($uri);

// Connect router with routes
$router->route($uri, $method);








