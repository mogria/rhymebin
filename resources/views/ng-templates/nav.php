<div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-navbar" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">
            <span>
                <img alt="Brand" width="24" height="24" src="img/logo128.png" />
                RhymeBin
            </span>
        </a>
    </div>

    <div class="collapse navbar-collapse" id="collapse-navbar">
        <ul class="nav navbar-nav" ui-view="nav">
            <li ng-class="{active: currentUrl === '/'}"><a href="#/">Home</a></li>
            <li ng-class="{active: currentUrl === '/about'}"><a href="#/about">About</a></li>
            
            <!-- show when user is logged in -->
            <li ng-class="{active: currentUrl === '/words/new'}" ng-show="loggedIn"><a href="#/words/new">Add Words</a></li>
            <li ng-show="loggedIn"><a ng-click="logout()">Log out</a><li>
            
            <!-- show when user is logged out -->
            <li ng-class="{active: currentUrl === '/register'}" ng-show="!loggedIn"><a href="#/register">Register</a></li>
            <li ng-class="{active: currentUrl === '/login:name'}" ng-show="!loggedIn"><a href="#/login">Login</a></li>
        </ul>
    </div>
</div>