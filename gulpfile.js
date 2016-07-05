var gulp = require('gulp'),
    util = require('gulp-util'),
    file = require('gulp-file'),
    htmlmin = require('gulp-htmlmin'),
    purify = require('gulp-purifycss'),
    execFile = require('child_process').execFile,
    elixir = require('laravel-elixir'),
    replace = require('gulp-replace'),
    fs = require('fs');


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

    if(util.env.production) {
        //mix.task('purify')
        mix.task('onepage');
    }
    mix.task('gen-version');

});

gulp.task('gen-version', function() {
    return file('version', Date.now() + "", {src: true})
        .pipe(gulp.dest('./public'));
});

/* Disabled for now, because can't get it to work with the minification of elixir. Maybe just drop elixir.
 * gulp.task('purify', function() {
    return gulp.src('./public/css/app.css')
        .pipe(purify(['public/js/app.js', 'resources/views/index.php', 'resources/views/ng-templates/*.html']))
        .pipe(gulp.dest('./public/css/'));
}); */

gulp.task('onepage', function(done) {
    var phpCode = "$_SERVER[\"REQUEST_METHOD\"]=\"GET\";\n$_SERVER[\"REQUEST_URI\"]=\"/\";\n$a=require(\"bootstrap/app.php\");\n$a->run();";
    execFile('php', ['-r', phpCode], { maxBuffer: 4 * 1024 * 1024 /* 4MB */, env: {'APP_ENV': 'production'} }, function(error, stdout, stderr) {
        if(error) {
            util.log("cannot request index page for single page minification.");
            util.log(error);
            util.log(stdout);
            return;
        }
        var inlineEncode = function(str) {
            return str.replace(/\$/g, '$$$$')
                //.replace(/</g, '\\x3C')
                //.replace(/>/g, '\\x3E');
        }
        var javascript = inlineEncode(fs.readFileSync('./public/js/app.js', {encoding: 'utf8'}));
        var css = inlineEncode(fs.readFileSync('./public/css/app.css', {encoding: 'utf8'}));
        file('spa.html', stdout, { src: true })
            .pipe(htmlmin({
                caseSensitive: true, // custom tags, don't modify them because of angular
                collapseWhitespace: true,
                collapseInlineTagWhitespace: true,
                customEventAttributes: [/ng-[a-z0-9]+/],
                decodeEntities: true,
                html5: true,
                ignoreCustomComments: [/^!/],
                minifyCSS: false,
                minifyJS: false,
                minifyURLs: true,
                processScripts: ['text/ng-template'],
                quoteCharacter: '"',
                removeAttributeQuotes: true,
                removeComments: true,
                removeRedundantAttributes: true,
                removeTagWhitespace: true,
                sortAttributes: true,
                sortClassName: true
            }))
            .on('error', util.log)
            .pipe(replace(/<link [^>]*href=['"]?css\/app[^>]+>/, '<style>/*<!--*/' + css + '/*-->*/</style>'))
            .pipe(replace(/<script [^>]*src=['"]?js\/app[^>]+><\/script>/, '<script type="text/javascript">/*<!--*/' + javascript + '//--></script>'))
            .pipe(replace(/\/\/\s*#\s+sourceMappingURL=[\w.-]+\s*/m, ""))
            .pipe(replace(/\/\*\s*#\s+sourceMappingURL=[\w.-]+\s*\*\/\s*/m, ""))
            .pipe(gulp.dest('public/'))
    });
});
 
