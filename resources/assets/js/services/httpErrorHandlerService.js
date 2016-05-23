(function() {
    var services = angular.module('rhymebin.services');
    services.factory('httpErrorHandlerService', ['$q', '$injector', function($q, $injector) {
        var errorHandlers = [{
                pattern: /Token expired/,
                recoverable: true,
                handler: function(rejection) {
                    var authService = $injector.get('authService');
                    authService.refresh();
                }
            }, {
                pattern: /Token not provided/,
                recoverable: false,
                handler: function(rejection) {
                    var $state = $injector.get('$state');
                    $state.go('login');
                }
            }
        ];

        var getErrorHandler = function(rejection) {
            console.log(rejection);
            for(index in errorHandlers) {
                
                if(!rejection.data || !rejection.data.error) continue;
                console.log(index);
                var errorHandler = errorHandlers[index];
                if(errorHandler.pattern.test(rejection.data.error)) {
                    return errorHandler;
                }
            }
            return null;
        }
        return {
            responseError: function(rejection) {
                var errorHandler = getErrorHandler(rejection);
                if(errorHandler) {
                    errorHandler.handler(rejection);
                }
                return $q.reject(rejection);
            }
        };
    }]);
})();
