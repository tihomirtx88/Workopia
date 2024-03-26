<?php 

$config = require basePath('config/db.php');
$db = new Database($config);

$listings = $db->query('SELECT * FROM listings LIMIT 4')->fetchAll();

loadView('listings/index', [
    'listings'=> $listings
]);

// require basePath('views/listings/index.php');