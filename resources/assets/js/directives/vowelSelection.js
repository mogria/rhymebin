(function(){
    var directives = angular.module('rhymebin.directives');

    directives.directive('vowelSelection', [function() {
            return {
                restrict: 'E',
                link: function($scope, element, attr) {
                    var getVowelById = function (id) {
                        return $scope.vowels.find(function(vowel) {
                            return vowel.id == id;
                        });
                    };

                    var updateSelectedVowel = function() {
                        $scope.selectedVowel = getVowelById($scope.syllable.vowel_id);
                    };

                    var resetSelectedVowel = function() {
                        $scope.selectVowelForSyllable = undefined;
                        $scope.select = false;
                    };

                    resetSelectedVowel();

                    updateSelectedVowel();
                    $scope.$watch("syllable.vowel_id", updateSelectedVowel);

                    $scope.selectVowel = function(syllable) {
                        if($scope.select) {
                            resetSelectedVowel();
                        } else {
                            $scope.selectVowelForSyllable = syllable;
                            $scope.select = true;
                        }
                    };
                    $scope.vowelSelected = function(vowel) {
                        if($scope.selectVowelForSyllable) {
                            $scope.syllable.vowel_id = vowel.id;
                        }
                        resetSelectedVowel();
                    }
                },
                templateUrl: 'template-word-vowel-selection'
            };
        }
    ]);
})();
