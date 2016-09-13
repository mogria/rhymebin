(function() {
    var controllers = angular.module('rhymebin.controllers');

    controllers.controller('SearchController', ['$scope', '$stateParams', 'LanguageService', function($scope, $stateParams, LanguageService) {
        $scope.input = {
            'search': ('' + $stateParams.search) || '',
        };
        $scope.display = {
            'results': ['Rest', 'Test']
        };

        $scope.search = function() {
            var searchTerm = $scope.input.search;
            console.log('Searching for "' + searchTerm + '"');
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
