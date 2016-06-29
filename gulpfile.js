var gulp = require('gulp'),
    util = require('gulp-util'),
    elixir = require('laravel-elixir');

elixir.config.sourcemaps = true;

function component(name) {
    return './vendor/bower_components/' + name + '.js';
}

function js(name) {
    return './resources/assets/js/' + name + '.js';
}

elixir(function(mix) {
    var scripts = [ component('angular/angular')
                  , component('angular-resource/angular-resource')
                  , component('angular-sanitize/angular-sanitize')
                  , component('angular-ui-router/release/angular-ui-router')
                  , component('jquery/dist/jquery') // bootstraps javascript requires jQuery ...
                  , component('bootstrap-sass/assets/javascripts/bootstrap/collapse' )
                  , component('bootstrap-sass/assets/javascripts/bootstrap')
                  , component('satellizer/satellizer')
                  , js('controllers')
                  , js('controllers/AboutController')
                  , js('controllers/HomeController')
                  , js('controllers/LoginController')
                  , js('controllers/NavController')
                  , js('controllers/RegisterController')
                  , js('controllers/WordEntryController')
                  , js('controllers/WordIndexController')
                  , js('controllers/WordShowController')
                  , js('directives')
                  , js('directives/errorsFor')
                  , js('directives/remoteValidate')
                  , js('directives/vowelExample')
                  , js('directives/vowelSelection')
                  , js('filters')
                  , js('filters/vowelExample')
                  , js('services')
                  , js('services/authService')
                  , js('services/httpErrorHandlerService')
                  , js('services/Language')
                  , js('services/Vowel')
                  , js('services/Word')
                  , js('app') // needs to be last
                  ];


    mix.combine(scripts, 'public/js/app.js');
    if(!util.env.production) {
        // create the LiveReload script
        mix.scripts(['./vendor/bower_components/livereload-js/dist/livereload.js'], 'public/js/livereload.js');
    }
    mix.sass([ 'app.scss'
             ], 'public/css/app.css');

    mix.version(['public/css/app.css', 'public/js/app.js']);
});
