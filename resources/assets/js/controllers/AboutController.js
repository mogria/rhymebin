(function() {
    var controllers = angular.module('rhymebin.controllers');
    
    controllers.controller('AboutController', ['$scope', function($scope) {
    }]);
    
    controllers.config(['$stateProvider', function($stateProvider) {
        $stateProvider.state('about', { 
            'url': '/about',
            'views': {
                'content': {
                    'controller': 'AboutController',
                    'templateUrl': 'template-about'
                }
            }
        });
    }])
})();
