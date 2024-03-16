<?php 
require '../helpers.php';


$routes = [
    '/Workopia/public/' => 'controllers/home.php',
    '/Workopia/controllers/listings' => 'controllers/listings/index.php',
    '/Workopia/controllers/listings/create' => 'controllers/listings/create.php',
    '404' => 'controllers/error/404.php'
];


$uri = $_SERVER['REQUEST_URI'];

// inspect($uri);
// inspect(array_key_exists($uri, $routes));
// inspect(basePath($routes[$uri]));



if(array_key_exists($uri, $routes)){
    require(basePath($routes[$uri]));
}else{
    require basePath($routes['404']);
}
