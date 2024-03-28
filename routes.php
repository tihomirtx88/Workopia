<?php 


// $router->get('/Workopia/', 'controllers/home.php');
// $router->get('/Workopia/listings', 'controllers/listings.php');
// $router->get('/Workopia/create', 'controllers/create.php');
// $router->get('/Workopia/listing', 'controllers/show.php');

$router->get('/Workopia/', 'HomeController@index');
$router->get('/Workopia/listings', 'ListingController@index');
$router->get('/Workopia/create', 'ListingController@create');
$router->get('/Workopia/listing', 'ListingController@show');
$router->post('/Workopia/listings', 'ListingController@store');