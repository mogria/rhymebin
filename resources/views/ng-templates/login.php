<h1>Login</h1>
<form name="loginform" ng-submit="loginSubmit()">
    
    <div ng-show="loginFailure" class="alert alert-danger">Your username and/or password doesn't match our records.</div>
    
    <div class="form-group">
        <label for="user">Username</label>
        <input type="text" class="form-control" name="user" ng-model="name">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" ng-model="password" />
    </div>
    
    <input type="submit" class="btn btn-primary btn-default" value="Login" />
</form>