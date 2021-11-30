<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "<h1 style='text-align:center'>Hello !!!<br>From<br>Aung Kyaw Myint<br>(Kelvin)<br>".$router->app->version()."</h1>";
});

$router->get('/env', function () use ($router) {
    return app('env');
});

$router->post('object', ['uses' => 'SecretController@createObject']);

$router->get('object/get_all_records', ['uses' => 'SecretController@getAll']);
$router->get('object/{mykey}', ['uses' => 'SecretController@getObject']);
