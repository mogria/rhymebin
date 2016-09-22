(function() {
    var controllers = angular.module('rhymebin.controllers');

    controllers.controller('SearchController', ['$scope', '$stateParams', 'RhymeService', function($scope, $stateParams, RhymeService) {
        $scope.input = {
            'search': ('' + $stateParams.search) || '',
        };
        $scope.display = {
            'results': []
        };

        $scope.search = function() {
            var searchTerm = $scope.input.search;
            RhymeService.search(searchTerm, function(response) {
                $scope.display.results = response.data;
            }, function(response) {
                if(response.data.hasOwnProperty('validationErrors')) {
                    console.log($scope.errors);
                    $scope.errors = response.data.validationErrors;
                }
            });
        };

        if($stateParams.search) {
            $scope.search();
        }
    }]);

    controllers.config(['$stateProvider', function($stateProvider) {
        $stateProvider.state('search', {
            'url': '/search/:search',
            'views': {
                'content': {
                    'controller': 'SearchController',
                    'templateUrl': 'template-search'
                }
            }
        });
    }]);
})();
