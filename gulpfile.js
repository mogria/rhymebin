var gulp = require('gulp'),
    elixir = require('laravel-elixir'),
    spawn = require('child_process').spawn;

elixir.config.sourcemaps = true;

elixir(function(mix) {
    mix.scripts([ './vendor/bower_components/angular/angular.js'
                , './vendor/bower_components/angular-ui-router/release/angular-ui-router.js'
                , './vendor/bower_components/satellizer/satellizer.js'
                , './vendor/bower_components/jquery/dist/jquery.js'
                , './vendor/bower_components/bootstrap-sass/assets/javascripts/bootstrap.js'
                , 'controllers/HomeController.js'
                , 'controllers/LoginController.js'
                , 'app.js'
                ], 'public/js/app.js');
    mix.sass([ 'app.scss'
             ], 'public/css/app.css');
});