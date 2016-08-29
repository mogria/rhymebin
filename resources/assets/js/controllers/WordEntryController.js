(function() {
    var controllers = angular.module('rhymebin.controllers');

    controllers.controller('WordEntryController', ['$scope', '$auth', 'Word', 'LanguageService', 'Vowel', function($scope, $auth, Word, LanguageService, Vowel) {

        $scope.entryData = {
            word: '',
            syllables: []
        };

        $scope.helperData = {
            vowels: [],
            availableLanguages: LanguageService.availableLanguages()
        }

        $scope.$watch("language", function() {
            if(!$scope.language) return;
            selectLanguage($scope.language);
        });
        
        $scope.updateSyllables = function() {
            var syllables = $scope.word.split("");
            $scope.syllables = syllables.map(function(letter, i) {
                return { 'syllable': letter, 'start_index': i, 'end_index': i + 1, 'vowel_id': 1 }
            });
            
        }

        $scope.mergeSyllables = function(firstSyllable) {
            var syllables = $scope.syllables;
            var index = syllables.indexOf(firstSyllable);
            if(index == -1) return;
            var secondSyllable = syllables[index + 1];
            if(!secondSyllable) return;
            firstSyllable.syllable += secondSyllable.syllable;
            firstSyllable.end_index = secondSyllable.end_index;
            // remove the second syllable object
            syllables.splice(index + 1, 1);
            $scope.syllables = syllables;
            return false;
        }
        
        $scope.wordSubmit = function() {
            var word = new Word({'syllables': $scope.syllables, 'language_id': $scope.language.id});
            word.$save({'language_id': $scope.language.id}, function() {
                $scope.word = '';
                $scope.updateSyllables();
            }, function(response) {
                $scope.errors = response.data.validationErrors;
            });
            console.log(word);
            return false;
        };
    }]);

    controllers.config(['$stateProvider', function($stateProvider) {
        $stateProvider.state('wordEntry', {
            'url': '/words/new',
            'views': {
                'content': {
                    'controller': 'WordEntryController',
                    'templateUrl': 'template-word-entry'
                }
            }
        })
    }]);
})();
