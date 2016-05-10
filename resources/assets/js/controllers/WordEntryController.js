(function() {
    var app = angular.module('rhymebin.controllers.WordEntryController', ['ui.router']);

    app.controller('WordEntryController', ['$scope', '$auth', 'Word', 'Language', function($scope, $auth, Word, Language) {
            
        $scope.word = '';
        $scope.language = 1;
        
        
        $scope.availableLanguages = [];
        
        Language.query(function(languages) {
            $scope.availableLanguages = languages;
        });
        
        $scope.syllables = [];
        
        $scope.updateSyllables = function() {
            var syllables = $scope.word.split("");
            $scope.syllables = syllables.map(function(letter, i) {
                return { 'syllable': letter, 'start_index': i, 'end_index': i + 1 }
            });
            
        }
        
        $scope.wordSubmit = function() {
            $auth.login({'name': $scope.name, 'password': $scope.password}).then(function(data) {
                state.go('wordEntry');
            });
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
