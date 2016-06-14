var gulp = require('gulp'),
    util = require('gulp-util'),
    elixir = require('laravel-elixir'),
    spawn = require('child_process').spawn;

elixir.config.sourcemaps = true;

elixir(function(mix) {
    var scripts = [ './vendor/bower_components/angular/angular.js'
                  , './vendor/bower_components/angular-ui-router/release/angular-ui-router.js'
                  , './vendor/bower_components/angular-resource/angular-resource.js'
                  , './vendor/bower_components/satellizer/satellizer.js'
                  , './vendor/bower_components/jquery/dist/jquery.js' // bootstraps javascript requires JQuery ...
                  , './vendor/bower_components/bootstrap-sass/assets/javascripts/bootstrap.js'
                  , './vendor/bower_components/bootstrap-sass/assets/javascripts/bootstrap/collapse.js' 
                  , 'directives.js'
                  , 'directives/formValidation.js'
                  , 'services.js'
                  , 'services/Word.js'
                  , 'services/Language.js'
                  , 'services/Vowel.js'
                  , 'services/authService.js'
                  , 'services/httpErrorHandlerService.js'
                  , 'controllers.js'
                  , 'controllers/HomeController.js'
                  , 'controllers/NavController.js'
                  , 'controllers/AboutController.js'
                  , 'controllers/LoginController.js'
                  , 'controllers/RegisterController.js'
                  , 'controllers/WordEntryController.js'
                  , 'controllers/WordIndexController.js'
                  , 'controllers/VowelSelectionController.js'
                  , 'app.js'
                  ];


    mix.scripts(scripts, 'public/js/app.js');
    if(!util.env.production) {
        // create the LiveReload script
        mix.scripts(['./vendor/bower_components/livereload-js/dist/livereload.js'], 'public/js/livereload.js');
    }
    mix.sass([ 'app.scss'
             ], 'public/css/app.css');
});
