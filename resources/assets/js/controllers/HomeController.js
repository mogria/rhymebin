var app = angular.module('rhymebin.controllers.HomeController', []);
app.controller('HomeController', ['$scope', function($scope) {
    $scope.searchSubmit = function() {
        return false;
    };
        
}]);
