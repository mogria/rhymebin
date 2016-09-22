(function() {
    var services = angular.module('rhymebin.services');
    services.factory('RhymeService', ['LanguageService', '$http', 'API', function(LanguageService, $http, API) {
        return {
            'search': function(searchTerm, success, error) {
                $http.get(API + '/languages/' + LanguageService.selectedLanguage().id + '/words/rhymes', {
                    'params': {
                        'search': searchTerm
                    }
                }).then(success, error || function() {});
            }
        };
    }]);
})();
