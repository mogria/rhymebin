(function(){
    var app = angular.module('rhymebin.services.Vowel', ['ngResource']);
    app.factory('Vowel', ['$resource', 'API', '$auth', function($resource, API, $auth) {
        return $resource(API + '/vowels/:id');
    }]);
})();
