(function() {
    var controllers = angular.module('rhymebin.controllers');
    controllers.controller('WordShowController', ['$scope', 'Word', '$stateParams', function($scope, Word, $stateParams) {

        console.log($stateParams);
        Word.get({'language_id': $stateParams.langid, 'word_id': $stateParams.wordid}, function(word) {
            $scope.word = word;
        });
    }]);

    controllers.config(['$stateProvider', function($stateProvider) {
        $stateProvider.state('word-show', {
            'url': '/languages/:langid/words/:wordid',
            'views': {
                'content': {
                    'controller': 'WordShowController',
                    'templateUrl': 'template-word-show'
                }
            }
        })
    }]);

})();
