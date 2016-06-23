(function(){
    var directives = angular.module('rhymebin.directives');

    directives.directive('vowelSelection', [
        function() {
            return {
                restrict: 'E',
                link: function(scope, element, attr) {
                    console.log(scope);
                },
                templateUrl: 'template-word-vowel-selection'
            };
        }
    ]);
})();
