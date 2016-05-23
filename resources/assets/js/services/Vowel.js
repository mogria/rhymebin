(function(){
    var services = angular.module('rhymebin.services');
    services.factory('Vowel', ['$resource', 'API', '$auth', function($resource, API, $auth) {
        return $resource(API + '/languages/:language_id/vowels/:vowel_id');
    }]);
})();
