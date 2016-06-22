(function(){
    var directives = angular.module('rhymebin.directives');

    // html element to display errors for a field
    // can be used in combination with remoteValidate to show errors
    // from the api backend
    directives.directive('errorsFor', [
        function() {
            return {
                restrict: 'E',
                link: function(scope, element, attr) {
                    if(!element[0]) return;
                    if(!element[0].attributes["field"]) return;
                    
                    var field = element[0].attributes["field"].value;
                    // watch validate changes to display validation
                    scope.$watch("errors", function(errorBag) {
                        scope.show = false;
                        scope.messages = [];
                        if(!scope.form) return;
                        if(!scope.form.$serverError) return;
                        if(!scope.form.$serverError[field]) return;
                        
                        scope.show = scope.form.$serverError[field].$invalid;
                        scope.messages = scope.form.$serverError[field].messages;
                    });
                },
                scope: true,
                templateUrl: 'template-forms-errors-for'
            };
        }
    ]);
})();
