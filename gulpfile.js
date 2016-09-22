var gulp = require('gulp'),
    util = require('gulp-util'),
    rename = require('gulp-rename'),
    file = require('gulp-file'),
    concat = require('gulp-concat'),
    clean = require('gulp-clean'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    uglify = require('gulp-uglify'),
    htmlmin = require('gulp-htmlmin'),
    purify = require('gulp-purifycss'),
    cleanCss = require('gulp-clean-css'),
    execFile = require('child_process').execFile,
    replace = require('gulp-replace'),
    fs = require('fs');

var js = function(name) {
    return './resources/assets/js/' + name + '.js';
},  jscomponent = function (name) {
    return './vendor/bower_components/' + name + '.js';
},  scss = function(name) {
    return './resources/assets/sass/' + name + '.scss';
},  sasscomponent = function(name) {
    return './vendor/bower_components/' + name;
}


var production = util.env.production === true;

var paths = {
    sass: [ scss('app')
          ],
    js  : [ jscomponent('angular/angular')
          , jscomponent('angular-resource/angular-resource')
          , jscomponent('angular-sanitize/angular-sanitize')
          , jscomponent('angular-ui-router/release/angular-ui-router')
          , jscomponent('jquery/dist/jquery') // bootstraps javascript requires jQuery, but we'll use zepto instead ...
          , jscomponent('bootstrap-sass/assets/javascripts/bootstrap/collapse' )
          , jscomponent('bootstrap-sass/assets/javascripts/bootstrap')
          , jscomponent('satellizer/satellizer')
          , jscomponent('ngstorage/ngStorage')
          , js('controllers')
          , js('controllers/*')
          , js('directives')
          , js('directives/*')
          , js('filters')
          , js('filters/*')
          , js('services')
          , js('services/*')
          , js('app') // needs to be last
          ],
    // Live Reload javascript, this only gets written to the public/ directory
    // when --production is *not* given
    lrjs: [ jscomponent('livereload-js/dist/livereload')
          ],
    tmpl: [ 'resources/views/ng-templates/*.html'
          , 'resources/views/index.php'
          ]
}

var target_dirs = {
    js: './public/js/',
    css: './public/css/',
    version: './public/',
    onepage: './public/'
};

var js_tasks =
    production ?
        [ 'js-combine'
        , 'js-minify'
        ] :
        [ 'js-combine'
        , 'js-live-reload'
        ];

var css_tasks =
    production ?
        [ 'sass-compile'
        , 'css-purify'
        , 'css-minify'
        ] :
        [ 'sass-compile'
        ];

var common_tasks = js_tasks.concat(css_tasks);

var default_tasks = common_tasks.concat(
    production ?
        [ 'onepage'
        ] :
        [ 'gen-version'
        , 'live-reload-server'
        ]);

gulp.task('default', default_tasks);

gulp.task('js-combine', function() {
    return gulp.src(paths.js)
        .pipe(sourcemaps.init())
            .pipe(concat('app.js'))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(target_dirs.js))
});

gulp.task('js-minify', ['js-combine'], function() {
    return gulp.src(target_dirs.js + 'app.js')
        .pipe(uglify())
        .pipe(rename({extname: '.min.js'}))
        .pipe(gulp.dest(target_dirs.js));
});

gulp.task('js-live-reload', function() {
    return gulp.src(paths.lrjs)
        .pipe(gulp.dest(target_dirs.js));
});


gulp.task('sass-compile', function() {
    return gulp.src(paths.sass)
        .pipe(sourcemaps.init())
            .pipe(sass({
                outputStyle: 'expanded',
                includePaths: [sasscomponent('bootstrap-sass/assets/stylesheets')]
            }).on('error', sass.logError))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(target_dirs.css));
});


// Removes unused css classes
gulp.task('css-purify', ['sass-compile'], function() {
    return gulp.src(target_dirs.css + 'app.css')
        .pipe(purify([target_dirs.js + 'app.js'].concat(paths.tmpl), {
            info: true
        }))
        .pipe(rename({extname: '.purified.css'}))
        .pipe(gulp.dest(target_dirs.css));
});

gulp.task('css-minify', ['sass-compile', 'css-purify'], function() {
    return gulp.src(target_dirs.css + 'app.purified.css')
        .pipe(cleanCss({
            advanced: true,
            agressiveMerging: true,
            mediaMerging: true,
            keepSpecialComments: '*',
            debug: true,
            restructuring: true,
            sourceMap: false,
            rebase: true,
            target: 'public' // rebase urls in CSS
        }, function(details) {
            util.log("Minified CSS by " + Math.round(details.stats.efficiency * 1000) / 10 + "%, " + details.stats.minifiedSize + "/" + details.stats.originalSize + " bytes");
        }))
        .pipe(rename({extname: '.min.css'}))
        .pipe(gulp.dest(target_dirs.css));
});


// Generate a version file. It's contents get added to
// the request url for all asses to bust the cache
gulp.task('gen-version', function() {
    return file('version', Date.now() + "", { src: true })
        .pipe(gulp.dest(target_dirs.version));
});


// Compiles the whole application into a single .html file
// When lumen is configured to be in production, it serves the file when requesting GET /
gulp.task('onepage', ['js-minify', 'css-minify'], function(done) {
    var phpCode = "$_SERVER[\"REQUEST_METHOD\"]=\"GET\";\n$_SERVER[\"REQUEST_URI\"]=\"/\";\n$a=require(\"bootstrap/app.php\");\n$a->run();";
    execFile('php', ['-r', phpCode], {
        maxBuffer: 4 * 1024 * 1024 /* 4MB */,
        env: {'APP_ENV': 'gulp'}
    }, function(error, stdout, stderr) {
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
        var javascript = inlineEncode(fs.readFileSync(target_dirs.js + 'app.min.js', {encoding: 'utf8'}));
        var css = inlineEncode(fs.readFileSync(target_dirs.css + 'app.purified.min.css', {encoding: 'utf8'}));
        file('index.html', stdout, { src: true })
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
            .pipe(gulp.dest(target_dirs.onepage))
            .on('end', done);
    });
});
 
gulp.task('live-reload-server', function() {
    var watches = [
        target_dirs.js,
        target_dirs.css,
        'public/img'
    ];

    livereload = require('livereload');
    server = livereload.createServer();

    util.log('LiveReload server started');
    watches.forEach(function(watch) {
        util.log('LiveReload is watching ' + watch);
        server.watch(__dirname + '/' + watch );
    });
});

gulp.task('watch', default_tasks, function() {
    gulp.watch(paths.sass, css_tasks);
    gulp.watch(paths.js, js_tasks);
});

gulp.task('clean', function() {
    return gulp.src(
        [ target_dirs.js
        , target_dirs.css
        , target_dirs.version + 'version'
        , target_dirs.onepage + 'index.html'
        ], { read: false })
        .pipe(clean());
});
