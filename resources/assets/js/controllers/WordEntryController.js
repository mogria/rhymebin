(function() {
    var app = angular.module('rhymebin.controllers.WordEntryController', ['ui.router']);

    app.controller('WordEntryController', ['$scope', '$auth', 'Word', 'Language', 'Vowel', function($scope, $auth, Word, Language, Vowel) {
            
        $scope.word = '';
        
        
        $scope.availableLanguages = [];
        
        Language.query(function(languages) {
            $scope.availableLanguages = languages;
            if($scope.availableLanguages.length > 0) {
                $scope.language = $scope.availableLanguages[0];
            }
        });
        
        $scope.syllables = [];

        $scope.vowels = [];

        $scope.$watch("language", function() {
            if(!$scope.language) return;
            Vowel.query({'language_id': $scope.language.id}, function(vowels) {
                $scope.vowels = vowels;
            });
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
            return false;
        };
    }]);

    app.config(['$stateProvider', function($stateProvider) {
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
