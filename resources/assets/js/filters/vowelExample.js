(function() {
    var filters = angular.module('rhymebin.filters');
    filters.filter('vowelExample', [function() {
        return function(input) {
            return input.replace(/\*([^\*]+)\*/, '<strong>$1</strong>');
        };
    }]);
})();
