
app.directive('changeAlt', ['$timeout', function($timeout) {
    return {
        link: function (scope, element, attr) {

            scope.$watch(attr.changeAlt, function(newValue, oldValue) {

                if (oldValue && oldValue.trades != newValue.trades) {

                    if (newValue.last > oldValue.last) {
                        element.addClass('bg-green-transparent-2');
                    } else if (newValue.last < oldValue.last) {
                        element.addClass('bg-red-transparent-2');
                    } else {
                        element.addClass('bg-yellow-transparent-2');
                    }

                    $timeout(function () {
                      element.removeClass('bg-green-transparent-2 bg-red-transparent-2 bg-yellow-transparent-2');
                    }, 1000);

                }

            }, true);

        }
    }
}]);

app.directive("change", ['$timeout', function($timeout) {
    return {
        link: function (scope, element, attr) {
            scope.$watch(attr.change, function(newValue, oldValue) {
                if (oldValue) {

                    if (newValue > oldValue) {
                        element.addClass('bg-green-transparent-2');
                    } else if (newValue < oldValue) {
                        element.addClass('bg-red-transparent-2');
                    } else {
                        element.addClass('bg-yellow-transparent-2');
                    }

                    $timeout(function () {
                        element.removeClass('bg-green-transparent-2 bg-red-transparent-2 bg-yellow-transparent-2');
                    }, 1000);

                }

            }, true);
        }
    }
}]);

app.directive("changediv", ['$timeout', function($timeout) {
    return {
        link: function (scope, element, attr) {
            scope.$watch(attr.changediv, function(newValue, oldValue) {
                if (oldValue) {

                    if (newValue > oldValue) {
                        element.addClass('bg-green');
                    } else if (newValue < oldValue) {
                        element.addClass('bg-danger');
                    } else {
                        element.addClass('bg-yellow');
                    }

                    $timeout(function () {
                      element.removeClass('bg-green bg-danger bg-yellow');
                    }, 1000);

                }

            }, true);
        }
    }
}]);