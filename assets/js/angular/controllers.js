var widget;
var chart;
var marketdepthTimeout;
var PineJS;
// var INDICES = ['PSEI','ALL','FIN','HDG','IND','M-O','PRO','SVC'];
var app = angular.module('arbitrage', ['ngSanitize','ngEmbed','ngNumeraljs','yaru22.angular-timeago','luegg.directives']);
app.run(['$rootScope', '$http', function($rootScope, $http) {
    // $rootScope.newMessages = 0;
    $rootScope.selectedSymbol = _symbol;
    $rootScope.tickerBeep = true;

    $http.post("/wp-json/data-api/v1/stocks/list")
        .then(function(response) {
            _stocks = response.data.data;
        })
}]);

app.controller('ticker', ['$scope', function($scope) {
    
    $scope.enable = true;
    $scope.ticker = [];
    
    $scope.tickerEnabler = function (){
        $scope.enable = !$scope.enable;
    }

    socket.on('psec', function (data) {  
    
            var transaction = {
                symbol: data.sym,
                price:  price_format(data.prv),
                change: data.chg,
                shares: abbr_format(data.vol)
            }

            if($scope.enable){
                
                $scope.ticker.push(transaction);

                if ($scope.ticker.length > 30) {
                    $scope.ticker.shift();
                }

            }

    });   
      
}]);

/*
app.controller('ticker', ['$scope', '$interval', function($scope, $interval) {
    
    // $scope.ticker_intervalId;
    $scope.enable = false;
    // $scope.isTickerFull = false;
    $scope.ticker = [];
    // $scope.data = [];
    // $scope.counter = 0;
    // $scope.width = 0;
    
    $scope.tickerEnabler = function (){
        $scope.enable = !$scope.enable;
    //     if($scope.enable) {
    //      //   $scope.tickerStart();
    //     } else {
    //       //  $scope.tickerStop();
    //     }
    }

    // $scope.tickerStart = function() {
    //     jQuery('#webTicker').mouseover();
    //     jQuery('#webTicker').mouseleave();
    //     if ($scope.ticker_intervalId) {
    //         $interval.cancel($scope.ticker_intervalId);
    //     }
    //     $scope.ticker_intervalId = $interval(function(){
    //         jQuery('#webTicker').mouseover();
    //         jQuery('#webTicker').mouseleave();
    //     }, 1000,10);
    // };

    // $scope.tickerStop = function() {
    //     $interval.cancel($scope.ticker_intervalId);
    // }; 

    // // cheat to keep ticker plugin start moving
    // var rawdate = [{"sym":"","prv":0,"chg":0,"vol":0 }]
    // for(i in rawdate){
    //     var transaction = {
    //         symbol: rawdate[i].sym,
    //         price:  price_format(rawdate[i].prv),
    //         change: rawdate[i].chg,
    //         shares: abbr_format(rawdate[i].vol),
    //         counter: 0
    //     };
    //     $scope.ticker.push(transaction);
    // }
    // $interval(function() {
    //         $scope.ticker.shift(); 
    // }, 500, parseInt(rawdate.length));
    // // end 

    // // $interval(function() {  
    // //     let width = $scope.width+=5;
    // //     jQuery('#webTicker').animate({left: width + 'px'});
    // //     console.log(width);
    // // },100)

    // if($scope.enable){
    //     $interval(function() {  
    //         if ($scope.data.length && $scope.isTickerFull == true) {
    //             $scope.ticker.push($scope.data[0]);
    //             $scope.data.shift();
    //             $scope.ticker.shift();
    //         }
    //     }, 1000);
    // }

    socket.on('psec', function (data) {  
        if($scope.enable){
            var transaction = {
                symbol: data.sym,
                price:  price_format(data.prv),
                change: data.chg,
                shares: abbr_format(data.vol),
                // counter: $scope.counter++
            }

            // if ($scope.ticker.length <= 30 && $scope.isTickerFull == false) {
            //     $scope.ticker.push(transaction);
            // } else {
            //     if($scope.data.length>500){
            //         $scope.data = [];
            //     }
            //     $scope.isTickerFull = true
            //     $scope.data.push(transaction);
            // } 
            if ($scope.ticker.length > 30) {
                $scope.ticker.shift();
            }
            $scope.ticker.push(transaction);
        }
        
        // $scope.$apply();

    }); 
    
}]);
*/

