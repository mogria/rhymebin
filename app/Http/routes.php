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

$app->group(['prefix' => '/api', 'middleware' => 'jwt.auth', 'namespace' => 'App\Http\Controllers'], function() use ($app) {
    $app->get('/', function () use ($app) { 
        return $app->version();
    });
    
    $app->get('/users', 'UserController@getUsers');
    $app->get('/users/{id}', 'UserController@getUser');
    
    $app->get('/languages', 'LanguageController@getLanguages');
    $app->get('/languages/{id}', 'LanguageController@getLanguage');
    
    $app->get('/languages/{language_id}/words', 'WordController@getWords');
    $app->get('/languages/{language_id}/words/rhymes', 'WordController@getWordRhymes');
    $app->get('/languages/{language_id}/words/{word_id}', 'WordController@getWords');
    $app->post('/languages/{language_id}/words', 'WordController@postWords');
    

    $app->get('/languages/{language_id}/vowels', 'VowelController@getVowels');
    $app->get('/languages/{language_id}/vowels/{id}', 'VowelController@getVowel');
});

$app->post('/api/login', 'SessionController@postLogin');
$app->post('/api/logout', 'SessionController@postLogout');
$app->post('/api/refresh', 'SessionController@postRefresh');
$app->post('/api/users', 'UserController@postUsers');
