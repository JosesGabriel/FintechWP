<?php
	/*
	* Template Name: Stock Ticker
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
    <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/css/style-chart.css" rel="stylesheet" />
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->

	
    <style type="text/css">
		.arb_right_icons_trans {display:none;}
		.arb_buysell {
			position: absolute;
			top: 6px;
			left: -355px;
			z-index: 999999;
		}
		.arb_buy {
			display: inline-block;
			height: 28px;
			line-height: 30px;
			text-align: center;
			color: #fff;
			background-color: #25ae5f;
			padding: 0 13px 0 11px;
			text-transform: uppercase;
			font-size: 13px;
			border-radius: 50px;
			font-weight: 300;
			vertical-align: top;
		}
		.arb_buy:hover {background-color: #229a55;}
		.arb_sell {
			display: inline-block;
			height: 32px;
			line-height: 34px;
			text-align: center;
			color: #fff;
			background-color: #e64c3c;
			padding: 0 14px;
			text-transform: uppercase;
			font-size: 14px;
			font-weight: 300;
			margin-left: -3px;
			border-radius: 0 50px 50px 0;
			vertical-align: top;
		}
		.arb_sell:hover {background-color: #d04234;}
		.arb_buysell i.fas {
			color: #fff;
			font-size: 17px;
			margin-top: -3px;
			vertical-align: middle;
		}
		.arb_sell:focus,
		.arb_buy:focus,
		.arb_sell:active,
		.arb_buy:active,	
		.arb_sell:hover,
		.arb_buy:hover {
			color:#fff !important;
			text-decoration:none !important;
		}
		.arb_top_ticker {
			position:absolute;
			top:0;
			left:0;
			z-index:9;
			width:100%;
		}
		.arb_right_icons_trans {
			position: absolute;
			width: 180px;
			right: 7px;
			top: 0;
			background-color: transparent;
			z-index: 9999999;
		}
		.arb-side-icon i {
			border: 2px solid #fff;
			border-radius: 100%;
			width: 32px;
			height: 32px;
			line-height: 30px;
			font-size: 15px;
			background-color: #2c3e50;
		}
		.nav-tabs>li>a {
			margin-right: 5px;
			line-height: 20px;
			background-color: #34495e;
			color: #fff;
			border-radius: 0;
		}
		tr {
			font-size: 11px;
		}
		span.bidaskbar_btn {
			display: block;
			cursor: pointer;
		}
		.bidaskbar_opt {
			position: absolute;
			background-color: #2c3e50;
			width: 80px;
			left: 87px;
			z-index: 9;
		}
		.bidaskbar_opt ul {
			margin: 0;
			padding: 3px 7px;
			list-style: none;
			border: 1px solid #34495e;
			text-align: center;
		}
		.bidaskbar_opt li {
			padding: 3px 0;
		}
		.bidaskbar_opt ul li a {
			color:#bdc3c7;
		}
		.bidaskbar_opt ul li a:hover {
			color:#fff;
			text-decoration:none;
		}
		.bidaskbar_opt {display:none;}
		.text-white {color: #bdc3c7 !important;}
		#tv_chart_container iframe,
		#tv_chart_container {
			height: 100%;
		}
		.arb_padding_5.b0.bidaskbar,
		.arb_padding_5.b0.arb_bullbear {
			border-top: 4px #34495e solid;
		}
		/*.sd_border_btm {
			border-bottom: 4px #34495e solid;
		}*/
		.sd_border_top {
			border-top: 4px #34495e solid;
		}
		.allstocksbox {
			height: 276px;
			overflow: hidden;
			display: block;
			padding: 5px 0 5px 0;
		}
		.list-inline>li{display:inline-block;}
		.list-inline>li+li{margin-bottom:5px !important;}
    </style>
    <?php /*?> Enter Trade CSS <?php */?>
	<style>
    .hideformodal {display:none;}
    /* Enter Trade Form */
    .groupinput label {
        display: inline-block;
        width: 46px;
        font-weight: 300;
        font-size: 13px;
        height: 27px;
        line-height: 27px;
        padding: 0 0 0 7px;
        background-color: #34495e;
        border: none;
        color: #ecf0f1;
        border-radius: 3px 0 0 3px;
        margin-bottom: 0;
    }
    .groupinput input[type="text"] {
        display: inline-block;
        border-radius: 0 3px 3px 0;
        width: 172px;
        font-weight: 300;
        font-size: 13px;
        height: 27px;
        line-height: 27px;
        padding: 0 0 0 7px;
        background-color: #4e6a85;
        border: 1px solid #4e6a85;
        color: #ecf0f1;
        font-family: 'Roboto', sans-serif;
        font-size: 13px;
        font-weight: 300;
    }
    .groupinput select {
        display: inline-block;
        border-radius: 0 3px 3px 0;
        width: 140px;
        font-weight: 300;
        font-size: 13px;
        height: 27px;
        line-height: 27px;
        padding: 0 0 0 3px;
        background-color: #4e6a85;
        margin: 0 0 0 -4px;
        border: 1px solid #4e6a85;
        color: #ecf0f1;
        font-family: 'Roboto', sans-serif;
        font-size: 13px;
        font-weight: 300;
    }
    .confirmtrd,
    input[type="submit"].confirmtrd {
		background-color: #3597d3;
		border: 0;
		line-height: 34px;
		height: 32px;
		font-weight: 300;
		text-transform: uppercase;
		font-size: 14px;
		padding: 0 18px;
		border-radius: 50px;
		color: #fff;
		cursor: pointer;
		font-family: 'Roboto', sans-serif;
		display: inline-block;
    }
    .confirmtrd:hover,
    input[type="submit"].confirmtrd:hover {
        background-color: #1870a6;
        color: #fff;
        text-decoration:none;
    }
    .confirmtrd.green {
        background-color: #27ae60 !important;
    }
    .confirmtrd.green:hover {
        background-color: #167b41 !important;
    }
    .confirmtrd.red {
        background-color: #e64c3c !important;
    }
    .confirmtrd.red:hover {
        background-color: #bb3527 !important;
    }
    .groupinput {
        margin-bottom: 10px;
    }
    textarea.darktheme {
		background-color: #4e6a85;
		border: 1px solid #4e6a85;
		height: 152px;
		max-width: 444px;
		width: 100%;
		padding: 10px;
		border-radius: 4px;
		font-family: 'Roboto', sans-serif;
		font-size: 13px;
		font-weight: 300;
		color: #ecf0f1;
		margin-top: 0;
		margin-right: 2px;
	}
    .entr_col {
        width:33%;
        float:left;
    }
    .entr_clear {clear:both;}
    .selltrade,
    .entertrade {
        width: 720px;
        margin: auto;
    }
    .groupinput.midd label {
        width:80px;
    }
    .groupinput.midd select {
        width:157px;
    }
    .groupinput.midd input {
        width:138px;
    }
    .entr_wrapper_top {
        padding:20px 0 15px 20px;
        background-color:#0c1f33;
    }
    .entr_wrapper_mid {
        padding: 20px 0 15px 20px;
        background-color: #142b46;
        border-radius: 4px;
    }
    .entr_wrapper_bot {
        padding:25px 0 25px 25px;
        background-color:#2c3e50;
    }
    .rnd {border-radius:3px !important;}
    .selectonly select {
        width:219px;
        margin:0;
    }
    .entr_ttle_bar {
        background-color: #142b46;
        padding: 12px;
        border-radius: 4px;
    }
    .entr_ttle_bar img {
        width: 22px;
        vertical-align: middle;
        margin: 0 7px 0 0;
    }
    .entr_ttle_bar strong {
        font-size: 14px;
        text-transform: uppercase;
        display: inline-block;
        font-weight:700 !important;
        vertical-align: middle;
		color:#fff;
    }
    .entr_successmsg {
        border-radius: 3px;
        background-color: #27ae60;
        color: #fff;
        padding: 4px 7px;
        width: 100%;
        margin: 0 auto;
        margin-bottom: 10px;
    }
    span.selldot {
        display: inline-block;
        background-color: #e84c3c;
        width: 10px;
        height: 10px;
        border-radius: 10px;
        vertical-align: middle;
        margin: -1px 0 0px 5px;
    }
    span.buydot {
        display: inline-block;
        background-color: #27ae60;
        width: 10px;
        height: 10px;
        border-radius: 10px;
        vertical-align: middle;
        margin: -1px 0 0px 5px;
    }
	iframe.bidaskbox {
		max-width: 217px;
		width: 100%;
		height: 152px;
		border: 1px solid #4e6a85;
		border-radius: 5px;
		padding: 7px 5px 0 5px;
		background-color: transparent;
		background: url(<?php echo $cdnorlocal; ?>/images/arb_preloader.svg) no-repeat 50% 50%;
		background-size: 50px;
	}
    /* Popup Overrides */
    div#fancybox-content {
        border-color: #2c3e50 !important;
        background: #2c3e50 !important;
    }
    #fancybox-outer {
        background: #2c3e50 !important;
        box-shadow: none !important;
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        border-radius: 6px;
        overflow: hidden;
    }
    #fancybox-close {top: 18px;right: 18px;}
    .lockedd {position:relative;}
    .lockedd i.fa.fa-lock {
        top: 7px;
        position: absolute;
        right: 14px;
        font-size: 14px;
		color: #ecf0f1;
    }
    .tradelogtable {
        width:100%; 
        margin-bottom:15px;
    }
    .tradelogtable td {
        padding: 2px;
    }
    textarea.darktheme::-webkit-input-placeholder { /* Chrome/Opera/Safari */
        color: #ecf0f1;
    }
    textarea.darktheme::-moz-placeholder { /* Firefox 19+ */
        color: #ecf0f1;
    }
    textarea.darktheme:-ms-input-placeholder { /* IE 10+ */
        color: #ecf0f1;
    }
    textarea.darktheme:-moz-placeholder { /* Firefox 18- */
        color: #ecf0f1;
    }
    .tradelogscont {
        background-color:#34495e;
        max-width:1125px;
        width:100%;
        margin:0 auto;
    }
    .tradelogscont .innerr {
        padding:25px 0;
    }
    a.smlbtn {
        background-color: #e64c3c;
        color: #fff;
        padding: 2px 8px;
        display: inline-block;
        font-size: 12px;
        border-radius: 4px;
        font-weight: bold;
        text-decoration:none;
    }
    a.smlbtn.blue {
        background-color: #3597d3;

    }
    a.smlbtn.green {
        background-color: #27ae60;
    }
    a.smlbtn:hover {
        background-color: #bb3527;
    }
    a.smlbtn.blue:hover {
        background-color: #1870a6;
    }
    a.smlbtn.green:hover {
        background-color: #167b41;
    }
    .sysoutput {background-color: #313131;}
    .sysoutput span {
        display: inline-block;
        margin: 0 -4px 0 0px;
        color: #9a9a9a;
        background-color: #313131;
        padding: 2px 8px;
    }
    .tradelogtable strong {
        font-weight: 700 !important;
    }
    .tradingnotescont {
        width:300px;
        min-height:250px;
    }
	span.datestamp_header {
		color: #a1adb5;
		display: inline-block;
		vertical-align: middle;
		margin: 0 0 0px 10px;
	}
	.fctnlhdn {
		visibility:hidden; 
		opacity:0;
		position:absolute;
		z-index:-1;
	}
	.arb_bar_red,
	.arb_bar_green {
		margin: 1px 0 3px;
	}
	.fancybox-content {
		background: #2c3e50;
		padding: 10px;
	}
	.fancybox-slide--html .fancybox-close-small {
		right: 8px;
		top: 10px;
		color: #fff;
	}
	.arb_top_ticker {
		display:none;
	}
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
	.normpadd {padding: 5px 7px 7px 7px !important;}
	.list-inline>li+li span {transition:1s all;}
	.greybarbg {
		height: 4px;
		background-color: #34495e;
		border-radius: 5px;
	}
	.arb_logo_placehldr h2 {
		font-size: 22px;
		color: #bdc3c7;
	}
	.arb_logo_placehldr {
		padding: 45px 0 0;
		text-align: center;
	}
	.vertical-box-row>.vertical-box-cell>.vertical-box-inner-cell {
		overflow: visible;
	}
	.arb_watchlst_cont {
		padding:25px;
		text-align:center;
		color:#bdc3c7;
	}
    /*
	.marqueethis {
		width: 150%;
		height:40px;
		right: 0;
		text-align: right;
	}
    */
    /*
    .marqueethis > li {
		animation: marquee 15s linear infinite;
	}
    */
	/*
    .marqueethis > li:hover {
		animation-play-state: paused;
	}
    */
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
    
	@keyframes marquee {
		0% {
			transform: translate(0, 0);
		}
		100% {
			transform: translate(-50%, 0);
		}
	}
    
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>

<!-- TEMP SCRIPT AND CSS FOR MARQUEE, TODO: REMOVE -->
<script>
    var ticker_data_ralph = [];
	jQuery(document).ready(function() {
			
            forevertickerinit();
			function forevertickerinit() {
				jQuery('.arb_custom_ticker').animate({'width': '+=100px'}, 1500, "linear", function() {
					foreverticker();
				});
			}
			function foreverticker() {
                //console.log('working..');
				jQuery('.arb_custom_ticker').animate({'width': '+=100px'}, 1500, "linear", function() {
					forevertickerinit();
				});
			}
            

            setInterval(() => {
                let ticker_data = ticker_data_ralph.filter(data => {
                    return data.counter < 10   
                }) 
                for(i in ticker_data){
                    let ids = `li#${ticker_data[i].counter}`;
                    let element = jQuery(ids);
                    element.remove();
                }
                jQuery(".arb_custom_ticker").width(1000);
            }, 15000);

		});
		
     
    window.onload=function(){

		(function countdown(remaining) {
			if(remaining === 0)
				jQuery(".arb_top_ticker").fadeOut("slow",function(){
					location.reload(true);
				});
				document.getElementById('countdown').innerHTML = remaining;
				setTimeout(function(){ countdown(remaining - 1); }, 1000);
		})(<?php echo rand(100,180); ?>);
        
    }
</script>
<style>
	.marqueethis {
		width:0;
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
</style>
<!-- TEMP SCRIPT AND CSS FOR MARQUEE, TODO: REMOVE -->
</head>
<body>
<div class="arb_top_ticker">
    <div ng-controller="dev-ticker" class="sd_border_btm arb_custom_ticker_wrapper">
        <ul id="container" class="list-inline marqueethis arb_custom_ticker">
            <li ng-repeat="transaction in ticker" id={{::transaction.counter}} ng-class="::{'text-green': 0 < transaction.change, 'text-red': transaction.change < 0, 'text-grey': transaction.change == 0}">
                <i class="fas " ng-class="{'fa-arrow-up': transaction.change > 0, 'fa-arrow-down': transaction.change < 0, 'normpadd': transaction.change == 0}" style="font-size: 14px;"></i>
                <a href="<?php echo $url; ?>/chart/{{::transaction.symbol}}" target="_blank"><strong class="text-white" style="font-size:14px">{{::transaction.symbol}}</strong></a><br>
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
<script src="/assets/js/datafeed.js?v=2.218"></script>'
<style type="text/css">
	#tv_chart_container {
		width: 100% !important;
	}
	.tradingview-widget-container, div#tradingview_1cb87 {
		height: 100%;
	}
	div#tv_chart_container_manual {
		border: none !important;
	}
	.tradingview-widget-copyright {
		display: none;
	}
	div#tradingview_8c000 {
		height: 100%;
	}
	.nav-tabs {background: transparent;}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
		font-family: "Roboto", Arial !important;
		font-weight: normal !important;
		padding: 0px 7px 0 3px !important;
		border: none !important;
	}
	.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
		color: #fff !important;
		background-color: #2c3e50 !important;
		border-top: 4px solid #34495e !important;
		border-radius: 0;
		padding-top:2px !important;
	}
	a.arb-btm-icon {
		float: left;
		text-align: center;
		width: 20%;
		font-size: 20px;
		color: #667f98;
		padding: 6px 0 0;
	}
	a.arb-btm-icon span {
		text-align: center;
		font-size: 11px;
		color: #fff;
		display:block;
	}
	a.arb-side-icon {
		float: left;
		text-align: center;
		width: 25%;
		font-size: 20px;
		color: #ffffff;
		padding: 14px 0 9px;
	}
	a.arb-side-icon span {
		text-align: center;
		font-size: 11px;
		color: #fff;
		display:block;
	}
	#stock-details, .wrapper.text-center.border-bottom-1.border-default {
		text-align: left !important;
	}
	.nav-tabs .nav-item, .nav-tabs.nav-justified>li, .nav-tabs>li {
		margin-bottom: 0;
		width: 50%;
		text-align: center;
		border-radius:0 !important;
	}
	.nav>li>a:focus, .nav>li>a:hover,
	.nav-tabs li:hover {border-radius:0 !important;}
	small.arb_markcap {
		display: block;
		color: #ccc;
		font-size: 12px;
		font-weight: 300;
	}
	.arb_bottom_control_l {
		float:left;
		width:50%;
		max-width:700px;
	}
	.arb_bottom_control_r {
		float:right;
		width:270px;
	}
	.arb_right_icons_trans {display:block;}
	.arb_top_ticker {display:block;}
</style>
</body>
</html> 