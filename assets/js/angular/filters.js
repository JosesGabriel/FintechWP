app.filter('nl2br', [
    '$sanitize', 
    function($sanitize) {

        var breakTag='<br />';

        return function(msg) {
            msg = (msg + '').replace(/(\r\n|\n\r|\r|\n|&#10;&#13;|&#13;&#10;|&#10;|&#13;)/g, breakTag + '$1');
            return $sanitize(msg);
        };

    }
]);

app.filter('stringHashtagsAndMention', ['$sce', function($sce) {
    return function(text) {

        if ( ! text) return text;

        var replacedText = text.trim();

        var replacePattern1 = /(^|\s|&#10;)\@(\w*[a-zA-Z_:]+\w*)/gim;
        replacedText = replacedText.replace(replacePattern1, '$1<a href="javascript:void(0);" style="font-weight: bold;" onclick="return reply(\'$2\')">@$2</a>');

        var replacePattern2 = /(^|\s|&#10;)\$(\w*[a-zA-Z_:]+\w*)/gim;
        replacedText = replacedText.replace(replacePattern2, '$1<a href="/chart/$2" target="_parent" style="font-weight: bold;" class="text-uppercase" onclick="return goToChart(\'$2\');">&#36;$2</a>');

        return $sce.trustAsHtml(replacedText + '<br/>');
    };
}]);

app.filter('timeago', function() {
    return function(text) {
        if (text) {
            return $.timeago(text);
        }
    };
});

app.filter('price', function() {
    return function(text, base) {
        return price_format(text, base);
    };
});

app.filter('abbr', function() {
    return function(text) {
        return abbr_format(text).toUpperCase();
    };
});

app.filter('abbr2', function() {
    return function(text) {
        return abbr2_format(text).toUpperCase();
    };
});

app.filter('trim', function() {
    return function(text, length) {
        if (text) {
            return text.substr(0,length).trim();
        }
    };
});

app.filter('https',function() {
    return function(input) {
        if (input) {
            return input.replace('http://', 'https://');    
        }
    }
});

app.filter('orderObjectBy', function(){
 return function(input, attribute) {
    if (!angular.isObject(input)) return input;

    var array = [];
    for(var objectKey in input) {
        array.push(input[objectKey]);
    }

    array.sort(function(a, b){
        a = parseInt(a[attribute]);
        b = parseInt(b[attribute]);
        return b - a;
    });
    return array;
 }
});