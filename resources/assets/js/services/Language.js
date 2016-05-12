(function(){
    var app = angular.module('rhymebin.services.Language', ['ngResource']);
    app.factory('Language', ['$resource', 'API', '$auth', function($resource, API, $auth) {
        return $resource(API + '/languages/:id');
    }]);
})();