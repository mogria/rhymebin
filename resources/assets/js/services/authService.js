(function(){
    var app = angular.module('rhymebin.services.authService', ['ngResource']);
    app.factory('authService', ['$auth', '$q', 'API', '$http', function($auth, $q, API, $http) {
        return {
            refreshInterval: -1,
            login: function(name, password) {
                var that = this;
                return $q(function(resolve, reject) {
                    $auth.login({'name': name, 'password': password}).then(function(response) {
                        $auth.setToken(response.data.token);
                        this.refreshInterval = setInterval(function() {
                           that.refresh(); 
                        }, 1000 * 60 * 10); //refresh token every 10 minutes
                        resolve(true);
                    }).catch(reject);
                });
            },
            logout: function() {
                if(this.refreshInterval !== -1) {
                    clearInterval(this.refreshInterval);
                    this.refreshInterval = -1;
                }
                return $auth.logout();
            },
            refresh: function() {
                var that = this;
                $http.post(API + '/refresh').success(function(response) {
                    $auth.setToken(response.token);
                }).error(function() {
                    that.logout();
                })
            },
            isAuthenticated: function() {
                return $auth.isAuthenticated();
            }
        }
    }]);
})();