(function() {
    var app = angular.module('rhymebin.controllers.HomeController', ['ui.router']);
    
    app.controller('HomeController', ['$scope', function($scope) {
        $scope.searchSubmit = function() {
            return false;
        };

    }]);
    
    app.config(['$stateProvider', function($stateProvider) {
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
