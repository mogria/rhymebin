(function(){
    var services = angular.module('rhymebin.services');
    services.factory('Word', ['$resource', 'API', function($resource, API) {
        return $resource(API + '/languages/:language_id/words/:word_id');
    }]);
})();
