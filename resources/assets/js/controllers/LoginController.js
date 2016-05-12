(function() {
    var app = angular.module('rhymebin.controllers.LoginController', ['ui.router', 'satellizer']);

    app.controller('LoginController', ['$scope', '$auth', '$state', '$stateParams', function($scope, $auth, $state, $stateParams) {
        $scope.name = $stateParams.name || '';
        $scope.loginFailure = false;
        $scope.loginSubmit = function() {
            $scope.loginFailure = false;
            $auth.login({'name': $scope.name, 'password': $scope.password}).then(function(response) {
                $auth.setToken(response.data.token);
                $state.go('wordEntry');
            }).catch(function() {
                $scope.loginFailure = true;
            });
            return false;
        };
    }]);

    app.config(['$stateProvider', function($stateProvider) {
        $stateProvider.state('login', {
            'url': '/login:name',
            'views': {
                'content': {
                    'controller': 'LoginController',
                    'templateUrl': 'template-login'
                }
            }
        })
    }]);
})();
