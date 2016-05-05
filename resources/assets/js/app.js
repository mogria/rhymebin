angular.module('rhymebin', [
    'ui.router',
    'satellizer',
    'rhymebin.controllers.HomeController',
    'rhymebin.controllers.LoginController'
])
.constant('API', '/api')
.config(['$stateProvider', '$authProvider', 'API', function($stateProvider, $authProvider, API) {
    $authProvider.loginUrl = API + '/login';
    
    $stateProvider
        .state('login', {
            'url': '/login',
            'views': {
                'content': {
                    'controller': 'LoginController',
                    'templateUrl': 'template-login'
                }
            }
        })
        .state('wordEntry', {
            'url': '/words/new'
        })
        .state('home', { // this state needs to be last because it uses the "*path" catchall syntax
            'url': '*path',
            'views': {
                'content': {
                    'controller': 'HomeController',
                    'templateUrl': 'template-home'
                }
            }
        });
}])
