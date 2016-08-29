(function() {
    var controllers = angular.module('rhymebin.controllers');
    controllers.controller('WordIndexController', ['$scope', 'LanguageService', 'Word', function($scope, LanguageService, Word) {
        var loadWords = function(language) {
            Word.query({'language_id': language.id}, function(words) {
                $scope.words = words;
            });
        };
        LanguageService.addLanguageChangedHandler(loadWords);
        loadWords(LanguageService.selectedLanguage());
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
