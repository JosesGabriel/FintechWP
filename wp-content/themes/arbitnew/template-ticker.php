<?php
	/*
	* Template Name: Stock Ticker
	* Ticker page for All
	*/
	if ( is_user_logged_in() ) {
		// user is now logged in
	} else {
		wp_redirect( '/login', 301 );
		exit;
	}
?><!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="arbitrage">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Chart Ticker</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto:300,400,700,900" rel="stylesheet">
	<link rel="stylesheet" href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" />
	<link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/assets/css/animate.min.css" />
	<link rel="stylesheet" href="/assets/css/style.min.css" />
	<link rel="stylesheet" href="/assets/css/theme/default.css" id="theme" />
    <link href="/assets/css/style-chart.css" rel="stylesheet" />
	<style>
		.arb_top_ticker {display:block;}
		.list-inline>li,
		.list-inline>li+li {
			margin-left: 0px !important;
			border-left: 4px solid #34495e !important;
			margin-bottom: 0 !important;
			padding: 5px 7px 7px 7px !important;
			height:40px !important;
			overflow:hidden;
			vertical-align:top;
			transition: all 1s;
		}
		.list-inline>li+li span {transition:1s all;}
		.list-inline>li{display:inline-block;}
		.list-inline>li+li{margin-bottom:5px !important;}
		.marqueethis {
			/* width:0; */
			height:40px;
			right:-100px;
		}
		.arb_custom_ticker {
			font-size: 10px;
			line-height: 12px;
			padding: 0; 
			display:block !important;
			margin-bottom: 0; 
			position:absolute;
			overflow:hidden; 
		}
		.arb_custom_ticker li {text-align:right;}
		.arb_custom_ticker_wrapper {
			height:40px;
			position: relative;
			overflow: hidden; 
			background-color:#2c3e50; 
			text-align:left;
		}
		.text-white {color: #bdc3c7 !important;}
	</style>
<!-- TEMP SCRIPT AND CSS FOR MARQUEE, TODO: REMOVE -->
</head>
<body>
<div class="arb_top_ticker">
    <div ng-controller="ticker" class="sd_border_btm arb_custom_ticker_wrapper">
        <ul id="container" class="list-inline marqueethis arb_custom_ticker">
            <li ng-repeat="transaction in ticker" ng-class="::{'text-green': 0 < transaction.change, 'text-red': transaction.change < 0, 'text-grey': transaction.change == 0}">
                <i class="fas " ng-class="{'fa-arrow-up': transaction.change > 0, 'fa-arrow-down': transaction.change < 0, 'normpadd': transaction.change == 0}" style="font-size: 14px;"></i>
                <a href="/chart/{{::transaction.symbol}}" target="_blank"><strong class="text-white" style="font-size:14px">{{::transaction.symbol}}</strong></a><br>
                <strong style="font-black: bold !important;">{{::transaction.price}}</strong>
                &nbsp;(<strong style="font-weight: bold !important;">{{::transaction.shares}}</strong>)
            </li>
        </ul>
    </div>
</div>
	
	<!-- end page container -->
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<!--[if lt IE 9]>
		<script src="/assets/crossbrowserjs/html5shiv.js"></script>
		<script src="/assets/crossbrowserjs/respond.min.js"></script>
		<script src="/assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="/assets/js/apps.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.9/angular.min.js"></script>
	<script>
        var socket = io.connect('https://dev-socket-api.arbitrage.ph');

		jQuery(document).ready(function() {
			App.init();
		});
	</script>
<script src="/assets/js/angular/ticker-controller.js?v=<?php echo time() ?>"></script>
</body>
</html> 