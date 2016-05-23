(function(){
    var services= angular.module('rhymebin.services');
    services.factory('Language', ['$resource', 'API', '$auth', function($resource, API, $auth) {
        return $resource(API + '/languages/:id');
    }]);
})();
