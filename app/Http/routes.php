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
    if(env('APP_ENV', '') === 'production') {
        \Log::warn('serving production index.html via php\'s file_get_contents, better configure your web server to prefer index.html over index.php');
        return file_get_contents(public_path('index.html'));
    }
    return view('index'); 
});

// api with authentication
$app->group(['prefix' => '/api', 'middleware' => 'jwt.auth', 'namespace' => 'App\Http\Controllers'], function() use ($app) {
    $app->get('/users', 'UserController@getUsers');
    $app->get('/users/{id}', 'UserController@getUser');
    $app->post('/languages/{language_id}/words', 'WordController@postWords');
});

// api with no authentication
$app->group(['prefix' => '/api', 'namespace' => 'App\Http\Controllers'], function() use ($app) {
    $app->get('/', function () use ($app) { 
        return $app->version();
    });

    $app->get('/languages', 'LanguageController@getLanguages');
    $app->get('/languages/{id}', 'LanguageController@getLanguage');
    $app->get('/languages/{language_id}/words/rhymes', 'WordController@getWordRhymes');
    $app->get('/languages/{language_id}/words/{word_id}', 'WordController@getWord');
    $app->get('/languages/{language_id}/words', 'WordController@getWords');
    $app->get('/languages/{language_id}/vowels', 'VowelController@getVowels');
    $app->get('/languages/{language_id}/vowels/{id}', 'VowelController@getVowel');

    $app->post('/login', 'SessionController@postLogin');
    $app->post('/logout', 'SessionController@postLogout');
    $app->post('/refresh', 'SessionController@postRefresh');
    $app->post('/users', 'UserController@postUsers');
});

