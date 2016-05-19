angular.module('rhymebin', [
    , 'ui.router'
    , 'satellizer'
    , 'ngResource'
    , 'rhymebin.directives.formValidation'
    , 'rhymebin.services.Word'
    , 'rhymebin.services.Language'
    , 'rhymebin.services.Vowel'
    , 'rhymebin.services.authService'
    , 'rhymebin.controllers.HomeController'
    , 'rhymebin.controllers.NavController'
    , 'rhymebin.controllers.AboutController'
    , 'rhymebin.controllers.LoginController'
    , 'rhymebin.controllers.RegisterController'
    , 'rhymebin.controllers.WordEntryController'
    , 'rhymebin.controllers.VowelSelectionController'
])
.constant('API', '/api')
.config([ '$urlRouterProvider'
        , '$authProvider'
        , 'API'
        , function( $urlRouterProvider
                  , $authProvider
                  , API) {
                      
    $urlRouterProvider.otherwise("/");
    $authProvider.loginUrl = API + '/login';
    $authProvider.signupUrl = API + '/users';
        
}])
