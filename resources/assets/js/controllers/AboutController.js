(function() {
    var app = angular.module('rhymebin.controllers.AboutController', ['ui.router']);
    
    app.controller('AboutController', ['$scope', function($scope) {
    }]);
    
    app.config(['$stateProvider', function($stateProvider) {
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
