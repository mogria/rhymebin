(function() {
    var controllers = angular.module('rhymebin.controllers');
    controllers.controller('WordIndexController', ['$scope', 'Word', 'Language', 'Vowel', function($scope, Word, Language, Vowel) {
        $scope.availableLanguages = [];
        Language.query(function(languages) {
            $scope.availableLanguages = languages;
            if($scope.availableLanguages.length > 0) {
                $scope.language = $scope.availableLanguages[0];
            }
        });

        $scope.$watch("language", function() {
            if(!$scope.language) return;
            Word.query({'language_id': $scope.language.id}, function(words) {
                $scope.words = words;
            });
        });
    }]);

    controllers.config(['$stateProvider', function($stateProvider) {
        $stateProvider.state('words', {
            'url': '/words',
            'views': {
                'content': {
                    'controller': 'WordIndexController',
                    'templateUrl': 'template-word-index'
                }
            }
        })
    }]);

})();
