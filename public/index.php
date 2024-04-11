<?php 
require __DIR__ . './../vendor/autoload.php';

// Import Router class
// require basePath('Framework/Router.php');

// Database connection
// require basePath('Framework/Database.php');

use Framework\Router;
use Framework\Session;

Session::start();

require './../helpers.php';

// Create instance of router 
$router = new Router();

// Import routes 
$routes = require basePath('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Connect router with routes
$router->route($uri);








