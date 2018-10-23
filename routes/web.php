<?php

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

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->get('hash/{hash}', ['as' => 'hash.show', 'uses' => 'HashController@show']);
    $router->post('hash', ['as' => 'hash.store', 'uses' => 'HashController@store']);
    $router->put('hash', ['as' => 'hash.store', 'uses' => 'HashController@store']);
});