app.controller('template', function($scope, $http) {
    // var settings = {
    //     chart: '1',
    //     chat: '0',
    //     ticker: '2',
    //     left: '1',
    //     right: '1',
    //     disclosure: '1',
    // };
    // var new_settings = JSON.parse(localStorage.getItem('settings'));
    // if (new_settings) {
    //     jQuery.extend(settings, new_settings);
    // }
    // $scope.settings = settings;
    // $scope.updateSettings = function(key) {
    //     localStorage.setItem('settings', JSON.stringify($scope.settings));
    // }
    // $scope.marketopen = false;
    // socket.on('servertime', function(data) {
    //     $scope.marketopen = data.is_market_open == '1';
    // });
});
app.controller('chart', ['$scope','$filter', '$http', '$rootScope', '$timeout', function($scope, $filter, $http, $rootScope, $timeout) {
    var vm = this;
    vm.Total = 0;
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    $scope.latest_trading_date = null;
    $scope.gainers      = 0;
    $scope.losers       = 0;
    $scope.unchanged    = 0;
    // $scope.stocks = [];
    // $scope.watchlists = {
    //     'All Stocks': 'stocks', 
    //     'New Watchlist': 'new',
    //     'Default Watchlist': JSON.parse(localStorage.getItem('watchlist')) || [],
    // };
    // $scope.watchlist = 'All Stocks';
    // $scope.lastWatchlist = 'All Stocks';
    // $scope.sort = 'value';
    // $scope.reverse  = true;
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
    // $http.post("/wp-json/data-api/v1/stocks/history/latest-active-date")
    //     .then(response => {
    //         if (response.data.success) {
    //             $scope.latest_trading_date = moment(response.data.data.date)
    //         }
    //     })
    // $http.post("/wp-json/data-api/v1/stocks/history/latest?exchange=PSE").then( function (response) {
    //     $rootScope.$emit('changeStockSymbol', _symbol);
        
    //     stocks = response.data.data;
    //     stocks = Object.values(stocks);
    //     stocks.map(function(stock) {
    //         stock['lastupdatetime'] = moment(stock['lastupdatetime']);
    //         stock['last']       = parseFloat(stock['last']);
    //         // stock['difference'] = parseFloat(stock['difference']);
    //         // stock['change']     = parseFloat(stock['change']);
    //         stock['change_percentage'] = parseFloat(stock['changepercentage']);
    //         // stock['previous']   = parseFloat(stock['close']);
    //         stock['open']       = parseFloat(stock['open']);
    //         stock['high']       = parseFloat(stock['high']);
    //         stock['low']        = parseFloat(stock['low']);
    //         // stock['average']    = parseFloat(stock['average']);
    //         // stock['volume']     = parseFloat(stock['volume']);
    //         stock['value']      = parseFloat(stock['value']);
    //         stock['trades']     = parseFloat(stock['trades']);
    //         stock['displayLast']  = price_format(stock['last']);
    //         // stock['displayDifference']  = price_format(stock['change']);
    //         // stock['displayOpen']  = price_format(stock['open']);
    //         // stock['displayPrevious']  = price_format(stock['close']);
    //         // stock['displayAverage']  = price_format(stock['average']);
    //         // stock['displayLow']  = price_format(stock['low']);
    //         // stock['displayHigh']  = price_format(stock['high']);
    //         stock['displayChange']  = number_format(stock['changepercentage'], '0,0.00');
    //         stock['displayValue'] = abbr_format(stock['value']).toUpperCase();
    //         // stock['weekYearLow'] = price_format(stock['weekyearlow']);
    //         // stock['weekYearHigh'] = price_format(stock['weekyearhigh']);
    //         // stock['displayMarketCap'] = abbr_format(stock.marketcap).toUpperCase();
    //         return stock;
    //     });

        
        
    //     $scope.stocks = stocks;
    //     $scope.count = $scope.stocks.reduce( function(a, b) {
    //         if (b.change < 0) {
    //             a.losers = ++a.losers || 1;
    //         }  
    //         if (b.change === 0) {
    //             a.unchanged = ++a.unchanged || 1;
    //         }  
    //         if (b.change > 0) {
    //             a.gainers = ++a.gainers || 1;
    //         }
    //         return a;
    //     }, {});
        
    //     // $scope.stock = $filter('filter')($scope.stocks, {symbol: _symbol}, true)[0];
    // });

    // $scope.updateTabTitle = function (symbol, data) {
    //     if (data.change > 0){
    //         if ($rootScope.tickerBeep) beep();
    //         changicotogreen();
    //     }
    //     if (data.change < 0){
    //         if ($rootScope.tickerBeep) beep();
    //         changicotored();
    //     }
    //     if (data.change = 0){
    //         changicotounchanged();
    //     }
    //     setTitle(symbol, data.displayLast, data.displayChange);
    // }

    // socket.on('psec', function (data) {
    //     let full_date = (moment(data.t * 1000)).format('ll')
    //     let stock = {
    //         id: data.sym,
    //         symbol: data.sym,
    //         date: full_date,
    //         last: data.prv,
    //         // difference: data.chgpc,
    //         // change: data.chg,
    //         change_percentage: data.chgpc,
    //         // previous: data.c,
    //         // open: data.o,
    //         // high: data.h,
    //         // low: data.l,
    //         // average: data.avg,
    //         // volume: data.vol,
    //         value: data.val,
    //         trades: data.tr,
    //         updated_at: full_date,

    //         // displayLast: price_format(data.prv),
    //         // displayDifference: price_format(data.chg, data.prv),
    //         // displayOpen: price_format(data.o),
    //         // displayPrevious: price_format(data.c),
    //         // displayAverage: price_format(data.avg),
    //         // displayLow: price_format(data.l),
    //         // displayHigh: price_format(data.h),
    //         // displayChange: number_format(data.chgpc, '0,0.00'),
    //         displayValue: abbr_format(data.val),
    //     }

    //     // UPDATE STOCK
    //     var found = $filter('filter')($scope.stocks, {symbol: stock.symbol}, true);
    //     var current_stock_index = null;
    //     if (found.length) {
    //         current_stock_index = $scope.stocks.indexOf(found[0]);
    //         $scope.stocks[current_stock_index] = Object.assign($scope.stocks[current_stock_index], stock);
    //     } else $scope.stocks.push(stock);

    //     if ($scope.stock && $scope.stock.symbol == stock.symbol) {
    //         stock = Object.assign(stock, {
    //             difference: data.chgpc,
    //             change: data.chg,
    //             previous: data.c,
    //             open: data.o,
    //             high: data.h,
    //             low: data.l,
    //             average: data.avg,
    //             volume: data.vol,
    //             // displayDifference: price_format(data.chg, data.prv),
    //             // displayOpen: price_format(data.o),
    //             // displayPrevious: price_format(data.c),
    //             // displayAverage: price_format(data.avg),
    //             // displayLow: price_format(data.l),
    //             // displayHigh: price_format(data.h),
    //         })

    //         $scope.updateTabTitle(stock.symbol, {
    //             change: stock.change,
    //             displayChange: number_format(stock.change_percentage, '0,0.00'),
    //             displayLast: price_format(stock.last),
    //         })
            
    //         if (current_stock_index) {
    //             $scope.stock = $scope.stocks[current_stock_index];
    //         } else {
    //             $scope.stock = stock;
    //         }

    //         $rootScope.$emit('updateStockData', stock);
    //     }
        
    //     $scope.count = $scope.stocks.reduce( function(a, b) {
    //         if (b.change < 0) {
    //             a.losers = ++a.losers || 1;
    //         }  
    //         if (b.change === 0) {
    //             a.unchanged = ++a.unchanged || 1;
    //         }  
    //         if (b.change > 0) {
    //             a.gainers = ++a.gainers || 1;
    //         }
    //         return a;
    //     }, {});

    //     $scope.$digest();
    // });

    // $scope.sortStocks = function(sort) {
    //     if ($scope.sort == sort) {
    //         $scope.reverse = !$scope.reverse;
    //     } else {
    //         $scope.reverse = false;
    //         $scope.sort = sort;
    //     }
    // }
    // $scope.select = function (symbol) {
    //     $rootScope.selectedSymbol = $scope.selectedStock = _symbol = symbol;
    //     var found = $filter('filter')($scope.stocks, {symbol: $scope.selectedStock}, true);
    //     if (found.length) {
    //         $scope.stock = $scope.stocks[$scope.stocks.indexOf(found[0])];
    //     } else {
    //         $scope.stock = null;
    //     }
    //     $scope.marketdepth  = [];
    //     if (marketdepthTimeout) {
    //         window.clearTimeout(marketdepthTimeout);
    //     }
    //     marketdepthTimeout = setTimeout( function() {
    //         goToChart(symbol);
    //     }, 100);
    //     $('#select-' + symbol).focus();
    // };
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
app.controller('stockInfo', ['$scope', '$rootScope', '$http', function($scope, $rootScope, $http) {
    $scope.hasData = false;
    $scope.stock = null;
    $scope.stockInfo = null;

    $rootScope.$on('changeStockSymbol', function (event, symbol) {
        $scope.getStockData(symbol);
    });

    $rootScope.$on('updateStockData', function (event, data) {
        $scope.updateStockData(data);
    });

    $scope.getStockData = function (symbol) {
        $http.post(`/wp-json/data-api/v1/stocks/history/latest?exchange=PSE&symbol=${symbol}`)
            .then(response => {
                let data = response.data;
                if (data.success) {
                    $scope.hasData = true;
                    let stock = data.data;
                    $scope.updateStockInfo(stock);
                    $scope.stock = {
                        lastupdatetime: moment(stock.lastupdatetime),
                        last: parseFloat(stock.last),
                        difference: parseFloat(stock.difference),
                        change: parseFloat(stock.change),
                        change_percentage: parseFloat(stock.changepercentage),
                        previous: parseFloat(stock.close),
                        open: parseFloat(stock.open),
                        high: parseFloat(stock.high),
                        low: parseFloat(stock.low),
                        average: parseFloat(stock.average),
                        volume: parseFloat(stock.volume),
                        value: parseFloat(stock.value),
                        trades: parseFloat(stock.trades),
                        // displayLast: price_format(stock.last),
                        // displayDifference: price_format(stock.change),
                        // displayOpen: price_format(stock.open),
                        // displayPrevious: price_format(stock.close),
                        // displayAverage: price_format(stock.average),
                        // displayLow: price_format(stock.low),
                        // displayHigh: price_format(stock.high),
                        // displayChange: number_format(stock.changepercentage, '0,0.00'),
                        displayValue: abbr_format(stock.value).toUpperCase(),
                        // weekYearLow: price_format(stock.weekyearlow),
                        weekYearLow: parseFloat(stock.weekyearlow),
                        // weekYearHigh: price_format(stock.weekyearhigh),
                        weekYearHigh: parseFloat(stock.weekyearhigh),
                        displayMarketCap: abbr_format(stock.marketcap).toUpperCase(),
                    }
                } else {
                    $scope.stock = null;
                    $scope.hasData = false;
                }
            })
            .catch(response => {
                $scope.stock = null;
                $scope.hasData = false;
            });
    }

    $scope.updateStockData = function (data) {
        if ($scope.stock && data.symbol == $scope.stockInfo.symbol) {
            $scope.stock = Object.assign($scope.stock, data);
        } else {
            $scope.stock = data;
        }
    };

    $scope.updateStockInfo = function (data) {
        if (data) {
            $scope.stockInfo = {
                symbol: data.symbol.toUpperCase(),
                description: data.description.toUpperCase(),
            }
        }
    }
}]);
app.controller('marketDepth', ['$scope', '$rootScope', '$http', '$filter', function ($scope, $rootScope, $http, $filter) {
    $scope.enableBidsAndAsks = true;
    $scope.isLoading = false;
    $scope.bids = [];
    $scope.asks = [];

    $scope.getBidsAndAsks = function (symbol) {
        if ($scope.enableBidsAndAsks) {
            $scope.isLoading = true;
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
                $scope.isLoading = false;
            })
            .catch(err => {
                $scope.bids = [];
                $scope.asks = [];
                $scope.isLoading = false;
            });
        }
    }
    // $scope.getBidsAndAsks(_symbol);

    $rootScope.$on('changeStockSymbol', function (event, symbol) {
        $scope.getBidsAndAsks(symbol);
    });

    /**
     * Types
     *  a => add
     *  au => update price
     *  d => delete
     *  u => update new order
     *  fd => fully executed delete order (subtract count and volume)
     *  pd => partially executed delete order (subtract volume)
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
        } else if (data.ty = 'fd') {
            // decrement data.id's count by 1, if count is zero, remove from list
            list = $scope.updateBidAskCount(list, index, -1, 0);

            list = $scope.updateBidAskVolume(list, index, (-1 * data.vol));
        } else if (data.ty = 'pd') {
            list = $scope.updateBidAskVolume(list, index, data.vol);
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

    $scope.updateBidAskVolume = function (list, id, increment) {
        if (typeof list[id] !== 'undefined') {
            list[id].volume += increment;
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
}]);
app.controller('transactions', ['$scope', '$rootScope', '$http', function ($scope, $rootScope, $http) {
    $scope.isLoading = false;
    $scope.currentStock = '';
    $scope.transactions = [];

    $scope.getStockTrades = function (symbol = '', limit = 20) {
        if (symbol != 'PSEI' && symbol != '') {
            $scope.isLoading = true;
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
                    $scope.isLoading = false;
                    $scope.$digest();
                })
                .catch(err => {
                    $scope.isLoading = false;
                });
        }
    }
    
    $rootScope.$on('changeStockSymbol', function (event, symbol) {
        $scope.currentStock = symbol;
        $scope.getStockTrades(symbol);
    });

    socket.on('pset', function (data) {
        if ($scope.currentStock && $scope.currentStock == data.sym) {
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
}]);
app.controller('stocksList', ['$scope', '$rootScope', '$http', '$filter', function ($scope, $rootScope, $http, $filter) {
    $scope.stocks = [];
    $scope.latest_trading_date = null;

    $scope.sortStocks = function(sort) {
        if ($scope.sort == sort) {
            $scope.reverse = !$scope.reverse;
        } else {
            $scope.reverse = false;
            $scope.sort = sort;
        }
    }

    $scope.select = function (symbol) {
        $rootScope.$emit('changeStockSymbol', symbol);
    };

    $scope.updateTabTitle = function (symbol, data) {
        if (data.change > 0){
            if ($rootScope.tickerBeep) beep();
            changicotogreen();
        }
        if (data.change < 0){
            if ($rootScope.tickerBeep) beep();
            changicotored();
        }
        if (data.change = 0){
            changicotounchanged();
        }
        setTitle(symbol, data.displayLast, data.displayChange);
    }

    $scope.getLatestActiveDate = function () {
        $http.post("/wp-json/data-api/v1/stocks/history/latest-active-date")
        .then(response => {
            if (response.data.success) {
                $scope.latest_trading_date = moment(response.data.data.date)
            }
        });
    }

    $scope.getStocksList = function () {
        $http.post("/wp-json/data-api/v1/stocks/history/latest?exchange=PSE").then( function (response) {
            stocks = response.data.data;
            stocks = Object.values(stocks);
            stocks.map(function(stock) {
                stock['lastupdatetime'] = moment(stock['lastupdatetime']);
                stock['last']       = parseFloat(stock['last']);
                stock['change_percentage'] = parseFloat(stock['changepercentage']);
                stock['open']       = parseFloat(stock['open']);
                stock['high']       = parseFloat(stock['high']);
                stock['low']        = parseFloat(stock['low']);
                stock['value']      = parseFloat(stock['value']);
                stock['trades']     = parseFloat(stock['trades']);
                stock['displayLast']  = price_format(stock['last']);
                stock['displayChange']  = number_format(stock['changepercentage'], '0,0.00');
                stock['displayValue'] = abbr_format(stock['value']).toUpperCase();
                return stock;
            });
    
            $scope.stocks = stocks;
        });
    }

    $scope.initializeList = function () {
        $scope.getLatestActiveDate();
        $scope.getStocksList();
        $rootScope.$emit('changeStockSymbol', _symbol);
    }

    $scope.initializeList();

    socket.on('psec', function (data) {
        let full_date = (moment(data.t * 1000)).format('ll')
        let stock = {
            id: data.sym,
            symbol: data.sym,
            date: full_date,
            last: data.prv,
            change_percentage: data.chgpc,
            value: data.val,
            trades: data.tr,
            updated_at: full_date,
            displayValue: abbr_format(data.val).toUpperCase(),
        }

        // UPDATE STOCK
        var found = $filter('filter')($scope.stocks, {symbol: stock.symbol}, true);

        if (found.length) {
            var stock_index = $scope.stocks.indexOf(found[0]);
            $scope.stocks[stock_index] = Object.assign($scope.stocks[stock_index], stock);
        } else {
            $scope.stocks.push(stock);
        }

        if ($scope.stock && $scope.stock.symbol == stock.symbol) {
            stock = Object.assign(stock, {
                difference: data.chgpc,
                change: data.chg,
                previous: data.c,
                open: data.o,
                high: data.h,
                low: data.l,
                average: data.avg,
                volume: data.vol,
            })

            $scope.updateTabTitle(stock.symbol, {
                change: stock.change,
                displayChange: number_format(stock.change_percentage, '0,0.00'),
                displayLast: price_format(stock.last),
            })

            $rootScope.$emit('updateStockData', stock);
        }

        $scope.$digest();
    });
}]);
app.controller('watchlist', ['$scope', '$rootScope', '$http', '$filter', function ($scope, $rootScope, $http, $filter) {
    $scope.isLoading = false;
    $scope.watchlist = [];

    $scope.getWatchlist = function () {
        $scope.isLoading = true;
        $http.get('/wp-json/watchlist-api/v1/watchlists?userid=' + _user_id)
        .then(res => {
            if (res.data.status) {
                $scope.watchlist = res.data.data.map(stock => {
                    return Object.assign(stock, {
                        symbol: stock.stockname,
                        value: stock.last,
                        change: stock.change_price,
                        change_percentage: stock.change,
                    });
                });
            }
        })
        .finally(() => {
            $scope.isLoading = false;
        })
    }
    $scope.getWatchlist();

    $rootScope.$on('updateStockData', function (event, stock) {
        var wl_stock = $filter('filter')($scope.watchlist, {stockname: stock.symbol}, true);
        if (wl_stock.length) {
            console.log(stock, wl_stock)
            var stock_index = $scope.watchlist.indexOf(wl_stock[0]);
            $scope.watchlist[stock_index] = Object.assign($scope.watchlist[stock_index], {
                value: stock.displayValue,
                change: stock.change,
                change_percentage: stock.change_percentage,
            });
        }
    })
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
                custom_indicators_getter: function(pinejs) {
                    PineJS = pinejs;
                    return Promise.resolve(__customIndicators);
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


                        $rootScope.$emit('changeStockSymbol', _symbol);
                        $scope.$parent.getStockTrades(_symbol);
                        
                        $scope.$parent.getFullMarketDepth(_symbol);
                        $scope.$parent.getTopMarketDepth(_symbol);
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

                widget.headerReady().then(function() {
                    widgetCreateButton('Support and Resistance', 'S&R', function (e) {
                        widget.chart().createStudy('Support and Resistance', false, false);
                    });

                    widgetCreateButton(
                        'Fullscreen', 
                        '<div class="button-2-lC3gh4- button-2ioYhFEY- apply-common-tooltip isInteractive-20uLObIc-" style="margin: 0 -10px !important;"><span class="icon-beK_KS0k-"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" width="28" height="28"><g fill="currentColor"><path d="M21 7v4h1V6h-5v1z"></path><path d="M16.854 11.854l5-5-.708-.708-5 5zM7 7v4H6V6h5v1z"></path><path d="M11.146 11.854l-5-5 .708-.708 5 5zM21 21v-4h1v5h-5v-1z"></path><path d="M16.854 16.146l5 5-.708.708-5-5z"></path><g><path d="M7 21v-4H6v5h5v-1z"></path><path d="M11.146 16.146l-5 5 .708.708 5-5z"></path></g></g></svg></span></div>', 
                        function (e) {
                            $('#tv_chart_container').toggleFullScreen();
                        },
                        {align: "right"}
                    );
                });
            });

            function widgetCreateButton(title, content, callback, options) {
                var button = widget.createButton(options);
                button.setAttribute('title', title);
                button.addEventListener('click', callback);
                button.innerHTML = `<div class="tradingview-custom-btn">${content}</div>`;
            }
        }
        window.addEventListener('DOMContentLoaded', initTradingView, false);
    });
}]);

