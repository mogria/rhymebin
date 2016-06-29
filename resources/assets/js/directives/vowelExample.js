(function() {
    var directives = angular.module('rhymebin.directives');
    directives.directive('vowelExample', ['$sce', function() {
        return {
            restrict: 'E',
            link: function($scope, element, attr) {
                $scope.example = $sce.trustAsHtml($scope.example);
            },
            scope: {
                example: '=example'
            },
            template: 'template-word-vowel-example'
        }
    }]);
})();
