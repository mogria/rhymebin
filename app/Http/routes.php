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

$app->group(['prefix' => '/api', 'middlware' => 'jwt.auth'], function() use ($app) {
    $app->get('/', function () use ($app) {
        return $app->version();
    });
});