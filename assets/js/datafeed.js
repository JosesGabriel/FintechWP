'use strict';
var Datafeeds = {};
Datafeeds.UDFCompatibleDatafeed = function(datafeedURL, updateFrequency) {
	this._datafeedURL = datafeedURL;
	this._configuration = {
		supports_search: true,
		supports_group_request: false,
		supported_resolutions: ['1','3','5','15','30','45','60','120','180','240',"D","3D","W","M","3M","6M","12M"],
		supports_marks: false,
		supports_timescale_marks: true,
		supports_time: true,
	};
    this._dataProvider = new DataProvider(this, updateFrequency);
    this.tmscache = {};
};
var DataProvider = (function () {
    function DataPulseProvider(datafeed, updateFrequency) {
    	this._id = (function() {
    	    // http://www.ietf.org/rfc/rfc4122.txt
    	    var s = [];
    	    var hexDigits = "0123456789abcdef";
    	    for (var i = 0; i < 36; i++) {
    	        s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1);
    	    }
    	    s[14] = "4";  // bits 12-15 of the time_hi_and_version field to 0010
    	    s[19] = hexDigits.substr((s[19] & 0x3) | 0x8, 1);  // bits 6-7 of the clock_seq_hi_and_reserved to 01
    	    s[8] = s[13] = s[18] = s[23] = "-";
    	    var uuid = s.join("");
    	    return uuid;
    	})();
        this._subscribers = {};
        var that = this;
        // socket.on('tick', function(data) {
        // 	if (that._subscribers.hasOwnProperty(data.listenerGuid)) {
        // 		var subscriber = that._subscribers[data.listenerGuid];
		// 		var lastBar = {
		// 			time: 	parseFloat(moment(data.t).format('x')),
		// 			close: 	parseFloat(data.c),
		// 			open: 	parseFloat(data.o),
		// 			high: 	parseFloat(data.h),
		// 			low: 	parseFloat(data.l),
		// 			volume: parseInt(data.v),
		// 		};
		// 		subscriber.listener(lastBar);
        // 	}
        // });
        // socket.on('tick2', function(data) {
        // 	if (that._subscribers.hasOwnProperty(data.listenerGuid)) {
        // 		var subscriber = that._subscribers[data.listenerGuid];
		// 		var lastBar = {
		// 			time: 	parseFloat(moment(data.t).format('x')),
		// 			close: 	parseFloat(data.c),
		// 			open: 	parseFloat(data.o),
		// 			high: 	parseFloat(data.h),
		// 			low: 	parseFloat(data.l),
		// 		};
		// 		if (data.v) {
		// 			lastBar.volume = parseFloat(data.v);
		// 		}
		// 		subscriber.listener(lastBar);
        // 	}
		// });
		socket.on('psec', function (data) {
			let listenerGuid = data.sym + '_D';
			if (that._subscribers.hasOwnProperty(listenerGuid)) {
				var subscriber = that._subscribers[listenerGuid];
				var lastBar = {
					time: 	parseFloat(data.t * 1000),
					close: 	parseFloat(data.prv),
					open: 	parseFloat(data.o),
					high: 	parseFloat(data.h),
					low: 	parseFloat(data.l),
					volume: parseFloat(data.vol),
				};
				subscriber.listener(lastBar);
				// console.log('DataPulseProvider: websocket:psec', lastBar);
			}
		});
        // socket.on('reconnect', function() {
        // 	for (var listenerGuid in that._subscribers) {
        // 		socket.emit('subscribeBars2', listenerGuid);
        // 	}
        // });
    }
    DataPulseProvider.prototype.subscribeBars = function (symbolInfo, resolution, newDataCallback, listenerGuid) {
    	var that = this;
        if (that._subscribers.hasOwnProperty(listenerGuid)) {
            // console.log("DataPulseProvider: already has subscriber with id=" + listenerGuid);
            return;
        }
        // if (symbolInfo.type == 'index') {
        // 	socket.emit('subscribeBars3', 'test.' + listenerGuid, that._id);
	    // } else {
        // 	socket.emit('subscribeBars2', listenerGuid);
	    // }
        that._subscribers[listenerGuid] = {
            symbolInfo: symbolInfo,
            resolution: resolution,
            listener: newDataCallback,
        };
        // console.log("DataPulseProvider: subscribed for #" + listenerGuid + " - {" + symbolInfo.name + ", " + resolution + "}");
    };
    DataPulseProvider.prototype.unsubscribeBars = function (listenerGuid) {
        // socket.emit('unsubscribeBars2', listenerGuid);
        // socket.emit('unsubscribeBars3', 'test.' + listenerGuid);
        delete this._subscribers[listenerGuid];
        // console.log("DataPulseProvider: unsubscribed for #" + listenerGuid);
    };
    return DataPulseProvider;
}());
Datafeeds.UDFCompatibleDatafeed.prototype.onReady = function(callback) {
	var that = this;
	setTimeout(function() {
		callback(that._configuration);
	}, 0);
};
Datafeeds.UDFCompatibleDatafeed.prototype.searchSymbols = function(searchString, exchange, type, onResultReadyCallback) {
	var MAX_SEARCH_RESULTS = 30;
	// this._send('https://api2.pse.tools/api/chart/search', {
	this._send('/charthisto/', {
		limit: MAX_SEARCH_RESULTS,
		query: searchString.toUpperCase(),
		type: type,
		exchange: exchange
	}).done(function(response) {
		// var data = JSON.parse(response);
		var data = response;
		for (var i = 0; i < data.length; ++i) {
			if (!data[i].params) {
				data[i].params = [];
			}
		}
		if (typeof data.s == 'undefined' || data.s !== 'error') {
			onResultReadyCallback(data);
		} else {
			onResultReadyCallback([]);
		}
	})
	.fail(function(reason) {
		onResultReadyCallback([]);
	});
};
Datafeeds.UDFCompatibleDatafeed.prototype.resolveSymbol = function(symbolName, onSymbolResolvedCallback, onResolveErrorCallback) {
	var that = this;
	setTimeout(function () {
		var postProcessedData = {
			name: symbolName,
			ticker: symbolName,
			description: null,
			type: null,
			session: '0930-1530:23456',
			exchange: '',
			listed_exchange: '',
			timezone: 'Asia/Hong_Kong',
			minmov: 1,			
			pricescale: 10000,	
			minmove2: 0, 		
			fractional: false, 	
			has_intraday: false,
			supported_resolutions: ['1','3','5','15','30','45','60','120','180','240',"D","3D","W","M","3M","6M","12M"],
			intraday_multipliers: ['1'], // TODO: TEST
			has_seconds: true, // TODO: TEST
			seconds_multipliers: ['1'], // TODO: TEST
			has_daily: true,
			has_weekly_and_monthly: false,
			has_empty_bars: false, // TODO: TEST
			force_session_rebuild: true, // TODO: TEST
			has_no_volume: false,
			volume_precision: 0,
			data_status: 'streaming',
			expired: false,
			sector: 'sector',
			industry: 'industry',
			currency_code: 'PH',
		}
		if (_stocks[symbolName]) {
			postProcessedData.minmov 		= 1;
			postProcessedData.description 	= _stocks[symbolName].description;
			postProcessedData.type 			= _stocks[symbolName].type;
		 	postProcessedData.has_intraday  = _stocks[symbolName].type != 'index';
		 	if (postProcessedData.type == 'index') {
				postProcessedData.pricescale 	= 100;
		 	} else {
				postProcessedData.pricescale 	= parseInt(_stocks[symbolName].pricescale);
		 	}
			if (postProcessedData.has_intraday) {
				 postProcessedData.supported_resolutions = that._configuration.supported_resolutions;
			}
		}
		onSymbolResolvedCallback(postProcessedData);
	}, 0);
};
Datafeeds.UDFCompatibleDatafeed.prototype.calculateHistoryDepth = function(period, resolutionBack, intervalBack) {
	if (parseInt(period) > 0) {
		resolutionBack = 'M';
		intervalBack = 1;
	}
    return {
        resolutionBack: resolutionBack,
        intervalBack: intervalBack,
    };
};
Datafeeds.UDFCompatibleDatafeed.prototype.getBars = function(symbolInfo, resolution, rangeStartDate, rangeEndDate, onDataCallback, onErrorCallback, firstDataRequest) {
	var that = this;
	var url = 'https://dev-v1.arbitrage.ph/wp-json/data-api/v1/charts/history';
	var rangeStartDate = moment.unix(rangeStartDate).format('YYYY-MM-DD');
	var rangeEndDate = moment.unix(rangeEndDate).format('YYYY-MM-DD');
	var params = {
		symbol: symbolInfo.ticker.toUpperCase(),
		// firstDataRequest: firstDataRequest,
		from: rangeStartDate,
		resolution: '1D',
		exchange: 'PSE', //TODO: REFACTOR TO GET FROM STOCK_INFORMATION ENDPOINT
	};

	//check for 1m resolution
	if (resolution != 'D') {
		params.resolution = '1m'
	}
	
	// if ( ! firstDataRequest) {
	// 	params['to'] = rangeEndDate;
	// }
	params['to'] = rangeEndDate;
	that._send(url, params).done(function(sxdata) {
		
		var data = sxdata.data;
		var nodata = data.s === 'no_data';
		if (data.s !== 'ok' && ! nodata) {
			onErrorCallback(data.s);
			return;
		}
		var bars = [];
		var barsCount = nodata ? 0 : data.t.length;
		var volumePresent = typeof data.v != 'undefined';
		for (var i = 0; i < barsCount; i++) {
			var barValue = {
				time: 	data.t[i] * 1000,
				close: 	parseFloat(data.c[i]),
				open: 	parseFloat(data.o[i]),
				high: 	parseFloat(data.h[i]),
				low: 	parseFloat(data.l[i]),
			};
			if (volumePresent) {
				barValue.volume = parseFloat(data.v[i]);
				barValue.foreign = parseFloat(data.v[i]);
			}
			bars.push(barValue);
		}
		var meta = { noData: nodata };
		if (nodata && data.nb) {
			meta.nextTime = data.nb;
		}
		onDataCallback(bars, meta);
		return;
	}).fail( function(arg) {
		// console.warn(['getBars(): HTTP error', arg]);
		// onErrorCallback('network error: ' + JSON.stringify(arg));
		return;
	});
};
Datafeeds.UDFCompatibleDatafeed.prototype.subscribeBars = function (symbols, fastSymbols, onRealtimeCallback, listenerGuid) {
    this._dataProvider.subscribeBars(symbols, fastSymbols, onRealtimeCallback, listenerGuid);
};
Datafeeds.UDFCompatibleDatafeed.prototype.unsubscribeBars = function (listenerGuid) {
    this._dataProvider.unsubscribeBars(listenerGuid);
};
Datafeeds.UDFCompatibleDatafeed.prototype.getMarks = function(symbolInfo, rangeStart, rangeEnd, onDataCallback, resolution) {
	
};
Datafeeds.UDFCompatibleDatafeed.prototype.getTimescaleMarks = function(symbolInfo, rangeStart, rangeEnd, onDataCallback, resolution) {
	var that = this;
	if (that.tmscache[symbolInfo.ticker.toUpperCase()]) {
    	onDataCallback(that.tmscache[symbolInfo.ticker.toUpperCase()]);
	} else {
		this._send("//tsupetot.com/ajax/webTMS.php", {
			symbol: symbolInfo.ticker.toUpperCase(),
		}).done(function(data) {
			data = JSON.parse(data);
			if (data) {
				that.tmscache[symbolInfo.ticker.toUpperCase()] = data;
	        	onDataCallback(data);
			} else {
	        	onDataCallback([]);
			}
		}).fail( function(arg) {
	        onDataCallback([]);
		});
	}
};
Datafeeds.UDFCompatibleDatafeed.prototype.getServerTime = function(callback) {
	this._send(this._datafeedURL + '/time').done(function(response) {
		callback(response);
	});
};
Datafeeds.UDFCompatibleDatafeed.prototype._send = function(url, params) {
	var request = url;
	if (params) {
		for (var i = 0; i < Object.keys(params).length; ++i) {
			var key = Object.keys(params)[i];
			var value = encodeURIComponent(params[key]);
			request += (i === 0 ? '?' : '&') + key + '=' + value;
		}
	}
	var response = $.ajax({
		type: 'GET',
		url: request,
		contentType: 'text/plain'
	});
	return response;
};