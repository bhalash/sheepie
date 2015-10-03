var sheepieApp = angular.module('sheepieApp', []);

sheepieApp.controller('SearchController', ['$scope', function(scope) {
    scope.showSearch = false;

    scope.flick = function() {
        scope.showSearch = !scope.showSearch;

        console.log(this);
    }

    scope.esc = function(keyCode) {
        if (keyCode === 27) {
            // Check if input is focused.
            scope.showSearch = false;
        }
    }
}]);
