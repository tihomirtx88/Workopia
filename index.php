<?php 
require './helpers.php';
require basePath('Router.php');

$router = new Router();

$routes = require basePath('routes.php');

$uri = $_SERVER['REQUEST_URI'];
$method =  $_SERVER['REQUEST_METHOD'];
// inspect($uri);
// inspect($method);
// inspect($router);
// inspect($routes);

$router->route($uri, $method);
// inspect($router);
// var_dump($router->route($uri, $method));







