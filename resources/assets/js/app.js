angular.module('rhymebin', [
    , 'ui.router'
    , 'satellizer'
    , 'ngResource'
    , 'rhymebin.directives'
    , 'rhymebin.services'
    , 'rhymebin.controllers'
])
.constant('API', '/api')
.config([ '$urlRouterProvider'
        , '$authProvider'
        , '$httpProvider'
        , 'API'
        , function( $urlRouterProvider
                  , $authProvider
                  , $httpProvider
                  , API) {
                      
    $urlRouterProvider.otherwise("/");
    $authProvider.loginUrl = API + '/login';
    $authProvider.signupUrl = API + '/users';

    $httpProvider.interceptors.push('httpErrorHandlerService');
}])
