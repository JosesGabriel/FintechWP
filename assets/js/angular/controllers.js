var widget;
var chart;
var marketdepthTimeout;
var INDICES = ['PSEI','ALL','FIN','HDG','IND','M-O','PRO','SVC'];
var app = angular.module('arbitrage', ['ngSanitize','ngEmbed','ngNumeraljs','yaru22.angular-timeago','luegg.directives']);
app.run(['$rootScope', '$http', function($rootScope, $http) {
    $rootScope.newMessages = 0;
    $rootScope.stockList = [];
    $rootScope.selectedSymbol = _symbol;

    $http.get("https://data-api.arbitrage.ph/api/v1/stocks/list")
        .then(function(response) {
            $rootScope.stockList = response.data.data;
            _stocks = response.data.data;
        })
}]);
app.controller('message-notification', function($scope, $http, $filter) {
    $scope.count = 0;
    $http.get("/welcome/threads").then( function (response) {
        $scope.messages = response.data.data;
        $scope.count = $scope.messages.reduce( function(a, b) {
            if (b.status == 1) a++;
            return a;
        }, 0);
    });
    socket.on('message-update', function() {
        $http.get("/welcome/threads").then( function (response) {
            $scope.messages = response.data.data;
            $scope.count = $scope.messages.reduce( function(a, b) {
                if (b.status == 1) a++;
                return a;
            }, 0);
        });
    });
    socket.on('connect', function() {
        socket.emit('subscribe','user.' + _user_id);
    });
    socket.on('reconnect', function() {
        socket.emit('subscribe','user.' + _user_id);
    });
});
app.controller('template', function($scope, $http) {
    var settings = {
        chart: '1',
        chat: '0',
        ticker: '2',
        left: '1',
        right: '1',
        disclosure: '1',
    };
    var new_settings = JSON.parse(localStorage.getItem('settings'));
    if (new_settings) {
        jQuery.extend(settings, new_settings);
    }
    $scope.settings = settings;
    $scope.updateSettings = function(key) {
        localStorage.setItem('settings', JSON.stringify($scope.settings));
    }
    $scope.marketopen = false;
    socket.on('servertime', function(data) {
        $scope.marketopen = data.is_market_open == '1';
    });
});
app.controller('ticker', ['$scope','$filter', '$http', function($scope, $filter, $http) {
    $scope.ticker = [];
    socket.on('connect', function(data) {
        socket.emit('subscribe','transactions');
        socket.emit('subscribe','ticker');
    });
    socket.on('reconnect', function(data) {
        socket.emit('subscribe','transactions');
        socket.emit('subscribe','ticker');
    });
    socket.on('psec', function (data) {
        var transaction = {
            symbol: data.sym,
            price:  price_format(data.prv),
            change: data.chg,
            shares: abbr_format(data.vol),
        };
        $scope.ticker.push(transaction);
        if ($scope.ticker.length > 150) {
            $scope.ticker.pop();
        }
        $scope.$digest();
    });
    socket.on('transaction', function(data) {
        var change = 0;
        if (data.flag == 0) {
            change = 1;
        } else if (data.flag == 1) {
            change = -1;
        }
        var transaction = {
            symbol: data.symbol,
            price:  price_format(data.price),
            change: change,
            shares: abbr_format(data.volume),
            buyer:  data.buyer.substr(0, 5).trim(),
            seller: data.seller.substr(0, 5).trim(),
        };
        $scope.ticker.push(transaction);
        if ($scope.ticker.length > 150) {
            $scope.ticker.pop();
        }
        $scope.$digest();
    });
    socket.on('CT', function(data) {
        var transaction = {
            symbol: data[0],
            price:  price_format(data[1]),
            shares: number_format(data[2],'0,0.00') + '%',
            buyer:  abbr_format(data[3]),
            seller: abbr_format(data[4]),
            flag:   data[5],
            change: data[2],
        }
        $scope.ticker.push(transaction);
        /*if ($scope.ticker.length > 50) {
            $scope.ticker.pop();
        }*/
        $scope.$digest();
    });
    $scope.select = goToChart;
}]);
app.controller('psei', function($scope, $http) {  
    $scope.psei = {last: 0, chg: 0, diff: 0, prev: 0};
    // function updatePSEI() {
        $http.get("/api/psei").then(function (response) {
            if (response.data.success) {
                $scope.psei.last = parseFloat(response.data.data.c);
                $scope.psei.previous = parseFloat(response.data.data.p);
                $scope.psei.difference = $scope.psei.last - $scope.psei.previous;
                $scope.psei.change = ($scope.psei.difference / $scope.psei.previous) * 100;
            }
        });
    // }
    // setInterval(updatePSEI, 20000);
    // updatePSEI();
    socket.on('connect', function(data) {
        socket.emit('subscribeBars3', 'test.PSEI_D', 'PSEI');
    });
    socket.on('reconnect', function(data) {
        socket.emit('subscribeBars3', 'test.PSEI_D', 'PSEI');
    });
    socket.on('tick2', function(data) {
        if (data.listenerGuid == 'PSEI_D') {
            $scope.psei.last = parseFloat(data.c);
            $scope.psei.previous = parseFloat(data.p);
            $scope.psei.difference = $scope.psei.last - $scope.psei.previous;
            $scope.psei.change = ($scope.psei.difference / $scope.psei.previous) * 100;
        }
    });
});
app.controller('chart', ['$scope','$filter', '$http', '$rootScope', function($scope, $filter, $http, $rootScope) {
    var vm = this;
    vm.Total = 0;
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    $scope.$watch('$root.stockList', function () {
        $scope.stock_details = $rootScope.stockList;
    });
    $scope.gainers      = 0;
    $scope.losers       = 0;
    $scope.unchanged    = 0;
    $scope.stocks = [];
    $scope.watchlists = {
        'All Stocks': 'stocks', 
        'New Watchlist': 'new',
        'Default Watchlist': JSON.parse(localStorage.getItem('watchlist')) || [],
    };
    $scope.watchlist = 'All Stocks';
    $scope.lastWatchlist = 'All Stocks';
    $scope.sort = 'value';
    $scope.reverse  = true;
    $scope.stock        = null;
    $scope.marketdepth  = [];
    $scope.transactions = [];
    $scope.bidtotal = 0;
    $scope.asktotal = 0;
    $scope.bidperc = 0;
    $scope.askperc = 0;
    $scope.fullbidtotal = 0;
    $scope.fullasktotal = 0;
    $scope.fullbidperc = 0;
    $scope.fullaskperc = 0;
    $scope.dshowsentiment = '';
    $rootScope.selectedSymbol = $scope.selectedStock = _symbol;
    socket.on('connect', function(data) {
        socket.emit('stock', $scope.selectedStock);
    });
    socket.on('reconnect', function(data) {
        socket.emit('stock', $scope.selectedStock);
    });
    $scope.watchlistReady = false;
    $scope.selectWatchlist = function(watchlist) {
        if (watchlist == 'new') {
            if (_user_id == 'public_user') {
                if (confirm('Please login to create additional watchlist')) {
                    window.location.href = '/login';
                    $scope.watchlist = $scope.lastWatchlist;
                }
                $scope.watchlist = $scope.lastWatchlist;
                return false;
            }
            var watchlistName = prompt('Watchlist Name:');
            if (watchlistName) {
                watchlistName = watchlistName.trim();
            }
            if (watchlistName) {
                if ( ! $scope.watchlists[watchlistName]) {
                    $scope.watchlists[watchlistName] = [];
                    $http.post("/api/watchlist-add", $.param({watchlist: watchlistName})).then( function (response) {
                    });
                    $.gritter.add({
                        title: 'Success',
                        text: "Watchlist has been successfully created<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
                        time: 5000,
                        class_name: nightmode ? "gritter-dark" : "gritter-light",
                    });
                }
                $scope.watchlist = watchlistName;
                $scope.lastWatchlist = watchlistName;
            } else {
                $scope.watchlist = $scope.lastWatchlist;
            }
        } else if (watchlist == 'stocks') {
        } else {
            $scope.lastWatchlist = $scope.watchlist;
        }
        $('#watchlist-scroll').slimScroll({ scrollTo : '0px' });
    }
    $scope.addToWatchlist = function(symbol) {
        if (_user_id == 'public_user')  {
            if ($scope.watchlists['Default Watchlist'].indexOf(symbol) === -1) {
                $scope.watchlists['Default Watchlist'].push(symbol);
                localStorage.setItem('watchlist', JSON.stringify($scope.watchlists['Default Watchlist']));
            }
            $.gritter.add({
                title: 'Success',
                text: symbol + " has been successfully added to you watchlist<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
                time: 5000,
                class_name: nightmode ? "gritter-dark" : "gritter-light",
            });
            return;
        }
        watchlist = prompt('Add ' + symbol + 'to Watchlist:', $scope.lastWatchlist);
        if (watchlist) {
            watchlist = watchlist.trim();
        }
        if (watchlist && watchlist.length > 0) {
            if ($scope.watchlists[watchlist]) {
                $scope.watchlists[watchlist].push(symbol);
                $http.post("/api/watchlist-add", $.param({watchlist: watchlist, symbol: symbol})).then( function (response) {
                });
                $.gritter.add({
                    title: 'Success',
                    text: symbol + " has been successfully added to you watchlist<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
                    time: 5000,
                    class_name: nightmode ? "gritter-dark" : "gritter-light",
                });
            } else {
                $scope.watchlists[watchlist] = [symbol];
                $scope.watchlist = watchlist;
                $http.post("/api/watchlist-add", $.param({watchlist: watchlist, symbol: symbol})).then( function (response) {
                });
                $.gritter.add({
                    title: 'Success',
                    text: "Watchlist has been successfully created<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
                    time: 5000,
                    class_name: nightmode ? "gritter-dark" : "gritter-light",
                });
            }
            $scope.lastWatchlist = watchlist;
        }
    }
    $scope.addStockToWatchlist = function(watchlist) {
        symbol = prompt('Stock Symbol:', _symbol);
        if (symbol) {
            symbol = symbol.toUpperCase().trim();
        }
        if (symbol && symbol.length > 0 && watchlist.indexOf(symbol) === -1) {
            watchlist.push(symbol);
            if (_user_id == 'public_user' && $scope.watchlist == 'Default Watchlist')  {
                localStorage.setItem('watchlist', JSON.stringify($scope.watchlists['Default Watchlist']));
                $.gritter.add({
                    title: 'Success',
                    text: symbol + " has been successfully added to you watchlist<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
                    time: 5000,
                    class_name: nightmode ? "gritter-dark" : "gritter-light",
                });
                return;
            }
            $http.post("/api/watchlist-add", $.param({watchlist: $scope.watchlist, symbol: symbol})).then( function (response) {
            });
            $.gritter.add({
                title: 'Success',
                text: symbol + " has been successfully added to your watchlist<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
                time: 5000,
                class_name: nightmode ? "gritter-dark" : "gritter-light",
            });
        }
    }
    $scope.deleteWatchlist = function(watchlist) {
        if (_user_id == 'public_user') {
            return;
        }
        if (confirm('Are you sure you want to delete "' + watchlist + '"?')) {
            delete $scope.watchlists[watchlist];
            $scope.watchlist = 'All Stocks';
            $scope.lastWatchlist = 'Default Watchlist';
            $http.post("/api/watchlist-delete", $.param({watchlist: watchlist})).then( function (response) {
            });
            $.gritter.add({
                title: 'Success',
                text: '"' + watchlist + "\" has been successfully deleted<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
                time: 5000,
                class_name: nightmode ? "gritter-dark" : "gritter-light",
            });
        }
    }
    $scope.removeFromWatchlist = function(watchlist, symbol) {
        if (confirm('Are you sure you want to remove ' + symbol.toUpperCase() + ' from your watchlist?')) {
            watchlist.splice(watchlist.indexOf(symbol), 1);
            if (_user_id == 'public_user' && $scope.watchlist == 'Default Watchlist')  {
                localStorage.setItem('watchlist', JSON.stringify($scope.watchlists['Default Watchlist']));
                $.gritter.add({
                    title: 'Success',
                    text: symbol.toUpperCase() + " has been successfully removed from your watchlist<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
                    time: 5000,
                    class_name: nightmode ? "gritter-dark" : "gritter-light",
                });
                return;
            }
            $http.post("/api/watchlist-delete", $.param({watchlist: $scope.watchlist, symbol: symbol})).then( function (response) {
            });
            $.gritter.add({
                title: 'Success',
                text: symbol.toUpperCase() + " has been successfully removed from your watchlist<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
                time: 5000,
                class_name: nightmode ? "gritter-dark" : "gritter-light",
            });
        }
    }
    $http.get("https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE").then( function (response) {
        stocks = response.data.data;
        stocks = Object.values(stocks);
        stocks.map(function(stock) {
            stock['last']       = parseFloat(stock['last']);
            stock['difference'] = parseFloat(stock['difference']);
            stock['change']     = parseFloat(stock['change']);
            stock['change_percentage'] = parseFloat(stock['changepercentage']);
            stock['previous']   = parseFloat(stock['close']);
            stock['open']       = parseFloat(stock['open']);
            stock['high']       = parseFloat(stock['high']);
            stock['low']        = parseFloat(stock['low']);
            stock['average']    = parseFloat(stock['average']);
            stock['volume']     = parseFloat(stock['volume']);
            stock['value']      = parseFloat(stock['value']);
            stock['trades']     = parseFloat(stock['trades']);
            stock['displayLast']  = price_format(stock['last']);
            stock['displayDifference']  = price_format(stock['change']);
            stock['displayOpen']  = price_format(stock['open']);
            stock['displayPrevious']  = price_format(stock['close']);
            stock['displayAverage']  = price_format(stock['average']);
            stock['displayLow']  = price_format(stock['low']);
            stock['displayHigh']  = price_format(stock['high']);
            stock['displayChange']  = number_format(stock['changepercentage'], '0,0.00');
            stock['displayValue'] = abbr_format(stock['value']);
            stock['weekYearLow'] = price_format(stock['weekyearlow']);
            stock['weekYearHigh'] = price_format(stock['weekyearhigh']);
            stock['displayMarketCap'] = abbr_format(stock.marketcap).toUpperCase();
            return stock;
        });

        
        
        $scope.stocks = stocks;
        $scope.count = $scope.stocks.reduce( function(a, b) {
            if (b.change < 0) {
                a.losers = ++a.losers || 1;
            }  
            if (b.change === 0) {
                a.unchanged = ++a.unchanged || 1;
            }  
            if (b.change > 0) {
                a.gainers = ++a.gainers || 1;
            }
            return a;
        }, {});
        
        $scope.stock = $filter('filter')($scope.stocks, {symbol: _symbol}, true)[0];
        // jQuery.extend($scope.watchlists, JSON.parse(localStorage.getItem('watchlists')));
        // IF LOGGED IN
        /*$http.get("/api/watchlists").then( function (response) {
            jQuery.extend($scope.watchlists, response.data.data);
            // $http.post("/api/watchlists", $.param({watchlists: JSON.stringify($scope.watchlists)})).then( function (response) {
            //     console.log(response.data)
            // });
            $scope.watchlist = 'All Stocks';
            $scope.watchlistReady = true;
        });*/
        $http.get("https://arbitrage.ph/charthisto/?g=md").then( function (response) {
            if (response.data.success) {
                // $scope.marketdepth = response.data.data;
                $scope.marketdepth = response;
            }
        });

        socket.emit('stock', _symbol, function(data) {
            if (data.transactions) {
                $scope.transactions = data.transactions;
            }
            if (data.bidask && $scope.marketdepth.length == 0) {
                $scope.marketdepth = data.bidask;
            }
        });
    });
    let limit = 20;
    $http.get('https://data-api.arbitrage.ph/api/v1/stocks/trades/latest?exchange=PSE&broker=true&sort=DESC&symbol=' + _symbol + '&limit=' + limit)
        .then(response => {
            response = response.data;
            if (!response.success) {
                return;
            }

            let data = response.data;

            $scope.transactions = data.map(transaction => {
                let full_time = new Intl.DateTimeFormat('en-US', {timeStyle: 'short'}).format(new Date(transaction.timestamp * 1000));
                
                return {
                    symbol: transaction.symbol,
                    price:  price_format(transaction.executed_price),
                    shares: abbr_format(transaction.executed_volume),
                    buyer:  transaction.buyer,
                    seller: transaction.seller,
                    time:   full_time,
                };                                    
            });
            $scope.$digest();
        });
    socket.on('psec', function (data) {
        let date = (new Date(0)).setUTCSeconds(data.t);
        let full_date = new Intl.DateTimeFormat('en-US', {dateStyle: 'medium'}).format(date);
        let full_time = new Intl.DateTimeFormat('en-US', {timeStyle: 'short'}).format(date);
        let stock = {
            id: data.sym,
            symbol: data.sym,
            date: full_date,
            last: data.prv,
            difference: data.chgpc,
            change: data.chg,
            change_percentage: data.chgpc,
            previous: data.c,
            open: data.o,
            high: data.h,
            low: data.l,
            average: data.avg,
            volume: data.vol,
            value: data.val,
            trades: data.tr,
            updated_at: full_date,

            displayLast: price_format(data.prv),
            displayDifference: price_format(data.chg, data.prv),
            displayOpen: price_format(data.o),
            displayPrevious: price_format(data.c),
            displayAverage: price_format(data.avg),
            displayLow: price_format(data.l),
            displayHigh: price_format(data.h),
            displayChange: number_format(data.chgpc, '0,0.00'),
            displayValue: abbr_format(data.val),
        }

        // UPDATE STOCK
        var found = $filter('filter')($scope.stocks, {symbol: stock.symbol}, true);
        var current_stock_index = null;
        if (found.length) {
            current_stock_index = $scope.stocks.indexOf(found[0]);
            $scope.stocks[current_stock_index] = Object.assign($scope.stocks[current_stock_index], stock);
        } else $scope.stocks.push(stock);

        if ($scope.stock && $scope.stock.symbol == stock.symbol) {
            if ($scope.$parent.settings.chart == '1') {
                beep();
                if (stock.change > 0){changicotogreen();}
				if (stock.change < 0){changicotored();}
            }
            setTitle(stock.symbol, stock.displayLast, stock.displayChange);

            if (current_stock_index) {
                $scope.stock = $scope.stocks[current_stock_index];
            } else {
                $scope.stock = stock;
            }
        }
        
        $scope.count = $scope.stocks.reduce( function(a, b) {
            if (b.change < 0) {
                a.losers = ++a.losers || 1;
            }  
            if (b.change === 0) {
                a.unchanged = ++a.unchanged || 1;
            }  
            if (b.change > 0) {
                a.gainers = ++a.gainers || 1;
            }
            return a;
        }, {});

        $scope.$digest();
    });

    socket.on('pse-transaction', function (data) {
        if ($scope.stock && $scope.stock.symbol == data.sym) {
            let full_time = new Intl.DateTimeFormat('en-US', {timeStyle: 'short'}).format(new Date(data.t * 1000));
            let transaction = {
                symbol: data.sym,
                price:  price_format(data.exp),
                shares: abbr_format(data.exvol),
                buyer:  data.b,
                seller: data.s,
                time:   full_time,
            };
    
            $scope.transactions.unshift(transaction);
            if ($scope.transactions.length > 20) {
                $scope.transactions.pop();
            }
            
            $scope.$digest();
        }
    });

    socket.on('T', function(data) {
        var symbol = data[0];
        data[4]  = parseFloat(data[4]);
        data[6]  = parseFloat(data[6]);
        data[5]  = parseFloat(data[5]);
        data[2]  = parseFloat(data[2]);
        data[3]  = parseFloat(data[3]);
        data[7]  = parseFloat(data[7]);
        data[8]  = parseFloat(data[8]);
        data[9]  = parseFloat(data[9]);
        data[10] = parseFloat(data[10]);
        data[11] = parseFloat(data[11]);
        data[12] = parseFloat(data[12]);
        var stock = {
            id: data[1] + '-' + symbol,
            symbol: symbol,
            date: data[1],
            last: data[4],
            difference: data[6],
            change: data[5],
            previous: data[2],
            open: data[3],
            high: data[7],
            low: data[8],
            average: data[9],
            volume: data[10],
            value: data[11],
            trades: data[12],
            updated_at: data[16],
        }
        stock['displayLast']  = price_format(stock['last']);
        stock['displayDifference']  = price_format(stock['difference'], stock['last']);
        stock['displayOpen']  = price_format(stock['open']);
        stock['displayPrevious']  = price_format(stock['previous']);
        stock['displayAverage']  = price_format(stock['average']);
        stock['displayLow']  = price_format(stock['low']);
        stock['displayHigh']  = price_format(stock['high']);
        stock['displayChange']  = number_format(stock['change'], '0,0.00');
        stock['displayValue'] = abbr_format(stock['value']);
        if ($scope.stock && $scope.stock.symbol == stock.symbol) {
            if ($scope.$parent.settings.chart == '1') {
                beep();
				if (stock.change > 0){changicotogreen();}
				if (stock.change < 0){changicotored();}
            }
            setTitle(stock.symbol, price_format(stock.last), number_format(stock.change, '0.00'));
            // if ($scope.transactions.length > 0) {
                var transaction = {
                    symbol: symbol,
                    price:  price_format(data[4]),
                    change: data[5],
                    shares: abbr_format(data[13]),
                    buyer:  data[14].substr(0, 5).trim(),
                    seller: data[15].substr(0, 5).trim(),
                    time:   data[16],
                }
                $scope.transactions.unshift(transaction);
                if ($scope.transactions.length > 20) {
                    $scope.transactions.pop();
                }
            // }
            $scope.stock = stock;
        }
        // UPDATE STOCK
        var found = $filter('filter')($scope.stocks, {symbol: symbol}, true);
        if (found.length) {
            $scope.stocks[$scope.stocks.indexOf(found[0])] = stock;
        } else $scope.stocks.push(stock);
        $scope.count = $scope.stocks.reduce( function(a, b) {
            if (b.change < 0) {
                a.losers = ++a.losers || 1;
            }  
            if (b.change === 0) {
                a.unchanged = ++a.unchanged || 1;
            }  
            if (b.change > 0) {
                a.gainers = ++a.gainers || 1;
            }
            return a;
        }, {});
    });
    socket.on('bidask', function(data) {
        if ($scope.marketdepth.length > 0) {
            data.index = data.index - 1;
            var found = $filter('filter')($scope.marketdepth, {index: data.index}, true);
            if (found.length) {
                $scope.marketdepth[$scope.marketdepth.indexOf(found[0])] = data;
            } else $scope.marketdepth.push(data);
        }
    });
    $scope.sortStocks = function(sort) {
        if ($scope.sort == sort) {
            $scope.reverse = !$scope.reverse;
        } else {
            $scope.reverse = false;
            $scope.sort = sort;
        }
    }
    $scope.select = function (symbol) {
        $rootScope.selectedSymbol = $scope.selectedStock = _symbol = symbol;
        var found = $filter('filter')($scope.stocks, {symbol: $scope.selectedStock}, true);
        if (found.length) {
            $scope.stock = $scope.stocks[$scope.stocks.indexOf(found[0])];
        } else {
            $scope.stock = null;
        }
        $scope.marketdepth  = [];
        $scope.transactions = [];
        if (marketdepthTimeout) {
            window.clearTimeout(marketdepthTimeout);
        }
        marketdepthTimeout = setTimeout( function() {
            goToChart(symbol);
        }, 100);
        $('#select-' + symbol).focus();
    };
    // TODO: ANGULARJS NATIVE TIMEOUT
    // function updateMarketDepth(force) {
    //     if ($scope.stock) {
    //         $http.get("//marketdepth.pse.tools/api/market-depth?symbol=" + $scope.stock.symbol).then(function (response) {
    //             if (force && response.data.success) {
    //                 $scope.marketdepth = response.data.data;
    //                 return;
    //             }
    //             if (response.data.success && $scope.marketdepth.length) {
    //                 for (var i = 5; i < response.data.data.length; i++) {
    //                     var bidask = response.data.data[i];
    //                     var found = $filter('filter')($scope.marketdepth, {index: bidask.index}, true);
    //                     if (found.length) {
    //                         $scope.marketdepth[$scope.marketdepth.indexOf(found[0])] = bidask;
    //                     } else $scope.marketdepth.push(bidask);
    //                 }
    //             }
    //         });
    //         $scope.bidtotal = 0;
    //         $scope.asktotal = 0;
    //         $scope.bidperc = 0;
    //         $scope.askperc = 0;
    //         var keepGoing = true;
    //         angular.forEach($scope.marketdepth, function(value, key) {
    //           if(keepGoing) {
    //             $scope.bidtotal += (!value.bid_volume ? 0 : parseInt(value.bid_volume));
    //             $scope.asktotal += (!value.ask_volume ? 0 : parseInt(value.ask_volume));
    //             if(key == 4){
    //               keepGoing = false;
    //             }
    //           }
    //         });
    //         $scope.bidperc = ($scope.bidtotal / ($scope.bidtotal + $scope.asktotal)) * 100;
    //         $scope.askperc = ($scope.asktotal / ($scope.bidtotal + $scope.asktotal)) * 100;
    //         $scope.fullbidtotal = 0;
    //         $scope.fullasktotal = 0;
    //         $scope.fullbidperc = 0;
    //         $scope.fullaskperc = 0;
    //         angular.forEach($scope.marketdepth, function(value, key) {
    //             $scope.fullbidtotal += (!value.bid_volume ? 0 : parseInt(value.bid_volume));
    //             $scope.fullasktotal += (!value.ask_volume ? 0 : parseInt(value.ask_volume));
    //         });
    //         $scope.fullbidperc = ($scope.fullbidtotal / ($scope.fullbidtotal + $scope.fullasktotal)) * 100;
    //         $scope.fullaskperc = ($scope.fullasktotal / ($scope.fullbidtotal + $scope.fullasktotal)) * 100;

    //     }
    // }
	// setInterval(updateMarketDepth, 5000);
}]);
app.controller('disclosures', function($scope, $http, $rootScope) {
    $scope.$watch('$root.stockList', function () {
        $scope.stocks = $rootScope.stockList;
    });
    $scope.disclosures = [];
    $http.get("/api/disclosures").then(function (response) {
        if (response.data.success) {
            $scope.disclosures = response.data.data;
        }
    });
    socket.on('disclosure', function(data) {
        if ($scope.$parent.settings.disclosure != '0') {
            $.gritter.add({
                title: 'Disclosure Notification',
                text: '<a href="javascript:void(0);" onclick="goToChart(\'' + data.symbol + '\')"><b>$' + data.symbol + '</b></a> | ' + $scope.stocks[data.symbol].description + '<br/>' +
                      data.template + '<br/>' +
                      '<a href="https://edge.pse.com.ph/openDiscViewer.do?edge_no=' + data.md5 + '" target="_blank" onclick="ga(\'send\', \'event\', \'disclosures\', \'notification\');">http://edge.pse.com.ph/openDiscViewer.do?edge_no=' + data.md5 + '</a><br/>' +
                      "<small class='text-muted'>You can disable disclosure notification under the site settings</small><div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
                time: 5000,
                image: "https://website.com/assets/images/logos/" + data.symbol + ".jpg",
                class_name: nightmode ? "gritter-dark" : "gritter-light",
            });
        }
        $scope.disclosures.unshift(data);
    });
    $scope.goToChart = function(symbol) {
        return goToChart(symbol);
    };
});
app.controller('tradingview', ['$scope','$filter', '$http', '$rootScope', function($scope, $filter, $http, $rootScope) {
    var dark_overrides = {
        "paneProperties.background":"#34495e",
        "paneProperties.gridProperties.color":"#7f8c8d",
        "paneProperties.vertGridProperties.color":"#7f8c8d",
        "paneProperties.horzGridProperties.color":"#95a5a6",
        "scalesProperties.lineColor":"#787878",
        "scalesProperties.textColor":"#D9D9D9",
        "symbolWatermarkProperties.color":"#808080",
        "symbolWatermarkProperties.transparency":90,
        "volumePaneSize": "tiny",
        "mainSeriesProperties.showCountdown": true,
        "scalesProperties.showStudyPlotLabels": true,
    };
    var light_overrides = {
        "paneProperties.background":"#ffffff",
        "paneProperties.gridProperties.color":"#e1ecf2",
        "scalesProperties.lineColor":"#555",
        "scalesProperties.textColor":"#555",
        "volumePaneSize": "tiny",
        "mainSeriesProperties.showCountdown": true,
        "scalesProperties.showStudyPlotLabels": true,
    };

    $(function() {
        TradingView.onready(function() {
			/* $(".vertical-box-inner-cell.ng-scope").append('<div class="chart_logo_arbitrage"><a href="https://arbitrage.ph/" target="_blank"><img src="https://arbitrage.ph/wp-content/uploads/2018/12/logo.png"></a></div>'); */
            var override = nightmode ? JSON.parse(JSON.stringify(dark_overrides)) : JSON.parse(JSON.stringify(light_overrides));
            override["paneProperties.background"] = "#2c3e50";
			override["paneProperties.gridProperties.color"] = "#bdc3c7";
			override["scalesProperties.textColor"] = "#bdc3c7";
			override["scalesProperties.lineColor"] = "#34495e";
			override["scalesProperties.backgroundColor"] = "#2c3e50";
			override["paneProperties.vertGridProperties.color"] = "rgba(52, 73, 94, 0)";
            override["paneProperties.horzGridProperties.color"] = "rgba(52, 73, 94, 0)";
            widget = new TradingView.widget({
				toolbar_bg: '#34495e',
                width: '100%',
                height: '100%',
                symbol: _symbol,
                interval: 'D',
                container_id: "tv_chart_container",
                datafeed: new Datafeeds.UDFCompatibleDatafeed("https://arbitrage.ph/api"),
                library_path: "/assets/tradingview/charting_library/",
                timezone: "Asia/Hong_Kong",
                locale: "en",
                symbol_search_request_delay: 1000,
                // charts_storage_url: 'https://saveload.tradingview.com',
                indicators_file_name: '/assets/js/custom-indicators.js',
				charts_storage_api_version: "1.1",
                client_id: _client_id,
                user_id: _user_id,
                enabled_features: ['narrow_chart_enabled','study_templates','keep_left_toolbar_visible_on_small_screens'],
                disabled_features: ['header_fullscreen_button','link_to_tradingview'],
                custom_css_url: '/assets/css/tradingview.css',
                overrides: override,
                studies_overrides: {
                    "volume.show ma": true,
                },
                logo: {
                    image: '/wp-content/uploads/2019/04/translogo.png',
                    link: 'https://arbitrage.ph/'
                },
                time_frames: [
                    { text: "5y", resolution: "D" },
                    { text: "4y", resolution: "D" },
                    { text: "3y", resolution: "D" },
                    { text: "2y", resolution: "D" },
                    { text: "1y", resolution: "D" },
                    { text: "6m", resolution: "D" },
                    { text: "3m", resolution: "D" },
                    { text: "2m", resolution: "D" },
                    { text: "1m", resolution: "D" },
                    { text: "1w", resolution: "30" },
                    { text: "3d", resolution: "15" },
                    { text: "1d", resolution: "5" }
                ],
                auto_save_delay: 604800,
                theme: "Dark",
            });
            widget.onChartReady(function() {
                
                function changeTheme() {
                    $('body').toggleClass('dark-theme', nightmode);
                    $('#tv_chart_container iframe').contents().find('html').toggleClass('theme-dark', nightmode);
                    widget.applyOverrides(nightmode ? dark_overrides : light_overrides);
                }
                // changeTheme();
                $('#tv_chart_container').show();
                chart = widget.chart();

                // for register sentiments
                $http({
                    method : "POST",
                    url : "https://arbitrage.ph/apipge/?stock="+_symbol+"&isbull="+$scope.$parent.fullbidtotal+"&isbear="+$scope.$parent.fullasktotal,
                    dataType: "json",
                    contentType: "application/json",
                    data: {
                        'action' : 'check_sentiment',
                        'stock' : _symbol,
                    }
                }).then(function mySucces(response) {
                    angular.element(".regsentiment").addClass('openmenow');
                    

                    // angular.element(".bullbearsents").addClass('clickedthis');

                    if (response.data.isvote == "1") {
                        // cant vote!
                        angular.element(".bullbearsents").addClass('clickedthis');
                        angular.element(".dbaronchart").css('width', '70%');
                        angular.element(".bbs_bull_bar").css('width', response.data.dbull+'%');
                        angular.element(".bbs_bull_bar").find('span').show('fast');

                        var dbullvalx = parseFloat(response.data.dbull);
                        var dbearvalx = parseFloat(response.data.dbear);

                        angular.element(".bbs_bull_bar").find('span').text(dbullvalx.toFixed(2)+'%'); 

                        angular.element(".bbs_bear_bar").css('width', response.data.dbear+'%');
                        angular.element(".bbs_bear_bar").find('span').show('fast');
                        angular.element(".bbs_bear_bar").find('span').text(dbearvalx.toFixed(2)+'%'); 
                    } else {
                        // can vote!
                        angular.element(".bullbearsents").removeClass('clickedthis');
                        angular.element(".dbaronchart").css('width', '0%');
                        angular.element(".bbs_bull_bar").find('span').hide();
                        angular.element(".bbs_bear_bar").find('span').hide();
                    }

                }, function myError(error) {
                    console.log(error);
                });
                
                
                chart.onSymbolChanged().subscribe(null, function(symbolData) {
                    $('#tv_chart_container iframe').contents().find('.tv-chart-events-source__tooltip').remove();
                    var symbol = symbolData.ticker;
                    $rootScope.selectedSymbol = $scope.$parent.selectedStock = _symbol = symbol;
                    if (symbolData.type == 'index') {
                    }
                    var found = $filter('filter')($scope.$parent.stocks, {symbol: symbol}, true);
                    console.log("nausab ra");
                    angular.element(".arb_bullbear").show();
                    if (found.length) {

                        if ( ! $scope.$parent.stock || $scope.$parent.stock.symbol != symbol) {
                            $scope.$parent.stock = $scope.$parent.stocks[$scope.$parent.stocks.indexOf(found[0])];
                        }
                        $scope.$parent.marketdepth = [];
                        $scope.$parent.transactions = [];
                        $scope.$parent.bidtotal = 0;
                        $scope.$parent.asktotal = 0;
                        $scope.$parent.bidperc = 0;
                        $scope.$parent.askperc = 0;
                        $scope.$parent.fullbidtotal = 0;
                        $scope.$parent.fullasktotal = 0;
                        $scope.$parent.fullbidperc = 0;
                        $scope.$parent.fullaskperc = 0;

                        $scope.$parent.dshowsentiment = '';
                        let limit = 20;
                        $http.get('https://data-api.arbitrage.ph/api/v1/stocks/trades/latest?exchange=PSE&broker=true&sort=DESC&symbol=' + symbol + '&limit=' + limit)
                            .then(response => {
                                response = response.data;
                                if (!response.success) {
                                    return;
                                }

                                let data = response.data;

                                $scope.$parent.transactions = data.map(transaction => {
                                    let full_time = new Intl.DateTimeFormat('en-US', {timeStyle: 'short'}).format(new Date(transaction.timestamp));
                                    
                                    return {
                                        symbol: transaction.symbol,
                                        price:  price_format(transaction.executed_price),
                                        shares: abbr_format(transaction.executed_volume),
                                        buyer:  transaction.buyer,
                                        seller: transaction.seller,
                                        time:   full_time,
                                    };                                    
                                });
                                $scope.$parent.$digest();
                            });

                        // $http.get("//marketdepth.pse.tools/api/market-depth?symbol=" + symbol).then( function (response) {
                        //     if (response.data.success) {
                        //         $scope.$parent.marketdepth = response.data.data;
                        //     }
                        //     $scope.$parent.bidtotal = 0;
                        //     $scope.$parent.asktotal = 0;
                        //     $scope.$parent.bidperc = 0;
                        //     $scope.$parent.askperc = 0;
                        //     var keepGoing = true;
                        //     angular.forEach($scope.$parent.marketdepth, function(value, key) {
                        //       if(keepGoing) {
                        //         $scope.$parent.bidtotal += (!value.bid_volume ? 0 : parseInt(value.bid_volume));
                        //         $scope.$parent.asktotal += (!value.ask_volume ? 0 : parseInt(value.ask_volume));
                        //         if(key == 4){
                        //           keepGoing = false;
                        //         }
                        //       }
                        //     });
                        //     $scope.$parent.bidperc = ($scope.$parent.bidtotal / ($scope.$parent.bidtotal + $scope.$parent.asktotal)) * 100;
                        //     $scope.$parent.askperc = ($scope.$parent.asktotal / ($scope.$parent.bidtotal + $scope.$parent.asktotal)) * 100;
                        //     console.log("asking: " +$scope.$parent.asktotal);
                        //     console.log("bidding: "+$scope.$parent.bidtotal);
                        //     console.log("ask persentage: "+$scope.$parent.askperc);
                        //     console.log("bid percentage: "+$scope.$parent.bidperc);
                        //     $scope.$parent.fullbidtotal = 0;
                        //     $scope.$parent.fullasktotal = 0;
                        //     $scope.$parent.fullbidperc = 0;
                        //     $scope.$parent.fullaskperc = 0;

                        //     var keepGoing = true;
                        //     angular.forEach($scope.$parent.marketdepth, function(value, key) {
                        //         $scope.$parent.fullbidtotal += (!value.bid_volume ? 0 : parseInt(value.bid_volume));
                        //         $scope.$parent.fullasktotal += (!value.ask_volume ? 0 : parseInt(value.ask_volume));
                        //     });
                        //     $scope.$parent.fullbidperc = ($scope.$parent.fullbidtotal / ($scope.$parent.fullbidtotal + $scope.$parent.fullasktotal)) * 100;
                        //     $scope.$parent.fullaskperc = ($scope.$parent.fullasktotal / ($scope.$parent.fullbidtotal + $scope.$parent.fullasktotal)) * 100;

                            

                            
                        // });
                        socket.emit('stock', symbol, function(data) {
                            if (data.transactions) {
                                $scope.$parent.transactions = data.transactions;
                            }
                            if (data.bidask && $scope.marketdepth.length == 0) {
                                $scope.$parent.marketdepth = data.bidask;
                            }
                        });
                    } else {
                        $scope.$parent.stock = null;
                        $scope.$parent.marketdepth = [];
                        $scope.$parent.transactions = [];
                    }
                    $scope.$parent.$digest();

                    var url = '/chart/' + symbol; 
                    var title = symbol + ' | Arbitrage Trading Tools';
                    document.title = title;
                    window.history.pushState({path: url}, title, url);
                    if (typeof ga != 'undefined') {
                        ga('set', 'page', '/chart/' + symbol);
                        ga('send', 'pageview');
                    }
                });
				$(widget.createButton())
                    .on('click', function (e) {
                        widget.chart().createStudy("Support and Resistance", false, false);
                     })
                    .append('<span>S&R</span>');
                $(widget.createButton({align: "right"})).attr('title', 'Fullscreen').on('click', function (e) { 
                    $('#tv_chart_container').toggleFullScreen();
                })
				.html('<div class="button-2-lC3gh4- button-2ioYhFEY- apply-common-tooltip isInteractive-20uLObIc-" style="margin: 0 -10px !important;"><span class="icon-beK_KS0k-"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" width="28" height="28"><g fill="currentColor"><path d="M21 7v4h1V6h-5v1z"></path><path d="M16.854 11.854l5-5-.708-.708-5 5zM7 7v4H6V6h5v1z"></path><path d="M11.146 11.854l-5-5 .708-.708 5 5zM21 21v-4h1v5h-5v-1z"></path><path d="M16.854 16.146l5 5-.708.708-5-5z"></path><g><path d="M7 21v-4H6v5h5v-1z"></path><path d="M11.146 16.146l-5 5 .708.708 5-5z"></path></g></g></svg></span></div>').css('cursor','pointer');
            });
        });
    });
}]);

