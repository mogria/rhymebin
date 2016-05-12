(function() {
    var app = angular.module('rhymebin.controllers.NavController', ['ui.router']);

    app.controller('NavController', ['$scope', '$rootScope', '$auth', '$state', function($scope, $rootScope, $auth, $state) {
        $scope.currentUrl = '/';
        $scope.loggedIn = $auth.isAuthenticated();
        
        $rootScope.$on('$stateChangeStart',function(){
            $scope.loggedIn = $auth.isAuthenticated();
        });
        
        $rootScope.$on('$stateChangeSuccess', function() {
            $scope.currentUrl = $state.current.url;
        });

        $scope.logout = function() {
            $auth.logout();
            $state.go('home');
        };
    }]);
})();
