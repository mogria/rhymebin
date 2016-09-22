(function() {
    var directives = angular.module('rhymebin.directives');
    directives.directive('word', [function() {
        return  {
            restrict: 'E',
            scope: {
                word: '=word'
            },
            templateUrl: 'template-word-word'
        }
    }]);
})();
