var app = angular.module('rhymebin.controllers.LoginController', []);

app.controller('LoginController', ['$scope', '$auth', function($scope, $auth) {
    $scope.loginSubmit = function() {
        $auth.login({'name': $scope.name, 'password': $scope.password}).then(function(data) {
            state.go('wordEntry');
        });
        return false;
    };
}]);
