(function() {
    var controllers = angular.module('rhymebin.controllers');

    controllers.controller('NavController', ['$scope', '$rootScope', 'authService', '$state', function($scope, $rootScope, authService, $state) {
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
