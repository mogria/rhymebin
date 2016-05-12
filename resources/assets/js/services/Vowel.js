(function(){
    var app = angular.module('rhymebin.services.Vocal', ['ngResource']);
    app.factory('Vocal', ['$resource', 'API', '$auth', function($resource, API, $auth) {
        return $resource(API + '/vocals/:id');
    }]);
})();
