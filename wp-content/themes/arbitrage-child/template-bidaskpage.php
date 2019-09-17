<?php
	/*
	* Template Name: bidaskpage
	* Ticker page for All
	*/
	global $current_user; 
    $user = wp_get_current_user();
    $url = get_home_url();
	if ( is_user_logged_in() ) {
		// user is now logged in
	} else {
		wp_redirect( $url.'/login/', 301 );
		exit;
	}
	$user_id = $user->ID;
?><!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="arbitrage">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
    <?php if (WP_PROD_ENV != null && WP_PROD_ENV): ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-147416476-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-147416476-1');
	</script>
	
	<!-- Google Ads -->
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-4838120237791146",
		enable_page_level_ads: true
		});
	</script>
    <?php endif ?>
    
	<title>Bid / Ask Page</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto:300,400,700,900" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

    <style type="text/css">
        body{
            background-color: #0c1f33;
            color: #fff;
        }
        #market_depth{
            margin-left: 10%;
        }
        .text-green{
            color: green;
        }
        .text-red{
            color: red;
        }
    </style>
    <script>
        jQuery(document).ready(function() {

            var stock_symbol = jQuery('#stock_symbol');
            var urlParams = new URLSearchParams(location.search);

            if(!urlParams.get('symbol')){
                return;
            }

            function getBidAsk(symbol,limit,callback){
                let url = "https://data-api.arbitrage.ph/api/v1/stocks/market-depth/latest/bidask?exchange=PSE&limit="+limit+"&symbol="+symbol;
                let settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": url,
                    "method": "GET",
                    "dataType": 'json'
                };
                jQuery.ajax(settings).done(function (response) {
                let res = response.data;
                stock_symbol.html(symbol);
                callback(res);
                });
            };

                var content_bids = "";
                var content_asks = "";
                var row_bid_data = jQuery('#row_bid_data');
                var row_ask_data = jQuery('#row_ask_data');

                getBidAsk(urlParams.get('symbol'),urlParams.get('limit'),function(callback){
                    var bids = callback.bids;
                    var asks = callback.asks;
                    console.log(bids);
                    console.log(asks);
                    //var bids_style = 'text-green': bid.price > stock.previous, 'text-red': bid.price < stock.previous}">${ bids[i].price }
                    for(i in bids){
                        content_bids += `<tr>
                                <td>${ bids[i].count }</td>
                                <td>${ bids[i].volume }</td>
                                <td>${ bids[i].price }</td>
                                </tr>`;
                    }   
                    for(i in asks){
                        content_asks += `<tr>
                                <td>${ asks[i].price }</td>
                                <td>${ asks[i].volume }</td>
                                <td>${ asks[i].count }</td>
                                </tr>`;
                    }   
                    row_bid_data.html(content_bids);
                    row_ask_data.html(content_asks);
                });

        });
    </script>

</head>
<body>
<h4 id="market_depth">Market Depth: <span id="stock_symbol"></span></h4>
<div class="container container-fluid">
  <div class="row no-gutters">
    <!-- Bid -->
    <div class="col-sm">
        <table class="table table-sm">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Volume</th>
            <th scope="col">Bid</th>
            </tr>
        </thead>
        <tbody id="row_bid_data">
            <tr>
            <td></td>
            <td></td>
            <td></td>
            </tr>
        </tbody>
        </table>
    </div>
    <!-- Ask -->
    <div class="col-sm">
        <table class="table table-sm">
        <thead>
            <tr>
            <th scope="col">Ask</th>
            <th scope="col">Volume</th>
            <th scope="col">#</th>
            </tr>
        </thead>
        <tbody id="row_ask_data">
            <tr>
            <td></td>
            <td></td>
            <td></td>
            </tr>
        </tbody>
        </table>
    </div>
  </div>
</div>
    

	<!-- end page container -->
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="/assets/crossbrowserjs/html5shiv.js"></script>
		<script src="/assets/crossbrowserjs/respond.min.js"></script>
		<script src="/assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<script src="/assets/js/apps.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.9/angular.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-numeraljs/2.0.1/angular-numeraljs.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-moment/1.2.0/angular-moment.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/angular-timeago@0.4.6/dist/angular-timeago.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.6/angular-sanitize.min.js"></script>
	<script src="//cdn.rawgit.com/Luegg/angularjs-scroll-glue/master/src/scrollglue.js"></script>
	<script src="/assets/plugins/ng-embed/dist/ng-embed.min.js"></script>
	<script src="/assets/js/jquery.fullscreen-min.js"></script>
	<script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="/assets/js/aes.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
	<script src="https://platform.twitter.com/widgets.js"></script>
	<script>
		var modalzindex = 10000;
    	var nightmode = localStorage.getItem('theme') == 'dark';
        var socket = io.connect('https://dev-socket-api.arbitrage.ph');

		jQuery(document).ready(function() {
			App.init();
		    jQuery( function () {
		        jQuery(".stocks-select2").select2({placeholder:"Stock", width: '100%'})
		    });
		});
		var _stocks     = {};
		var _admin 		= false;
		var _moderator 	= false;
		var _client_id 	= 'arbitrage.ph';
		var _user_id 	= '<?php echo $user->ID; ?>'
		var _username 	= '<?php echo $user->user_email; ?>';
		var _symbol 	= '<?php 
		$getcururl = $_SERVER['REQUEST_URI'];
		if ($getcururl == "/chart/"){
			echo "PSEI";
		}else{
			$remchrt = str_replace("/chart/", "", $getcururl);
			$getfsymb = str_replace("/", "", $remchrt);
			echo strtoupper($getfsymb);
		}
		?>';
	</script>
    <script src="/assets/js/angular/functions.js?v=1.219"></script>
    <script src="/assets/js/angular/controllers.js?v=<?php echo time() ?>"></script>
    <script src="/assets/js/angular/directives.js?v=1.218"></script>
    <script src="/assets/js/angular/filters.js?v=1.218"></script>
    <script src="/assets/tradingview/charting_library/charting_library.min.js?v=1.218"></script>
    <script src="/assets/js/datafeed.js?v=2.218"></script>
</body>
</html> 