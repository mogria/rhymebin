(function() {
    var controllers = angular.module('rhymebin.controllers');

    controllers.controller('SearchController', ['$scope', '$stateParams', 'RhymeService', function($scope, $stateParams, RhymeService) {
        $scope.input = {
            'search': ('' + $stateParams.search) || '',
        };

        var resetDisplay = function() {
            $scope.display = {
                'results': [],
                'error': false,
                'success': false,
                'numResults': 0,
                'errorMessage': ""
            };
        };

        resetDisplay();

        $scope.search = function() {
            resetDisplay();
            var searchTerm = $scope.input.search;
            RhymeService.search(searchTerm, function(response) {
                if(response.data.error) {
                    $scope.display.error = true;
                    $scope.display.errorMessage = response.data.error + ': ' + response.data.unrecognized_words.join(', ');
                } else {
                    $scope.display.results = response.data;
                    $scope.display.numResults = $scope.display.results.length;
                    $scope.display.success = true;
                }
            }, function(response) {
                if(response.data.hasOwnProperty('validationErrors')) {
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
