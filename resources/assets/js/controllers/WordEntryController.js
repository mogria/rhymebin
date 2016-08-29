(function() {
    var controllers = angular.module('rhymebin.controllers');

    controllers.controller('WordEntryController', ['$scope', '$auth', 'Word', 'LanguageService', 'Vowel', function($scope, $auth, Word, LanguageService, Vowel) {

        $scope.entryData = {
            word: '',
            syllables: []
        };

        $scope.helperData = {
            vowels: []
        }
        Vowel.query({'language_id': LanguageService.selectedLanguage().id}, function(vowels) {
            $scope.helperData.vowels = vowels;
        })

        $scope.updateSyllables = function() {
            var syllables = $scope.entryData.word.split("");
            $scope.entryData.syllables = syllables.map(function(letter, i) {
                return { 'syllable': letter, 'start_index': i, 'end_index': i + 1, 'vowel_id': 1 }
            });
            
        }

        $scope.mergeSyllables = function(firstSyllable) {
            var syllables = $scope.entryData.syllables;
            var index = syllables.indexOf(firstSyllable);
            if(index == -1) return;
            var secondSyllable = syllables[index + 1];
            if(!secondSyllable) return;
            firstSyllable.syllable += secondSyllable.syllable;
            firstSyllable.end_index = secondSyllable.end_index;
            // remove the second syllable object
            syllables.splice(index + 1, 1);
            $scope.entryData.syllables = syllables;
            return false;
        }
        
        $scope.wordSubmit = function() {
            var language = LanguageService.selectedLanguage();
            var word = new Word({'syllables': $scope.entryData.syllables, 'language_id': language.id});
            word.$save({'language_id': language.id}, function() {
                $scope.entryData.word = '';
                $scope.updateSyllables();
            }, function(response) {
                $scope.errors = response.data.validationErrors;
            });
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
