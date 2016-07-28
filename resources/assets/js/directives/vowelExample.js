(function() {
    var directives = angular.module('rhymebin.directives');
    directives.directive('vowelExample', [function() {
        return {
            restrict: 'E',
            scope: {
                example: '=example'
            },
            templateUrl: 'template-word-vowel-example'
        }
    }]);
})();
