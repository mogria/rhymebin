angular.module('rhymebin', [
    'ui.router',
    'rhymebin.controllers.HomeController'
]).config(['$stateProvider', function($stateProvider) {
    $stateProvider.state('default', {
        'views': {
            'content': {
                'controller': 'HomeController',
                'templateUrl': 'template-home'
            }
        }
    }).otherwise({redirectTo: '/'}); 
}]);

// angular.bootstrap(document, ['rhymebin']);