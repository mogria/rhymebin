<h1>Register</h1>
<form ng-submit="registerSubmit()" novalidate remote-validate>
    <div class="form-group">
        <label for="user">Username</label>
        <input type="text" class="form-control" name="name" ng-model="name">
    </div>
    <errors-for field="name"></errors-for>
    
    <div class="form-group">
        <label for="user">Email address</label>
        <input type="text" class="form-control" name="email" ng-model="email">
    </div>
    <errors-for field="email"></errors-for>
    
    <div class="form-group">
        <label for="user">Password</label>
        <input type="password" class="form-control" name="password" ng-model="password">
    </div>
    <errors-for field="password"></errors-for>
    
    <div class="form-group">
        <label for="password">Password confirmation</label>
        <input type="password" class="form-control" name="password_confirmation" ng-model="passwordConfirmation" required />

    </div>
    <div ng-show="!passwordConfirmed" class="alert alert-danger">The two passwords must match.</div>
    
    
    <input type="submit" class="btn btn-primary btn-default" value="Register" />
</form>