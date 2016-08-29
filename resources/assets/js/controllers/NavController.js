(function() {
    var controllers = angular.module('rhymebin.controllers');

    controllers.controller('NavController', ['$scope', '$rootScope', 'authService', '$state', 'LanguageService', function($scope, $rootScope, authService, $state, LanguageService) {
        $scope.nav = {
            currentUrl: '/',
            loggedIn: authService.isAuthenticated(),
            availableLanguages: [],
            language: undefined
        };

        LanguageService.availableLanguages().then(function(availableLanguages) {
            $scope.nav.availableLanguages = availableLanguages;
            $scope.nav.language = LanguageService.selectedLanguage();
        });
        

        $rootScope.$on('$stateChangeStart',function(){
            $scope.nav.loggedIn = authService.isAuthenticated();
        });
        
        $rootScope.$on('$stateChangeSuccess', function() {
            $scope.nav.currentUrl = $state.current.url;
            LanguageService.clearLanguageChangedHandlers();
        });

        $scope.logout = function() {
            authService.logout();
            $state.go('home');
        };

        $scope.$watch("nav.language", function() {
            if(!$scope.nav.language) return;
            LanguageService.selectLanguage($scope.nav.language, function() {
                $scope.nav.language = LanguageService.selectedLanguage();
            });
        });
    }]);
})();
