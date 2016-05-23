(function() {
    var controllers = angular.module('rhymebin.controllers');
    
    controllers.controller('HomeController', ['$scope', function($scope) {
        $scope.searchSubmit = function() {
            return false;
        };

    }]);
    
    controllers.config(['$stateProvider', function($stateProvider) {
        $stateProvider.state('home', { 
            'url': '/',
            'views': {
                'content': {
                    'controller': 'HomeController',
                    'templateUrl': 'template-home'
                }
            }
        });
    }])
})();
