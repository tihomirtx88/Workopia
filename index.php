<?php 
require './helpers.php';

// Import Router class
require basePath('Router.php');

// Database connection
require basePath('Database.php');

// Create instance of router 
$router = new Router();

// Import routes 
$routes = require basePath('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method =  $_SERVER['REQUEST_METHOD'];
// inspect($uri);

// Connect router with routes
$router->route($uri, $method);








