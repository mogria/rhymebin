<!doctype html>
<html ng-app="rhymebin"><!-- git de güszl bi: https://github.com/mogria/rhymebin -->
    <!--
     ____  _     _   _           _   _ ____  _
    |  _ \| |__ (_) (_)_ __ ___ (_)_(_) __ )(_)_ __
    | |_) | '_ \| | | | '_ ` _ \ / _ \|  _ \| | '_ \
    |  _ <| | | | |_| | | | | | |  __/| |_) | | | | |
    |_| \_\_| |_|\__, |_| |_| |_|\___||____/|_|_| |_|
                 |___/ by mogria
    -->
    <head>
        <title>RhymeBin</title>
        
        <!-- Proper rendering and touch zooming on mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        

        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

        <link rel="stylesheet" href="<?= htmlspecialchars(elixir('css/app.css'), ENT_QUOTES);
                                         // The stylesheet is built by gulp/elixir the filenames change, 
                                         // so a new version will always cache-bust. ?>" type="text/css" />
       
        <script src="<?= htmlspecialchars(elixir('js/app.js'), ENT_QUOTES);
                         // The JavaScript is combined into a single file to save
                         // HTTP-Requests. Also make a new version cache-bust as well ?>" type="text/javascript"></script>

        <?php if(env("APP_ENV") == "local"): ?><!-- Only load up LiveReload, when developing locally -->
        <script src="js/livereload.js?host=localhost" type="text/javascript"></script>
        <?php endif ?>

    </head>
    <body>
        <nav class="navbar navbar-default" ng-controller="NavController" ng-include="'template-nav'">
        </nav>
        
        <!-- The angular code mostly does it's works inside this container -->
        <div class="container-fluid" ui-view="content">
            <div class="alert alert-danger">
                Looks like the site couldn't be loaded. Sorry :-(
                <noscript>
                    This site requires JavaScript to be enabled.
                </noscript>
            </div>
        </div>
          
        

        <?php
            // inline all the angular templates right away inside <scipt>-tags to save HTTP Requests
            $templates = allAngularTemplates();
            echo str_replace("\n", "\n       ", $templates); // for indenting
        ?>

    </body>
</html>

