(function() {
    var controllers = angular.module('rhymebin.controllers');
    
    controllers.controller('HomeController', ['$scope', '$state', function($scope, $state) {
        $scope.input = {
            search: ''
        };
        $scope.searchSubmit = function() {
            var searchTerm = $scope.input.search;
            if(searchTerm) $state.go('search', { 'search': searchTerm });
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
