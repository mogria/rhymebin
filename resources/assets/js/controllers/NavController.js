(function() {
    var app = angular.module('rhymebin.controllers.NavController', ['ui.router']);

    app.controller('NavController', ['$scope', '$rootScope', 'authService', '$state', function($scope, $rootScope, authService, $state) {
        $scope.currentUrl = '/';
        $scope.loggedIn = authService.isAuthenticated();
        
        $rootScope.$on('$stateChangeStart',function(){
            $scope.loggedIn = authService.isAuthenticated();
        });
        
        $rootScope.$on('$stateChangeSuccess', function() {
            $scope.currentUrl = $state.current.url;
        });

        $scope.logout = function() {
            authService.logout();
            $state.go('home');
        };
    }]);
})();
