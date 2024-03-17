<?php 

$config = require basePath('config/db.php');
$db = new Database($config);

$listings = $db->query('SELECT * FROM listings LIMIT 4')->fetchAll();

inspect($listings);

loadView('home');