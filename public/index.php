<?php
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Controllers/ContactController.php';

$router = new Router();

// Definišemo rute
$router->get('/contacts', 'ContactController@index');
$router->get('/contacts/create', 'ContactController@create');
$router->post('/contacts/store', 'ContactController@store');
$router->get('/contacts/edit', 'ContactController@edit');
$router->post('/contacts/update', 'ContactController@update');

// Pokrećemo router
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

