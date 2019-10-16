var widget;
var chart;
var marketdepthTimeout;
// var INDICES = ['PSEI','ALL','FIN','HDG','IND','M-O','PRO','SVC'];
var app = angular.module('arbitrage', ['ngSanitize','ngEmbed','ngNumeraljs','yaru22.angular-timeago','luegg.directives']);
app.run(['$rootScope', '$http', function($rootScope, $http) {
    $rootScope.newMessages = 0;
    $rootScope.stockList = [];
    $rootScope.selectedSymbol = _symbol;
    $rootScope.tickerBeep = true;
    $http.post("/wp-json/data-api/v1/stocks/list")
        .then(function(response) {
            $rootScope.stockList = response.data.data;
            _stocks = response.data.data;
        })
}]);
app.controller('ticker', ['$scope', '$rootScope', function($scope, $rootScope) {
    $scope.enable = true;
    $scope.ticker = [];

    socket.on('psec', function (data) {  
        if ($scope.enable) {
            var transaction = {
                symbol: data.sym,
                price:  price_format(data.prv),
                change: data.chg,
                shares: abbr_format(data.vol)
            };
            $scope.ticker.push(transaction);

            if ($scope.ticker.length > 30) {
                $scope.ticker.shift();
            }

            $scope.$digest();
        }
    });
}]);
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
app.controller('chart', ['$scope','$filter', '$http', '$rootScope', '$timeout', function($scope, $filter, $http, $rootScope, $timeout) {
    var vm = this;
    vm.Total = 0;
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    $scope.$watch('$root.stockList', function () {
        $scope.stock_details = $rootScope.stockList;
    });
    $scope.latest_trading_date = null;
    $scope.gainers      = 0;
    $scope.losers       = 0;
    $scope.unchanged    = 0;
    $scope.stocks = [];
    // $scope.watchlists = {
    //     'All Stocks': 'stocks', 
    //     'New Watchlist': 'new',
    //     'Default Watchlist': JSON.parse(localStorage.getItem('watchlist')) || [],
    // };
    // $scope.watchlist = 'All Stocks';
    // $scope.lastWatchlist = 'All Stocks';
    $scope.sort = 'value';
    $scope.reverse  = true;
    $scope.stock        = null;
    $scope.marketdepth  = [];
    $scope.enableBidsAndAsks = true;
    $scope.bids = [];
    $scope.asks = [];
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
    // $scope.watchlistReady = false;
    // $scope.selectWatchlist = function(watchlist) {
    //     if (watchlist == 'new') {
    //         if (_user_id == 'public_user') {
    //             if (confirm('Please login to create additional watchlist')) {
    //                 window.location.href = '/login';
    //                 $scope.watchlist = $scope.lastWatchlist;
    //             }
    //             $scope.watchlist = $scope.lastWatchlist;
    //             return false;
    //         }
    //         var watchlistName = prompt('Watchlist Name:');
    //         if (watchlistName) {
    //             watchlistName = watchlistName.trim();
    //         }
    //         if (watchlistName) {
    //             if ( ! $scope.watchlists[watchlistName]) {
    //                 $scope.watchlists[watchlistName] = [];
    //                 $http.post("/api/watchlist-add", $.param({watchlist: watchlistName})).then( function (response) {
    //                 });
    //                 $.gritter.add({
    //                     title: 'Success',
    //                     text: "Watchlist has been successfully created<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
    //                     time: 5000,
    //                     class_name: nightmode ? "gritter-dark" : "gritter-light",
    //                 });
    //             }
    //             $scope.watchlist = watchlistName;
    //             $scope.lastWatchlist = watchlistName;
    //         } else {
    //             $scope.watchlist = $scope.lastWatchlist;
    //         }
    //     } else if (watchlist == 'stocks') {
    //     } else {
    //         $scope.lastWatchlist = $scope.watchlist;
    //     }
    //     $('#watchlist-scroll').slimScroll({ scrollTo : '0px' });
    // }
    // $scope.addToWatchlist = function(symbol) {
    //     if (_user_id == 'public_user')  {
    //         if ($scope.watchlists['Default Watchlist'].indexOf(symbol) === -1) {
    //             $scope.watchlists['Default Watchlist'].push(symbol);
    //             localStorage.setItem('watchlist', JSON.stringify($scope.watchlists['Default Watchlist']));
    //         }
    //         $.gritter.add({
    //             title: 'Success',
    //             text: symbol + " has been successfully added to you watchlist<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
    //             time: 5000,
    //             class_name: nightmode ? "gritter-dark" : "gritter-light",
    //         });
    //         return;
    //     }
    //     watchlist = prompt('Add ' + symbol + 'to Watchlist:', $scope.lastWatchlist);
    //     if (watchlist) {
    //         watchlist = watchlist.trim();
    //     }
    //     if (watchlist && watchlist.length > 0) {
    //         if ($scope.watchlists[watchlist]) {
    //             $scope.watchlists[watchlist].push(symbol);
    //             $http.post("/api/watchlist-add", $.param({watchlist: watchlist, symbol: symbol})).then( function (response) {
    //             });
    //             $.gritter.add({
    //                 title: 'Success',
    //                 text: symbol + " has been successfully added to you watchlist<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
    //                 time: 5000,
    //                 class_name: nightmode ? "gritter-dark" : "gritter-light",
    //             });
    //         } else {
    //             $scope.watchlists[watchlist] = [symbol];
    //             $scope.watchlist = watchlist;
    //             $http.post("/api/watchlist-add", $.param({watchlist: watchlist, symbol: symbol})).then( function (response) {
    //             });
    //             $.gritter.add({
    //                 title: 'Success',
    //                 text: "Watchlist has been successfully created<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
    //                 time: 5000,
    //                 class_name: nightmode ? "gritter-dark" : "gritter-light",
    //             });
    //         }
    //         $scope.lastWatchlist = watchlist;
    //     }
    // }
    // $scope.addStockToWatchlist = function(watchlist) {
    //     symbol = prompt('Stock Symbol:', _symbol);
    //     if (symbol) {
    //         symbol = symbol.toUpperCase().trim();
    //     }
    //     if (symbol && symbol.length > 0 && watchlist.indexOf(symbol) === -1) {
    //         watchlist.push(symbol);
    //         if (_user_id == 'public_user' && $scope.watchlist == 'Default Watchlist')  {
    //             localStorage.setItem('watchlist', JSON.stringify($scope.watchlists['Default Watchlist']));
    //             $.gritter.add({
    //                 title: 'Success',
    //                 text: symbol + " has been successfully added to you watchlist<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
    //                 time: 5000,
    //                 class_name: nightmode ? "gritter-dark" : "gritter-light",
    //             });
    //             return;
    //         }
    //         $http.post("/api/watchlist-add", $.param({watchlist: $scope.watchlist, symbol: symbol})).then( function (response) {
    //         });
    //         $.gritter.add({
    //             title: 'Success',
    //             text: symbol + " has been successfully added to your watchlist<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
    //             time: 5000,
    //             class_name: nightmode ? "gritter-dark" : "gritter-light",
    //         });
    //     }
    // }
    // $scope.deleteWatchlist = function(watchlist) {
    //     if (_user_id == 'public_user') {
    //         return;
    //     }
    //     if (confirm('Are you sure you want to delete "' + watchlist + '"?')) {
    //         delete $scope.watchlists[watchlist];
    //         $scope.watchlist = 'All Stocks';
    //         $scope.lastWatchlist = 'Default Watchlist';
    //         $http.post("/api/watchlist-delete", $.param({watchlist: watchlist})).then( function (response) {
    //         });
    //         $.gritter.add({
    //             title: 'Success',
    //             text: '"' + watchlist + "\" has been successfully deleted<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
    //             time: 5000,
    //             class_name: nightmode ? "gritter-dark" : "gritter-light",
    //         });
    //     }
    // }
    // $scope.removeFromWatchlist = function(watchlist, symbol) {
    //     if (confirm('Are you sure you want to remove ' + symbol.toUpperCase() + ' from your watchlist?')) {
    //         watchlist.splice(watchlist.indexOf(symbol), 1);
    //         if (_user_id == 'public_user' && $scope.watchlist == 'Default Watchlist')  {
    //             localStorage.setItem('watchlist', JSON.stringify($scope.watchlists['Default Watchlist']));
    //             $.gritter.add({
    //                 title: 'Success',
    //                 text: symbol.toUpperCase() + " has been successfully removed from your watchlist<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
    //                 time: 5000,
    //                 class_name: nightmode ? "gritter-dark" : "gritter-light",
    //             });
    //             return;
    //         }
    //         $http.post("/api/watchlist-delete", $.param({watchlist: $scope.watchlist, symbol: symbol})).then( function (response) {
    //         });
    //         $.gritter.add({
    //             title: 'Success',
    //             text: symbol.toUpperCase() + " has been successfully removed from your watchlist<div class='pull-right'><a href='javascript:void(0);' onclick='$.gritter.removeAll();' class='text-danger'>Close all notifications</a></div>",
    //             time: 5000,
    //             class_name: nightmode ? "gritter-dark" : "gritter-light",
    //         });
    //     }
    // }
    $http.post("/wp-json/data-api/v1/stocks/history/latest-active-date")
        .then(response => {
            if (response.data.success) {
                $scope.latest_trading_date = moment(response.data.data.date)
            }
        })
    $http.post("/wp-json/data-api/v1/stocks/history/latest?exchange=PSE").then( function (response) {
        stocks = response.data.data;
        stocks = Object.values(stocks);
        stocks.map(function(stock) {
            stock['lastupdatetime'] = moment(stock['lastupdatetime']);
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
            stock['displayValue'] = abbr_format(stock['value']).toUpperCase();
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
    });
    $scope.getBidsAndAsks = function (symbol) {
        if ($scope.enableBidsAndAsks) {
            $http.post('/wp-json/data-api/v1/stocks/market-depth/latest/bidask?exchange=PSE&filter-by-last=true&limit=20&symbol=' + symbol)
            .then(response => {
                response = response.data;
                if (!response.success) {
                    $scope.bids = [];
                    $scope.asks = [];
                    return;
                }
    
                $scope.bids = Object.values(response.data.bids);
                $scope.asks = Object.values(response.data.asks);
            })
            .catch(err => {
                $scope.bids = [];
                $scope.asks = [];
            });
        }
    }
    $scope.getBidsAndAsks(_symbol);
    
    $scope.getStockTrades = function (symbol = '', limit = 20) {
        if (symbol != 'PSEI' && symbol != '') {
            $http.post('/wp-json/data-api/v1/stocks/trades/latest?exchange=PSE&broker=true&sort=DESC&symbol=' + symbol + '&limit=' + limit)
                .then(response => {
                    response = response.data;
                    if (!response.success) {
                        return;
                    }
    
                    let data = response.data;
    
                    $scope.transactions = data.map(transaction => {
                        let full_time = (moment(transaction.timestamp * 1000)).format('hh:mm a');
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
                })
                .catch(err => {
                    
                });
        }
    }
    $scope.getStockTrades(_symbol);

    socket.on('psec', function (data) {
        let full_date = (moment(data.t * 1000)).format('ll')
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
                if (stock.change > 0){
                    if ($rootScope.tickerBeep) beep();
                    changicotogreen();
                }
				if (stock.change < 0){
                    if ($rootScope.tickerBeep) beep();
                    changicotored();
                }
				if (stock.change = 0){changicotounchanged();}
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

    socket.on('pset', function (data) {
        if ($scope.stock && $scope.stock.symbol == data.sym) {
            let full_time = (moment(data.t * 1000)).format('hh:mm a');
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

    /**
     * Types
     *  a => add
     *  au => update price
     *  d => delete
     *  u => update new order
     */
     socket.on('psebd', function (data) {
        if ($scope.selectedStock == data.sym && $scope.enableBidsAndAsks) {
            if (data.ov == 'B') {
                // bid
                $scope.bids = $scope.updateBidAndAsks($scope.bids, data);
                $scope.bids = $filter('orderBy')($scope.bids, '-price');
            } else if (data.ov == 'S') {
                // ask
                $scope.asks = $scope.updateBidAndAsks($scope.asks, data);
            }
            $scope.$digest();
        }
    });

    $scope.updateBidAndAsks = function (list, data) {
        let index = list.findIndex(function(item){
            return item.id == data.id
        });
        if (data.ty == 'a') {
            if (typeof list[index] !== 'undefined') {
                list[index].count++;
                list[index].volume += data.vol;
            } else {
                list.push($scope.addToBidAskList(data.id, data));
            }
        } else if (data.ty == 'au') {
            // decrement data.id's count by 1, if count is zero, remove from list
            list = $scope.updateBidAskCount(list, index, -1, data.vol);

            // add new data.idn to list
            list.push($scope.addToBidAskList(data.idn, data));
        } else if (data.ty == 'd') {
            // decrement data.id's count by 1, if count is zero, remove from list
            list = $scope.updateBidAskCount(list, index, -1, data.vol);
        } else if (data.ty == 'u') {
            // same as au but drop the data.id entirely and add data.idn to list
            if (typeof list[index] !== 'undefined') {
                list = list.filter((item, key) => {
                    return key != index;
                });
            }
            list.push($scope.addToBidAskList(data.idn, data));
        }
        return list;
    }

    $scope.updateBidAskCount = function (list, id, increment, volume) {
        if (typeof list[id] !== 'undefined') {
            list[id].count += increment;
            list[id].volume += volume * increment;
            if (list[id].count <= 0) {
                list = list.filter((item, key) => {
                    return key != id;
                });
            }
        }
        return list;
    }

    $scope.addToBidAskList = function (id, data) {
        return {
            'id': id,
            'price': data.p,
            'count': 1,
            'volume': data.vol,
        }
    }
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
    function updateMarketDepth(force) {
        if ($scope.stock) {
            $scope.getFullMarketDepth($scope.stock.symbol);
            $scope.getTopMarketDepth($scope.stock.symbol);
        }
    }

    $scope.getFullMarketDepth = function (symbol) {
        $http.post('/wp-json/data-api/v1/stocks/market-depth/latest/full-depth?exchange=PSE&symbol=' + symbol)
            .then(function (response) {
                if (response.data.success) {
                    let data = response.data.data;

                    $scope.fullaskperc = data.ask_total_percent;
                    $scope.fullasktotal = data.ask_total;
                    $scope.fullbidperc = data.bid_total_percent;
                    $scope.fullbidtotal = data.bid_total;

                }
            })
            .catch(function (response) {
                $scope.fullaskperc = 0;
                $scope.fullasktotal = 0;
                $scope.fullbidperc = 0;
                $scope.fullbidtotal = 0;
            });
    }

    $scope.getTopMarketDepth = function (symbol) {
        $http.post('/wp-json/data-api/v1/stocks/market-depth/latest/top-depth?exchange=PSE&entry=5&symbol=' + symbol)
            .then(function (response) {
                if (response.data.success) {
                    let data = response.data.data;

                    $scope.askperc = data.ask_total_percent;
                    $scope.asktotal = data.ask_total;
                    $scope.bidperc = data.bid_total_percent;
                    $scope.bidtotal = data.bid_total;

                }
            })
            .catch(function (response) {
                $scope.askperc = 0;
                $scope.asktotal = 0;
                $scope.bidperc = 0;
                $scope.bidtotal = 0;
            });
    }
	setInterval(updateMarketDepth, 30000);
}]);
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

    $scope.getSentiments = function (symbol, fullbidtotal, fullasktotal) {
        $http({
            method : "POST",
            url : "/apipge/?stock="+symbol+"&isbull="+fullbidtotal+"&isbear="+fullasktotal,
            dataType: "json",
            contentType: "application/json",
            data: {
                'action' : 'check_sentiment',
                'stock' : symbol,
            }
        }).then(function mySucces(response) {
            angular.element(".regsentiment").addClass('openmenow');
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

        });
    }

    $(function() {
        function initTradingView() {
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
                datafeed: new Datafeeds.UDFCompatibleDatafeed("/api"),
                library_path: "/assets/tradingview/charting_library/",
                timezone: "Asia/Hong_Kong",
                locale: "en",
                symbol_search_request_delay: 1000,
                charts_storage_url: '/wp-json/charts-api',
                // indicators_file_name: '/assets/js/custom-indicators.js',
                custom_indicators_getter: function(PineJS) {
                    return Promise.resolve([{
                        name: 'Net Value',
                        metainfo: {
                            "_metainfoVersion": 15,
                            "isTVScript": false,
                            "isTVScriptStub": false,
                            "is_hidden_study": false,
                            "defaults": {
                                "styles": {
                                    "compare": {
                                        "linestyle": 0,
                                        "linewidth": 2,
                                        "plottype": 5,
                                        "trackPrice": false,
                                        "transparency": 35,
                                        "visible": true,
                                        "color": "#800080",
                                        "disableSave": true,
                                        "showPrice": true,
                                    }
                                },
                                "precision": 0,
                                "inputs": { }
                            },
                            "plots": [{
                                "id": "compare",
                                "type": "line",
                            }],
                            "styles": {
                                "compare": {
                                    "title": "Net Value",
                                    "histogramBase": 0,
                                }
                            },
                            "description": "Net Value",
                            "shortDescription": "Net Value",
                            "is_price_study": false,
                            "inputs": [ ],
                            "id": "Net Value@tv-basicstudies-1",
                        },

                        constructor: function () {

                            this.init = function(context, input) {
                                this._context = context;
                                this._context.new_sym(PineJS.Std.ticker(this._context) + "#VALUE", PineJS.Std.period(this._context), PineJS.Std.period(this._context));
                            };

                            this.main = function (ctx, input) {
                                this._context = ctx;
                                var time0 = this._context.new_var(this._context.symbol.time);
                                var il_var_0 = PineJS.Std.period(this._context);
                                this._context.select_sym(1);
                                var time1 = this._context.new_var(this._context.symbol.time);
                                var il_var_2 = PineJS.Std.volume(this._context);
                                var il_var_3 = this._context.new_var(il_var_2);
                                this._context.select_sym(0);
                                var il_var_5 = il_var_3.adopt(time1, time0, 0);
                                return [il_var_5];
                            };

                        }

                    },
                    {
                        name: 'Net Foreign',
                        metainfo: {
                            "_metainfoVersion": 15,
                            "isTVScript": false,
                            "isTVScriptStub": false,
                            "is_hidden_study": false,
                            "defaults": {
                                "styles": {
                                    "compare": {
                                        "linestyle": 0,
                                        "linewidth": 2,
                                        "plottype": 5,
                                        "trackPrice": false,
                                        "transparency": 35,
                                        "visible": true,
                                        "color": "#800080",
                                        "disableSave": true,
                                        "showPrice": true,
                                    }
                                },
                                "precision": 0,
                                "inputs": { }
                            },
                            "plots": [{
                                "id": "compare",
                                "type": "line",
                            }],
                            "styles": {
                                "compare": {
                                    "title": "Net Foreign",
                                    "histogramBase": 0,
                                }
                            },
                            "description": "Net Foreign",
                            "shortDescription": "Net Foreign",
                            "is_price_study": false,
                            "inputs": [ ],
                            "id": "Net Foreign@tv-basicstudies-1",
                        },

                        constructor: function () {

                            this.init = function(context, input) {
                                this._context = context;
                                this._context.new_sym(PineJS.Std.ticker(this._context) + "#FOREIGN", PineJS.Std.period(this._context), PineJS.Std.period(this._context));
                            };

                            this.main = function (ctx, input) {
                                this._context = ctx;
                                var time0 = this._context.new_var(this._context.symbol.time);
                                var il_var_0 = PineJS.Std.period(this._context);
                                this._context.select_sym(1);
                                var time1 = this._context.new_var(this._context.symbol.time);
                                var il_var_2 = PineJS.Std.volume(this._context);
                                var il_var_3 = this._context.new_var(il_var_2);
                                this._context.select_sym(0);
                                var il_var_5 = il_var_3.adopt(time1, time0, 0);
                                return [il_var_5];
                            };

                        }

                    },
                    {
                        name: "Price Exhaustion",
                        metainfo: {
                            _metainfoVersion: 42,
                            isTVScript: !1,
                            isTVScriptStub: !1,
                            defaults: {
                                styles: {
                                    plot_0: {
                                        linestyle: 0,
                                        linewidth: 4,
                                        plottype: 1,
                                        trackPrice: !1,
                                        transparency: 35,
                                        visible: !0,
                                        color: "#000080"
                                    },
                                    plot_2: {
                                        linestyle: 0,
                                        linewidth: 2,
                                        plottype: 3,
                                        trackPrice: !1,
                                        transparency: 35,
                                        visible: !0,
                                        color: "#000080"
                                    }
                                },
                                precision: 4,
                                palettes: {
                                    palette_0: {
                                        colors: {
                                            0: {
                                                color: "#00FF00",
                                                width: 4,
                                                style: 0
                                            },
                                            1: {
                                                color: "#008000",
                                                width: 4,
                                                style: 0
                                            },
                                            2: {
                                                color: "#FF0000",
                                                width: 4,
                                                style: 0
                                            },
                                            3: {
                                                color: "#800000",
                                                width: 4,
                                                style: 0
                                            }
                                        }
                                    },
                                    palette_1: {
                                        colors: {
                                            0: {
                                                color: "#0000FF",
                                                width: 2,
                                                style: 0
                                            },
                                            1: {
                                                color: "#000000",
                                                width: 2,
                                                style: 0
                                            },
                                            2: {
                                                color: "#808080",
                                                width: 2,
                                                style: 0
                                            }
                                        }
                                    }
                                },
                                inputs: {
                                    in_0: 8,
                                    in_1: 2,
                                    in_2: 8,
                                    in_3: 1,
                                    in_4: !0
                                }
                            },
                            plots: [{
                                id: "plot_0",
                                type: "line"
                            }, {
                                id: "plot_1",
                                palette: "palette_0",
                                target: "plot_0",
                                type: "colorer"
                            }, {
                                id: "plot_2",
                                type: "line"
                            }, {
                                id: "plot_3",
                                palette: "palette_1",
                                target: "plot_2",
                                type: "colorer"
                            }],
                            styles: {
                                plot_0: {
                                    title: "Plot",
                                    histogramBase: 0,
                                    joinPoints: !1,
                                    isHidden: !1
                                },
                                plot_2: {
                                    title: "Plot",
                                    histogramBase: 0,
                                    joinPoints: !1,
                                    isHidden: !1
                                }
                            },
                            description: "Price Exhaustion",
                            shortDescription: "Price Exhaustion",
                            is_price_study: !1,
                            is_hidden_study: !1,
                            id: "Price Exhaustion@tv-basicstudies-1",
                            palettes: {
                                palette_0: {
                                    colors: {
                                        0: {
                                            name: "Color 0"
                                        },
                                        1: {
                                            name: "Color 1"
                                        },
                                        2: {
                                            name: "Color 2"
                                        },
                                        3: {
                                            name: "Color 3"
                                        }
                                    },
                                    valToIndex: {
                                        0: 0,
                                        1: 1,
                                        2: 2,
                                        3: 3
                                    }
                                },
                                palette_1: {
                                    colors: {
                                        0: {
                                            name: "Color 0"
                                        },
                                        1: {
                                            name: "Color 1"
                                        },
                                        2: {
                                            name: "Color 2"
                                        }
                                    },
                                    valToIndex: {
                                        4: 0,
                                        5: 1,
                                        6: 2
                                    }
                                }
                            },
                            inputs: [{
                                id: "in_0",
                                name: "BB Length",
                                defval: 8,
                                type: "integer",
                                min: -1E12,
                                max: 1E12
                            }, {
                                id: "in_1",
                                name: "BB MultFactor",
                                defval: 2,
                                type: "float",
                                min: -1E12,
                                max: 1E12
                            }, {
                                id: "in_2",
                                name: "KC Length",
                                defval: 8,
                                type: "integer",
                                min: -1E12,
                                max: 1E12
                            }, {
                                id: "in_3",
                                name: "KC MultFactor",
                                defval: 1,
                                type: "float",
                                min: -1E12,
                                max: 1E12
                            }, {
                                id: "in_4",
                                name: "Use TrueRange (KC)",
                                defval: !0,
                                type: "bool"
                            }],
                            scriptIdPart: "",
                            name: "Price Exhaustion",
                            isCustomIndicator: !0
                        },
                        constructor: function() {
                            this.f_0 = function() {
                                var a = this._input(0),
                                    c = this._input(2),
                                    b = this._input(3),
                                    f = this._input(4),
                                    g = PineJS.Std.close(this._context),
                                    e = this._context.new_var(g),
                                    e = PineJS.Std.sma(e, a, this._context),
                                    d = this._context.new_var(g),
                                    d = b * PineJS.Std.stdev(d, a, this._context),
                                    a = e + d,
                                    e = e - d,
                                    d = this._context.new_var(g),
                                    d = PineJS.Std.sma(d, c, this._context),
                                    k = PineJS.Std.tr(void 0, this._context),
                                    l = PineJS.Std.high(this._context) - PineJS.Std.low(this._context),
                                    f = this._context.new_var(f ? k : l),
                                    k = PineJS.Std.sma(f, c, this._context),
                                    f = d + k * b,
                                    d = d - k * b,
                                    b = PineJS.Std.and(PineJS.Std.gt(e, d), PineJS.Std.lt(a, f)),
                                    a = PineJS.Std.and(PineJS.Std.lt(e, d), PineJS.Std.gt(a, f)),
                                    a = PineJS.Std.and(PineJS.Std.eq(b, 0), PineJS.Std.eq(a, 0)),
                                    f = this._context.new_var(PineJS.Std.high(this._context)),
                                    e = this._context.new_var(PineJS.Std.low(this._context)),
                                    d = this._context.new_var(PineJS.Std.close(this._context)),
                                    g = this._context.new_var(g - PineJS.Std.avg(PineJS.Std.avg(PineJS.Std.highest(f, c, this._context), PineJS.Std.lowest(e, c, this._context)), PineJS.Std.sma(d, c, this._context))),
                                    c = this._context.new_var(PineJS.Std.linreg(g, c, 0)),
                                    g = PineJS.Std.iff(PineJS.Std.gt(c.get(0), 0), PineJS.Std.iff(PineJS.Std.gt(c.get(0), PineJS.Std.nz(c.get(1))), 0, 1), PineJS.Std.iff(PineJS.Std.lt(c.get(0), PineJS.Std.nz(c.get(1))), 2, 3)),
                                    b = a ? 4 : b ? 5 : 6;
                                return [c.get(0), 0, g, b]
                            };
                            this.main = function(a, c) {
                                this._context = a;
                                this._input = c;
                                var b = this.f_0();
                                return [b[0], b[2], b[1], b[3]]
                            }
                        }
                    },
                    {   
                        name: "Composite Momentum Index",
                        metainfo: {
                            _metainfoVersion: 42,
                            isTVScript: !1,
                            isTVScriptStub: !1,
                            defaults: {
                                styles: {
                                    plot_0: {
                                        linestyle: 0,
                                        linewidth: 0,
                                        plottype: 6,
                                        trackPrice: !1,
                                        transparency: 35,
                                        visible: !0,
                                        color: "#808080"
                                    },
                                    plot_1: {
                                        linestyle: 0,
                                        linewidth: 1,
                                        plottype: 0,
                                        trackPrice: !1,
                                        transparency: 35,
                                        visible: !0,
                                        color: "#0000FF"
                                    },
                                    plot_2: {
                                        linestyle: 0,
                                        linewidth: 1,
                                        plottype: 0,
                                        trackPrice: !1,
                                        transparency: 35,
                                        visible: !0,
                                        color: "#FF0000"
                                    }
                                },
                                precision: 4,
                                filledAreasStyle: {
                                    fill_0: {
                                        color: "#000000",
                                        transparency: 90,
                                        visible: !0
                                    },
                                    fill_1: {
                                        color: "#00FF00",
                                        transparency: 50,
                                        visible: !0
                                    },
                                    fill_2: {
                                        color: "#FF0000",
                                        transparency: 50,
                                        visible: !0
                                    }
                                },
                                bands: [{
                                    color: "#FF0000",
                                    linestyle: 2,
                                    linewidth: 1,
                                    visible: !0,
                                    value: 70
                                }, {
                                    color: "#008000",
                                    linestyle: 2,
                                    linewidth: 1,
                                    visible: !0,
                                    value: 30
                                }, {
                                    color: "#000000",
                                    linestyle: 2,
                                    linewidth: 1,
                                    visible: !0,
                                    value: 0
                                }, {
                                    color: "#008000",
                                    linestyle: 2,
                                    linewidth: 1,
                                    visible: !0,
                                    value: -30
                                }, {
                                    color: "#FF0000",
                                    linestyle: 2,
                                    linewidth: 1,
                                    visible: !0,
                                    value: -70
                                }],
                                inputs: {
                                    in_0: "close",
                                    in_1: 3,
                                    in_2: 5
                                }
                            },
                            plots: [{
                                id: "plot_0",
                                type: "line"
                            }, {
                                id: "plot_1",
                                type: "line"
                            }, {
                                id: "plot_2",
                                type: "line"
                            }],
                            styles: {
                                plot_0: {
                                    title: "Dummy",
                                    histogramBase: 0,
                                    joinPoints: !1,
                                    isHidden: !1
                                },
                                plot_1: {
                                    title: "DynamicIndex",
                                    histogramBase: 0,
                                    joinPoints: !1,
                                    isHidden: !1
                                },
                                plot_2: {
                                    title: "trigger",
                                    histogramBase: 0,
                                    joinPoints: !1,
                                    isHidden: !1
                                }
                            },
                            description: "Composite Momentum Index",
                            shortDescription: "CCMI",
                            is_price_study: !1,
                            is_hidden_study: !1,
                            id: "Composite Momentum Index@tv-basicstudies-1",
                            filledAreas: [{
                                id: "fill_0",
                                objAId: "hline_1",
                                objBId: "hline_3",
                                type: "hline_hline",
                                title: "MidRegionFill",
                                isHidden: !1
                            }, {
                                id: "fill_1",
                                objAId: "plot_1",
                                objBId: "plot_0",
                                type: "plot_plot",
                                title: "PositiveFill",
                                isHidden: !1
                            }, {
                                id: "fill_2",
                                objAId: "plot_2",
                                objBId: "plot_0",
                                type: "plot_plot",
                                title: "NegativeFill",
                                isHidden: !1
                            }],
                            bands: [{
                                id: "hline_0",
                                name: "High2",
                                isHidden: !1
                            }, {
                                id: "hline_1",
                                name: "High1",
                                isHidden: !1
                            }, {
                                id: "hline_2",
                                name: "Mid",
                                isHidden: !1
                            }, {
                                id: "hline_3",
                                name: "Low1",
                                isHidden: !1
                            }, {
                                id: "hline_4",
                                name: "Low2",
                                isHidden: !1
                            }],
                            inputs: [{
                                id: "in_0",
                                name: "Source",
                                defval: "close",
                                type: "source",
                                options: "open high low close hl2 hlc3 ohlc4".split(" ")
                            }, {
                                id: "in_1",
                                name: "Composite Smoothing Length",
                                defval: 3,
                                type: "integer",
                                min: -1E12,
                                max: 1E12
                            }, {
                                id: "in_2",
                                name: "Signal Length",
                                defval: 5,
                                type: "integer",
                                min: -1E12,
                                max: 1E12
                            }],
                            scriptIdPart: "",
                            name: "Composite Momentum Index",
                            isCustomIndicator: !0
                        },
                        constructor: function() {       
                            //calc_dema(src, length) =>     
                            //f_0 refers to calc_dema passing parameter function
                            this.f_0 = function(a, c) {
                                var b = this._context.new_var(a),
                                    //e1 = ema(src, length)
                                    b = PineJS.Std.ema(b, c, this._context),
                                    f = this._context.new_var(b),
                                    //e2 = ema(e1, length)
                                    f = PineJS.Std.ema(f, c, this._context);
                                    //2 * e1 - e2
                                return [2 * b - f]
                            };
                            
                            
                            this.f_1 = function() {
                            
                                    //src = close
                                var a = this._context.new_var(PineJS.Std[this._input(0)](this._context)),
                                    //lenSmooth=3
                                    c = this._input(1),
                                    //trigg=5
                                    b = this._input(2),
                                    
                                    //cmo51=sum( iff( src >  src[1] , ( src -  src[1] ) ,0 ) ,5 ) 
                                    f = this._context.new_var(PineJS.Std.iff(PineJS.Std.gt(a.get(0), a.get(1)), a.get(0) - a.get(1), 0)),
                                    f = PineJS.Std.sum(f, 5, this._context),
                                    
                                    //cmo52=sum( iff( src <  src[1] , ( src[1] - src )  ,0 ) ,5 )
                                    g = this._context.new_var(PineJS.Std.iff(PineJS.Std.lt(a.get(0), a.get(1)), a.get(1) - a.get(0), 0)),
                                    g = PineJS.Std.sum(g, 5, this._context),
                                    
                                    //cmo5=calc_dema(100 * nz(( cmo51 - cmo52)  /( cmo51+cmo52)),3)
                                    f = this.f_0(100 * PineJS.Std.nz((f - g) / (f + g)), 3),
                                    
                                    //cmo101=sum( iff( src >  src[1] , ( src -  src[1] ) ,0 ) ,10 ) 
                                    g = this._context.new_var(PineJS.Std.iff(PineJS.Std.gt(a.get(0), a.get(1)), a.get(0) - a.get(1), 0)),
                                    g = PineJS.Std.sum(g, 10, this._context),
                                    
                                    //cmo102=sum( iff( src <  src[1] , ( src[1] - src )  ,0 ) ,10 )
                                    e = this._context.new_var(PineJS.Std.iff(PineJS.Std.lt(a.get(0),a.get(1)), a.get(1) - a.get(0), 0)),
                                    e = PineJS.Std.sum(e, 10, this._context),
                                    
                                    //cmo10=calc_dema(100 * nz(( cmo101 - cmo102)  /( cmo101+cmo102)),3)
                                    g = this.f_0(100 * PineJS.Std.nz((g - e) / (g + e)), 3),
                                    
                                    //cmo201=sum( iff( src >  src[1] , ( src -  src[1] ) ,0 ) ,20 ) 
                                    e = this._context.new_var(PineJS.Std.iff(PineJS.Std.gt(a.get(0), a.get(1)), a.get(0) - a.get(1), 0)),
                                    e = PineJS.Std.sum(e, 20, this._context),
                                    
                                    //cmo202=sum( iff( src <  src[1] , ( src[1] - src )  ,0 ) ,20 )
                                    d = this._context.new_var(PineJS.Std.iff(PineJS.Std.lt(a.get(0), a.get(1)), a.get(1) - a.get(0), 0)),
                                    d = PineJS.Std.sum(d, 20, this._context),
                                    
                                    //cmo20=calc_dema(100 * nz(( cmo201 - cmo202)  /( cmo201+cmo202)),3)
                                    e = this.f_0(100 * PineJS.Std.nz((e - d) / (e + d)), 3),
                                    
                                    //dmi=((stdev(src,5)* cmo5)+(stdev(src,10)* cmo10)+(stdev(src,20)*cmo20))/(stdev(src,5)+stdev(src,10)+stdev(src,20))
                                    a = (PineJS.Std.stdev(a, 5, this._context) * f[0] + PineJS.Std.stdev(a, 10, this._context) *
                                        g[0] + PineJS.Std.stdev(a, 20, this._context) * e[0]) / (PineJS.Std.stdev(a, 5, this._context) + PineJS.Std.stdev(a, 10, this._context) + PineJS.Std.stdev(a, 20, this._context)),
                                        
                                    //e=ema(dmi,lenSmooth)
                                    f = this._context.new_var(a),
                                    c = PineJS.Std.ema(f, c, this._context),
                                    
                                    //s=sma(dmi,trigg)
                                    a = this._context.new_var(a),
                                    b = PineJS.Std.sma(a, b, this._context);
                                    
                                    //duml=plot(e>s?s:e, style=circles, linewidth=0, color=gray, title="Dummy")
                                    //This return on the e>s?s:e
                                return [PineJS.Std.gt(c, b) ? b : c, c, b]
                            };
                            this.main = function(a, c) {
                                this._context = a;
                                this._input = c;
                                var b = this.f_1();
                                return [b[0], b[1], b[2]]
                            }
                        }
                    },
                    {
                        name: "Support and Resistance",
                        metainfo: {
                            _metainfoVersion: 42,
                            name: "support_and_resistance",
                            id: "support_and_resistance@tv-basicstudies-1",
                            scriptIdPart: "",
                            description: "Support and Resistance",
                            shortDescription: "S/R",

                            is_price_study: true,
                            is_hidden_study: false,
                            isCustomIndicator: true,
                            isTVScript: false,
                            isTVScriptStub: false,

                            plots: [
                                {id: "plot_0", name: "plot_0", type: "line"},
                                {id: "plot_1", name: "plot_1", type: "line"},
                                {id: "plot_2", name: "plot_2", type: "line"},
                                {id: "plot_3", name: "plot_3", type: "line"}
                            ],

                            precision: 4,

                            defaults: {
                                styles: {
                                    plot_0: {
                                        linestyle: 0,
                                        linewidth: 1,
                                        plottype: 2,
                                        trackPrice: true,
                                        color: "#c80000",
                                    },
                                    plot_1: {
                                        linestyle: 0,
                                        linewidth: 1,
                                        plottype: 2,
                                        trackPrice: true,
                                        color: "#c80000",
                                    },
                                    plot_2: {
                                        linestyle: 0,
                                        linewidth: 1,
                                        plottype: 2,
                                        trackPrice: true,
                                        color: "#00c800",
                                    },
                                    plot_3: {
                                        linestyle: 0,
                                        linewidth: 1,
                                        plottype: 2,
                                        trackPrice: true,
                                        color: "#00c800",
                                    },
                                },
                                inputs: {
                                    in_0: 5,
                                    in_1: 20
                                }
                            },

                            styles: {
                                plot_0: {
                                    title: " R1",
                                    histogramBase: 0,
                                },
                                plot_1: {
                                    title: " R2",
                                    histogramBase: 0,
                                },
                                plot_2: {
                                    title: " S1",
                                    histogramBase: 0,
                                },
                                plot_3: {
                                    title: " S2",
                                    histogramBase: 0,
                                },
                            },
                            inputs: [{
                                id: "in_0",
                                name: "No. of bars for Support and Resistance 1",
                                type: "integer",
                                min: 0,
                                max: 200
                            }, {
                                id: "in_1",
                                name: "No. of bars for Support and Resistance 2",
                                type: "integer",
                                min: 0,
                                max: 200
                            }]
                        },
                        constructor: function() {
                            
                            this.main = function(a, c) {

                                this._context = a;
                                this._input   = c;

                                var h = this._context.new_var(PineJS.Std.high(this._context));
                                var l = this._context.new_var(PineJS.Std.low(this._context));
                                var r1 = PineJS.Std.highest(h, this._input(0), this._context);
                                var r2 = PineJS.Std.highest(h, this._input(1), this._context);
                                var s1 = PineJS.Std.lowest(l, this._input(0), this._context);
                                var s2 = PineJS.Std.lowest(l, this._input(1), this._context);

                                return [{
                                    value: r1,
                                    offset: -9999
                                },{
                                    value: r2,
                                    offset: -9999
                                },{
                                    value: s1,
                                    offset: -9999
                                },{
                                    value: s2,
                                    offset: -9999
                                }
                                ];
                            };

                        }
                    }]);
                },
				charts_storage_api_version: "v1",
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
                    link: '/'
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
                $scope.getSentiments(_symbol, $scope.$parent.fullbidtotal, $scope.$parent.fullasktotal);
            
                chart.onSymbolChanged().subscribe(null, function(symbolData) {
                    $('#tv_chart_container iframe').contents().find('.tv-chart-events-source__tooltip').remove();
                    var symbol = symbolData.ticker;
                    $rootScope.selectedSymbol = $scope.$parent.selectedStock = _symbol = symbol;
                    if (symbolData.type == 'index') {
                    }
                    var found = $filter('filter')($scope.$parent.stocks, {symbol: symbol}, true);
                    angular.element(".arb_bullbear").show();

                    angular.element(".arb_sell").attr("data-stocksel",_symbol); //setter
                    angular.element("#confirmsellparts").hide();

                    $http({
                        method : "GET",
                        url : "/apipge/?daction=checkifhavestock&symbol="+_symbol,
                        dataType: "json",
                        contentType: "application/json",
                        data: {
                            'action' : 'check_have_stock',
                            'stock' : _symbol,
                        }
                    }).then(function mySucces(response) {
                        if(response.data.status == "yes_stock"){
                            angular.element(".arb_sell").attr("data-hasstock","has_stock"); //setter
                            
                            // add detail from api
                            angular.element("#tradelogs").val(response.data.data.tradelog);
                            angular.element("#sellvolume").val(response.data.data.volume);
                            angular.element("#sellavrprice").val(response.data.data.averageprice);
                            angular.element("#sellavrprice").val(response.data.data.averageprice);

                            angular.element("#confirmsellparts").show();
                        } else {
                            angular.element(".arb_sell").attr("data-hasstock","no_stock"); //setter
                        }

                    }, function myError(error) {
                        console.log(error);
                    });

                    // for register sentiments
                    $scope.getSentiments(_symbol, $scope.$parent.fullbidtotal, $scope.$parent.fullasktotal);

                    // $http({
                    //     method : "POST",
                    //     url : "/apipge/?daction=marketsentiment&stock="+_symbol,
                    //     dataType: "json",
                    //     contentType: "application/json",
                    //     data: {
                    //         'action' : 'check_sentiment',
                    //         'stock' : _symbol,
                    //     }
                    // }).then(function mySucces(response) {

                    // }, function myError(error) {
                        
                    // });
                     
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

                        $scope.$parent.getStockTrades(_symbol);
                        
                        $scope.$parent.getFullMarketDepth(_symbol);
                        $scope.$parent.getTopMarketDepth(_symbol);
                            
                        $scope.$parent.getBidsAndAsks(symbol);
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
        }
        window.addEventListener('DOMContentLoaded', initTradingView, false);
    });
}]);

