<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

$app->withFacades();

$app->configure('auth');

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    App\Http\Middleware\SecurityHeaders::class
]);

/* $app->routeMiddleware([
    //'jwt.auth'    => Tymon\JWTAuth\Middleware\GetUserFromToken::class,
    //'jwt.refresh' => Tymon\JWTAuth\Middleware\RefreshToken::class,
]); */

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

if(env('APP_ENV') === 'local') {
    $app->bind(\Illuminate\Database\ConnectionResolverInterface::class, \Illuminate\Database\ConnectionResolver::class);
    $app->register(\Niellles\LumenCommands\LumenCommandsServiceProvider::class);
}


/* 
$app->alias('JWTAuth', 'Tymon\JWTAuth\Facades\JWTAuth');
$app->alias('JWTFactory', 'Tymon\JWTAuth\Facades\JWTFactory');

class_alias('Tymon\JWTAuth\Facades\JWTAuth', 'JWTAuth');
class_alias('Tymon\JWTAuth\Facades\JWTFactory', 'JWTFactory');

$app->alias('cache', 'Illuminate\Cache\CacheManager');
$app->alias('auth', 'Illuminate\Auth\AuthManager'); */


$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\HelperProvider::class);
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
//$app->register(Irazasyed\JwtAuthGuard\JwtAuthGuardServiceProvider::class);
//$app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);


/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__.'/../app/Http/routes.php';
});


return $app;
