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
	<title>Bid / Ask Page</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto:300,400,700,900" rel="stylesheet">
	<link rel="stylesheet" href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" />
	<link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/assets/css/animate.min.css" />
	<link rel="stylesheet" href="/assets/css/style.min.css" />
	<link rel="stylesheet" href="/assets/css/theme/default.css" id="theme" />
    <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/css/style-chart.css" rel="stylesheet" />
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/journal_style.css?<?php echo time(); ?>">
    <style type="text/css">
        body{
            background-color: #0c1f33;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script>
        jQuery(document).ready(function() {
            
            function getBidAsk(symbol,limit,callback){
                let url = "https://data-api.arbitrage.ph/api/v1/stocks/market-depth/latest/bidask?exchange=PSE&limit="+limit+"&symbol="+symbol;
                let settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": url,
                    "method": "GET",
                    "dataType": 'json'
                };
                $.ajax(settings).done(function (response) {
                let res = response.data;
                callback(res);
                });
            };
            getBidAsk('AC',10,function(callback){
                console.log(callback);
            });

        });
    </script>

</head>
<body>
<div class="box-portlet-content">
   <div class="stats-info">
    <div id="live_portfolio" class="dstatstrade overridewidth">
        <ul>
            <li class="headerpart">
                <div style="width:100%;">
                    <div style="width:7%" class="table-title-live">Stocks</div>
                    <div style="width:9%" class="table-title-live">Position</div>
                    <div style="width:9%" class="table-title-live">Average Price</div>
                    <div style="width:9%" class="table-title-live">Total Cost</div>
                    <div style="width:9%" class="table-title-live">Market Value</div>
                </div>
            </li>
            <li>
                <div style="width:100%;">
                    <div style="width:7%" class="table-cell-live"> test1 </div>
                    <div style="width:9%" class="table-cell-live"> test2 </div>
                    <div style="width:9%" class="table-cell-live"> test3 </div>
                    <div style="width:9%" class="table-cell-live"> test4 </div>
                    <div style="width:9%" class="table-cell-live"> test5 </div>
                </div>
            </li>
        </ul>
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
		var _client_id 	= 'arbitrage';
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