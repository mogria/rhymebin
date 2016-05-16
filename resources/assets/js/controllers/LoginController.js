(function() {
    var app = angular.module('rhymebin.controllers.LoginController', ['ui.router', 'satellizer']);

    app.controller('LoginController', ['$scope', 'authService', '$state', '$stateParams', function($scope, authService, $state, $stateParams) {
        $scope.name = $stateParams.name || '';
        $scope.loginFailure = false;
        $scope.loginSubmit = function() {
            $scope.loginFailure = false;
            authService.login($scope.name, $scope.password).then(function() {
                $state.go('wordEntry');
            }, function() {
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
