var app = angular.module('arbitrage', []);
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

function price_format(value, base) {
    try {
        value = typeof value == 'string' ? value.replaceAll(',','') : value;
        value = parseFloat(value).toFixed(4);
    } catch(err) { }
    if (typeof base === 'object' || base == undefined) {
        base = value;
    }
    base = numeral(base).value();
    if (base >= 1000) {
        return number_format(value, '0,0');
    } else if (base >= 0.5) {
        return number_format(value, '0,0.00');
    } else if (base >= 0.1) {
        return number_format(value, '0,0.000');
    } else {
        return number_format(value, '0,0.0000');
    }
}
function number_format(value, format) {
    
    return numeral(parseFloat(value).toFixed(4)).format(format);
}
function abbr_format(value) {
    value = numeral(value);
    if (value.value() >= 1000000000) {
        return value.format('0.000a');
    } else if (value.value() >= 1000000) {
        if (value.value() % 1000000 == 0) {
            return value.format('0a');
        } else if (value.value() % 100000 == 0) {
            return value.format('0.0a');
        } else {
            return value.format('0.00a');
        }
    } else if (value.value() >= 10000) {
        if (value.value() % 1000 == 0) {
            return value.format('0a');
        } else if (value.value() % 100 == 0) {
            return value.format('0.0a');
        } else {
            return value.format('0.00a');
        }
    } else {
        return value.format('0,0');
    }
}