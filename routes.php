<?php 


// $router->get('/Workopia/', 'controllers/home.php');
// $router->get('/Workopia/listings', 'controllers/listings.php');
// $router->get('/Workopia/create', 'controllers/create.php');
// $router->get('/Workopia/listing', 'controllers/show.php');

//Home page
$router->get('/Workopia/public', 'HomeController@index');
// All listings page
$router->get('/Workopia/public/listings', 'ListingController@index');
// Path to create form
$router->get('/Workopia/public/create', 'ListingController@create');
//details listing
$router->get('/Workopia/public/listing', 'ListingController@show');
// // Path to edit form
$router->get('/Workopia/public/edit', 'ListingController@edit');
$router->put('/Workopia/public/edit', 'ListingController@update');
//Delete listing 
$router->delete('/Workopia/public/listing', 'ListingController@destroy');
// Create listing
$router->post('/Workopia/public/listings', 'ListingController@store');

$router->get('/Workopia/public/auth/login', 'UserController@login');
$router->get('/Workopia/public/auth/register', 'UserController@create');

