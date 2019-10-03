var app = angular.module('arbitrage', ['ngSanitize','ngEmbed','ngNumeraljs','yaru22.angular-timeago','luegg.directives']);
app.run(['$rootScope', '$http', function($rootScope, $http) {

}]);
app.controller('ticker', ['$scope', function($scope) {
    $scope.enable = true;
    $scope.ticker = [];

    socket.on('psec', function (data) {  
        var transaction = {
            symbol: data.sym,
            price:  price_format(data.prv),
            change: data.chg,
            shares: abbr_format(data.vol)
        };
        $scope.ticker.push(transaction);

        if ($scope.ticker.length > 50) {
            $scope.ticker.shift();
        }

        $scope.$digest();
    });
}]);