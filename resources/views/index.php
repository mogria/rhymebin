<!doctype html>
<html ng-app="rhymebin">
    <head>
        <title>RhymeBin</title>
        
        <!-- Proper rendering and touch zooming on mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        <link rel="stylesheet" href="css/app.css" type="text/css" />

    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">
                        <img alt="Brand" width="24" height="24" src="img/logo128.png" />
                    </a>
                </div>
                
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav" ui-view="nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">dafq</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid" ui-view="content">



        </div>
        
        <?= angularTemplate('home') ?>
        <?= angularTemplate('login') ?>
        
        <script src="js/app.js" type="text/javascript"></script>
    </body>
</html>
