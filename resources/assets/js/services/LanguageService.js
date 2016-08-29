(function() {
    var services = angular.module('rhymebin.services');
    services.factory('LanguageService', ['Language', '$q', '$rootScope', '$sessionStorage', function(Language, $q, $rootScope, $sessionStorage) {
        var selectedLanguage = undefined;
        var availableLanguagesCache = []
        var languageChangedHandlers = []
        var fireLanguageChangedHandlers = function(newLanguage) {
            for(var handlerNum in languageChangedHandlers) {
                var handler = languageChangedHandlers[handlerNum];
                handler(newLanguage);
            }
        };

        var changeLanguage = function(language) {
            $sessionStorage.selectedLanguage = selectedLanguage = language;
            fireLanguageChangedHandlers(language);
        }
                
        var service = {
            availableLanguages: function() {
                return $q(function(resolve, reject) {
                    if(availableLanguagesCache.length < 1) {
                        Language.query(function(languages) {
                            availableLanguagesCache = languages;
                            resolve(availableLanguagesCache)
                        });
                        // @TODO: implement the reject(), in case no languages can be retrieved
                    } else {
                        resolve(availableLanguagesCache)
                    }
                })
            },
            selectedLanguage: function() {
                return selectedLanguage;
            },
            selectLanguage: function(language, callback) {
                var searchId = typeof language === 'number' ? language : language.id;
                var availableLanguages = this.availableLanguages();
                var that = this;
                this.availableLanguages().then(function(availableLanguages) {
                    var newSelectedLanguage = availableLanguages.find(function(language) {
                        return language.id == searchId;
                    })
                    if(newSelectedLanguage.id !== selectedLanguage.id) {
                        changeLanguage(newSelectedLanguage);
                    }
                    callback();
                }, function() {
                });
            },
            addLanguageChangedHandler: function(handler) {
               languageChangedHandlers.push(handler);
            },
            clearLanguageChangedHandlers: function() {
                languageChangedHandlers = [];
            },
            loadSelectedLanguage: function() {
                selectedLanguage = $sessionStorage.selectedLanguage;
                if(!selectedLanguage) {
                    this.availableLanguages().then(function(availableLanguages) {
                        if(availableLanguages[0]) {
                            changeLanguage(availableLanguages[0]);
                        }
                    })
                }
            }
        };
        service.loadSelectedLanguage();
        return service;
    }]);
})();
