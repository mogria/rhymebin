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

$app->get('/', function() {
    return view('index');
});

$app->group(['prefix' => '/api', 'middleware' => 'jwt.auth'], function() use ($app) {
    $app->get('/', function () use ($app) {
        return $app->version();
    });
    
    $app->get('/api/users', 'UserController@getUsers');
    $app->get('/api/users/{id}', 'UserController@getUser');
});

$app->post('/api/login', 'SessionController@postLogin');
$app->post('/api/logout', 'SessionController@getLogout');
$app->post('/api/refresh', 'SessionController@getRefresh');
$app->post('/api/users', 'UserController@postUsers');