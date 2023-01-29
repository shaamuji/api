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
    return $router->app->version();
});

// public routes no auth
$router->post('register', 'AuthController@register');
$router->post('login', 'AuthController@login');

// client route auth with any role
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/products/{id}','ProductController@show');
    $router->get('/products','ProductController@index');

    $router->post('/cart-items','CartItemController@addItemToCart');
    $router->get('/cart-items','CartItemController@show');

    $router->post('/orders','OrderController@checkout');
    $router->get('/orders/{id}','OrderController@show');

   
});

// admin routes role_id = 1
$router->group(['middleware' => ['auth',"check-role-id-is:1"]], function () use ($router) {
    $router->put('/orders/{id}','OrderController@update');
    $router->delete('/orders/{id}','OrderController@destroy');
    $router->get('/orders','OrderController@index');

    $router->post('/products','ProductController@create');
    $router->put('/products/{id}','ProductController@update');
    $router->delete('/products/{id}','ProductController@destroy');

    $router->post('/users','UserController@create');
    $router->put('/users/{id}','UserController@update');
    $router->get('/users/{id}','UserController@show');
    $router->delete('/users/{id}','UserController@destroy');

 
});