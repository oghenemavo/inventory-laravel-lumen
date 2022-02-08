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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->group(['prefix' => 'api'], function() use ($router) {
    // Unauthenticated Routes
    $router->post('create/user', 'AuthController@register');
    $router->post('auth/login', 'AuthController@login');
    
    // Authenticated Routes
    $router->group(['middleware' => 'auth'], function() use ($router) {
        $router->post('logout', 'AuthController@logout');
        $router->get('refresh', 'AuthController@refresh'); 
        $router->post('refresh', 'AuthController@refresh');

        $router->get('user/inventories', 'UserController@inventories'); 
        $router->post('user/add-to-cart', 'UserController@addToCart'); 
    });

    $router->group(['prefix' => 'admin'], function() use ($router) {
        $router->post('inventory/create', 'Admin\InventoryController@create');
        $router->get('inventory', 'Admin\InventoryController@all');
        $router->get('inventory/{id}', 'Admin\InventoryController@read');
        $router->post('inventory/edit/{id}', 'Admin\InventoryController@update');
        $router->post('inventory/delete', 'Admin\InventoryController@delete');
    });

});
