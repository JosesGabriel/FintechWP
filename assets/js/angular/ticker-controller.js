var app = angular.module('arbitrage', ['ngSanitize','ngEmbed','ngNumeraljs','yaru22.angular-timeago','luegg.directives']);
app.run(['$rootScope', '$http', function($rootScope, $http) {

}]);
app.controller('ticker', ['$scope','$filter', '$http', function($scope, $filter, $http) {
    $scope.ticker = [];
    var counter = 1;

    socket.on('psec', function (data) {  
        var ctr = counter += 1;
        var transaction = {
            counter: ctr,
            symbol: data.sym,
            price:  price_format(data.prv),
            change: data.chg,
            shares: abbr_format(data.vol)
        };
        $scope.ticker.push(transaction);
        ticker_data_ralph.push(transaction);
        if ($scope.ticker.length > 50) {
            $scope.ticker.shift();
        }

        if (ticker_data_ralph.length > 150) {
            ticker_data_ralph.pop();
        }
        $scope.$digest();
    });
    $scope.select = goToChart;
}]);