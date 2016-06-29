<!doctype html>
<html ng-app="rhymebin">
    <head>
        <title>RhymeBin</title>
        
        <!-- Proper rendering and touch zooming on mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        <link rel="stylesheet" href="<?= htmlspecialchars(elixir('css/app.css'), ENT_QUOTES); ?>" type="text/css" />
        
        <script src="<?= htmlspecialchars(elixir('js/app.js'), ENT_QUOTES); ?>" type="text/javascript"></script>
        <?php if(env("APP_ENV") == "local"): ?>
        <script src="js/livereload.js?host=localhost" type="text/javascript"></script>
        <?php endif ?>
    </head>
    <body>
        <nav class="navbar navbar-default" ng-controller="NavController" ng-include="'template-nav'">
        </nav>
        
        <div class="container-fluid" ui-view="content">
            <div class="alert alert-danger">
                Looks like the site couldn't be loaded. Sorry :-(
                <noscript>
                    This site requires JavaScript to be enabled.
                </noscript>
            </div>
        </div>
          
        

        <?= allAngularTemplates() ?>
    </body>
</html>
