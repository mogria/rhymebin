(function(){
    var app = angular.module('rhymebin.directives.formValidation', []);
    
    // add this to a <form> tag.
    // set the $scope.errors variable like this:
    // {
    //    'formField': ['error message1', 'error message 2'],
    //    'otherField': ['only one error message']
    // }
    //
    // the errorFor directive then displays these errors
    app.directive('remoteValidate', [
        function() {
            return {
                link: function(scope, element, attr) {
                    var form = element.inheritedData('$formController');
                    // no need to validate if form doesn't exist
                    if (!form) return;
                    
                    scope.form = form;

                    // watch validate changes to display validation
                    scope.$watch("errors", function(errorBag) {

                        // every server validation should reset others
                        // note that this is form level and NOT field level validation
                        form.$serverError = { };

                        // if errors is undefined or null just set invalid to false and return
                        if (!errorBag) {
                            form.$serverInvalid = false;
                            return;
                        }
                        // set $serverInvalid to true|false
                        form.$serverInvalid = (errorBag.length > 0);

                        // loop through errors
                        angular.forEach(errorBag, function(errors, i) {
                            form.$serverError[i] = { $invalid: true, messages: errors };
                        });
                    });
                }
            };
        }
    ])
    
    // html element to display errors for a field
    app.directive('errorsFor', [
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
                templateUrl: 'template-errors-for'
            };
        }
    ]);
})();