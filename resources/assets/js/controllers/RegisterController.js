(function() {
    var controllers = angular.module('rhymebin.controllers');

    controllers.controller('RegisterController', ['$scope', '$auth', '$state', function($scope, $auth, $state) {
        $scope.errors = [];
        $scope.passwordConfirmed = true;
        
        $scope.registerSubmit = function() {
            $scope.errors = [];
            $scope.passwordConfirmed = $scope.passwordConfirmation == $scope.password;
            
            if($scope.passwordConfirmed) {
                $auth.signup({
                    'name': $scope.name,
                    'email': $scope.email,
                    'password': $scope.password
                }).then(function(data) {
                    $state.go('login', {'name': $scope.name});
                }).catch(function(response) {
                    if(response.data.hasOwnProperty('validationErrors')) {
                        $scope.errors = response.data.validationErrors;
                    }
                });
            }
            return false;
        };
    }]);

    controllers.config(['$stateProvider', function($stateProvider) {
        $stateProvider.state('register', {
            'url': '/register',
            'views': {
                'content': {
                    'controller': 'RegisterController',
                    'templateUrl': 'template-register'
                }
            }
        })
    }]);
})();
