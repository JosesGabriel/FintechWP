function setTitle(symbol, last, change) {
    return document.title = symbol + ': ' + last + ' (' + change + '%) | Arbitrage Trading Platform';
}
var pricecounter = 0;
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
function abbr2_format(value) {
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
        return value.format('0,0.00');
    }
}
function roundUp(price) {
    var format = null;
    if (price <= 0.0099) {
        format = {
            fluctuation: 0.0001,
            toFixed: 4,
            numeral: '0,0.0000',
        };
    } else if (price <= 0.0490) {
        format = {
            fluctuation: 0.001,
            toFixed: 3,
            numeral: '0,0.000',
        };
    } else if (price <= 0.2490) {
        format = {
            fluctuation: 0.001,
            toFixed: 3,
            numeral: '0,0.000',
        };
    } else if (price <= 0.4950) {
        format = {
            fluctuation: 0.005,
            toFixed: 3,
            numeral: '0,0.000',
        };
    } else if (price <= 4.9900) {
        format = {
            fluctuation: 0.01,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 9.9900) {
        format = {
            fluctuation: 0.01,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 19.9800) {
        format = {
            fluctuation: 0.02,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 49.9500) {
        format = {
            fluctuation: 0.05,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 99.9500) {
        format = {
            fluctuation: 0.05,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 199.9000) {
        format = {
            fluctuation: 0.10,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 499.8000) {
        format = {
            fluctuation: 0.20,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 999.5000) {
        format = {
            fluctuation: 0.50,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 1999.0000) {
        format = {
            fluctuation: 1.00,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 4998.0000) {
        format = {
            fluctuation: 2.00,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else {
        format = {
            fluctuation: 5.00,
            toFixed: 2,
            numeral: '0,0.00',
        };
    }
    return price;
}
function price_info(price) {
    if (price <= 0.0099) {
        return {
            fluctuation: 0.0001,
            boardlot: 1000000,
            toFixed: 4,
            numeral: '0,0.0000',
        };
    } else if (price <= 0.0490) {
        return {
            fluctuation: 0.001,
            boardlot: 100000,
            toFixed: 3,
            numeral: '0,0.000',
        };
    } else if (price <= 0.2490) {
        return {
            fluctuation: 0.001,
            boardlot: 10000,
            toFixed: 3,
            numeral: '0,0.000',
        };
    } else if (price <= 0.4950) {
        return {
            fluctuation: 0.005,
            boardlot: 10000,
            toFixed: 3,
            numeral: '0,0.000',
        };
    } else if (price <= 4.9900) {
        return {
            fluctuation: 0.01,
            boardlot: 1000,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 9.9900) {
        return {
            fluctuation: 0.01,
            boardlot: 100,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 19.9800) {
        return {
            fluctuation: 0.02,
            boardlot: 100,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 49.9500) {
        return {
            fluctuation: 0.05,
            boardlot: 100,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 99.9500) {
        return {
            fluctuation: 0.05,
            boardlot: 10,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 199.9000) {
        return {
            fluctuation: 0.10,
            boardlot: 10,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 499.8000) {
        return {
            fluctuation: 0.20,
            boardlot: 10,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 999.5000) {
        return {
            fluctuation: 0.50,
            boardlot: 10,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 1999.0000) {
        return {
            fluctuation: 1.00,
            boardlot: 5,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else if (price <= 4998.0000) {
        return {
            fluctuation: 2.00,
            boardlot: 5,
            toFixed: 2,
            numeral: '0,0.00',
        };
    } else {
        return {
            fluctuation: 5.00,
            boardlot: 5,
            toFixed: 2,
            numeral: '0,0.00',
        };
    }
}
function reply(username) {
    var message = $('#m').val();
    $('#m').val((message + ' @' + username).trim() + ' ').focus();
    return false;
}
function replymember(username) {
    var message = $('#mmember').val();
    $('#mmember').val((message + ' @' + username).trim() + ' ').focus();
    return false;
}
function beep() {
    var beepSound = new Audio("/audio/vk_notification.mp3");
    var promise = beepSound.play();

    if (promise !== undefined) {
        promise.then(_ => {
            // Autoplay started!
        }).catch(error => {
            // Autoplay was prevented.
            // Show a "Play" button so that user can start playback.
        });
    }
}
function changicotogreen() {
	var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
	link.type = 'image/x-icon';
	link.rel = 'shortcut icon';
	link.href = '/images/arb_icon_greenarrow.png';
	document.getElementsByTagName('head')[0].appendChild(link);
	setTimeout(function(){ 
		var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
		link.type = 'image/x-icon';
		link.rel = 'shortcut icon';
		link.href = '/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-192x192.png';
		document.getElementsByTagName('head')[0].appendChild(link);
	}, 2000);
}
function changicotored() {
	var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
	link.type = 'image/x-icon';
	link.rel = 'shortcut icon';
	link.href = '/images/arb_icon_redarrow.png';
	document.getElementsByTagName('head')[0].appendChild(link);
	setTimeout(function(){ 
		var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
		link.type = 'image/x-icon';
		link.rel = 'shortcut icon';
		link.href = '/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-192x192.png';
		document.getElementsByTagName('head')[0].appendChild(link);
	}, 2000);
}
function changicotounchanged() {
	var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
	link.type = 'image/x-icon';
	link.rel = 'shortcut icon';
	link.href = '/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-192x192.png';
	document.getElementsByTagName('head')[0].appendChild(link);
	setTimeout(function(){ 
		var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
		link.type = 'image/x-icon';
		link.rel = 'shortcut icon';
		link.href = '/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-192x192.png';
		document.getElementsByTagName('head')[0].appendChild(link);
	}, 2000);
}

function goToChart(symbol) {
    if (chart) {
        chart.setSymbol(symbol.toUpperCase());
    }
    return false;
}