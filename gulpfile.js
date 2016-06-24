var gulp = require('gulp'),
    util = require('gulp-util'),
    elixir = require('laravel-elixir'),
    spawn = require('child_process').spawn;

elixir.config.sourcemaps = true;

elixir(function(mix) {
    var scripts = [ './vendor/bower_components/angular/angular.js'
                  , './vendor/bower_components/angular-resource/angular-resource.js'
                  , './vendor/bower_components/angular-sanitize/angular-sanitize.js'
                  , './vendor/bower_components/angular-ui-router/release/angular-ui-router.js'
                  , './vendor/bower_components/jquery/dist/jquery.js' // bootstraps javascript requires jQuery ...
                  , './vendor/bower_components/bootstrap-sass/assets/javascripts/bootstrap/collapse.js' 
                  , './vendor/bower_components/bootstrap-sass/assets/javascripts/bootstrap.js'
                  , './vendor/bower_components/satellizer/satellizer.js'
                  , 'controllers.js'
                  , 'controllers/AboutController.js'
                  , 'controllers/HomeController.js'
                  , 'controllers/LoginController.js'
                  , 'controllers/NavController.js'
                  , 'controllers/RegisterController.js'
                  , 'controllers/WordEntryController.js'
                  , 'controllers/WordIndexController.js'
                  , 'controllers/WordShowController.js'
                  , 'directives.js'
                  , 'directives/errorsFor.js'
                  , 'directives/remoteValidate.js'
                  , 'directives/vowelExample.js'
                  , 'directives/vowelSelection.js'
                  , 'filters.js'
                  , 'filters/vowelExample.js'
                  , 'services.js'
                  , 'services/authService.js'
                  , 'services/httpErrorHandlerService.js'
                  , 'services/Language.js'
                  , 'services/Vowel.js'
                  , 'services/Word.js'
                  , 'app.js' // needs to be last
                  ];


    mix.scripts(scripts, 'public/js/app.js');
    if(!util.env.production) {
        // create the LiveReload script
        mix.scripts(['./vendor/bower_components/livereload-js/dist/livereload.js'], 'public/js/livereload.js');
    }
    mix.sass([ 'app.scss'
             ], 'public/css/app.css');
});
