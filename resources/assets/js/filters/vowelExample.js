(function() {
    var filters = angular.module('rhymebin.filters');
    filters.filter('vowelExample', ['$sce', function($sce) {
        return function(input) {
            return $sce.trustAsHtml(input.replace(/\*([^\*]+)\*/, '<strong>$1</strong>'));
        };
    }]);
})();
