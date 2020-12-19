<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'auth'], function () use ($router){
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('register', 'AuthController@register');
});

// Rooms Endpoints
$router->group(['prefix' => 'rooms', 'middleware' => 'auth'], function () use ($router){
    $router->get('/', 'RoomController@index');
    $router->get('/{room}', 'RoomController@show');
});

// Customers Endpoints
$router->group(['prefix' => 'customers', 'middleware' => 'auth'], function () use ($router){
    $router->get('/', 'CustomerController@index');
    $router->get('/{customer}', 'CustomerController@show');
    $router->post('/', 'CustomerController@store');
    $router->post('/{customer}', 'CustomerController@update');
});


$router->get('/', function () use ($router) {
    return $router->app->version();
});
