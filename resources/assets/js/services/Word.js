(function(){
    var app = angular.module('rhymebin.services.Word', ['ngResource']);
    app.factory('Word', ['$resource', 'API', function($resource, API) {
        return $resource(API + '/words/:id');
    }]);
})();