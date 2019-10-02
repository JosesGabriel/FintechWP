<?php
	/*
	* Template Name: Multichart Part 2
	*/
	global $current_user; 
	$user = wp_get_current_user();
	if ( is_user_logged_in() ) {
		// user is now logged in
	} else {
		wp_redirect( '/login/', 301 );
		exit;
	}
	$user_id = $user->ID;
	$checksharing = get_user_meta( $user_id, "check_user_share", true ); 
	if (!$checksharing){
		header('Location: /share/?'.rand(12345 ,89019));
		die();
	}
	$cdnorlocal = get_home_url();

?><!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="arbitrage">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Arbitrage Trading Tools | Chart</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta name="robots" content="noindex">
    <link rel="icon" href="<?php echo $cdnorlocal; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-32x32.png" sizes="32x32" />
    <link rel="icon" href="<?php echo $cdnorlocal; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="<?php echo $cdnorlocal; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-180x180.png" />
    <meta name="msapplication-TileImage" content="<?php echo $cdnorlocal; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-270x270.png" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" />
	<link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" />
	<link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/plugins/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/css/animate.min.css" />
	<link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/css/style.min.css" />
	<link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/css/theme/default.css" id="theme" />
    <link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/plugins/gritter/css/jquery.gritter.css" />
	<link rel="stylesheet" href="<?php echo $cdnorlocal; ?>/assets/plugins/ng-embed/dist/ng-embed.min.css" />
    <link href="<?php echo $cdnorlocal; ?>/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?php echo $cdnorlocal; ?>/assets/css/style-chart.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
    <style type="text/css">
		html, body, .page-content-full-height .content {overflow:hidden;}
		.arb_buysell {
			position: absolute;
			top: 6px;
			left: -329px;
			z-index: 999999;
		}
		.arb_buy {
			display: inline-block;
			height: 26px;
			line-height: 28px;
			text-align: center;
			color: #fff;
			background-color: #25ae5f;
			padding: 0 10px 0 10px;
			text-transform: uppercase;
			font-size: 13px;
			border-radius: 50px;
			font-weight: 300;
			vertical-align: top;
		}
		.arb_buy:hover {background-color: #229a55;}
		.arb_sell {
			display: inline-block;
			height: 26px;
			line-height: 28px;
			text-align: center;
			color: #fff;
			background-color: #e64c3c;
			padding: 0 10px 0 10px;
			text-transform: uppercase;
			font-size: 13px;
			border-radius: 50px;
			font-weight: 300;
			vertical-align: top;
		}
		.arb_sell:hover {background-color: #d04234;}
		.arb_buysell i.fas {
			color: #fff;
			font-size: 13px;
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
			width: 170px;
			right: -30px;
			top: -1px;
			background-color: transparent;
			z-index: 9;
		}
		.arb-side-icon i {
			border: none;
			border-radius: 100%;
			width: 30px;
			height: 30px;
			line-height: 30px;
			font-size: 16px;
			background-color: rgba(44, 62, 80,0.8);
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
			right: 57px;
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
			text-align:right;
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
		.sd_border_btm {
			border-bottom: 4px #34495e solid;
		}
		.sd_border_top {
			border-top: 4px #34495e solid;
		}
		.allstocksbox {
			height: 56%;
			overflow: hidden;
			display: block;
			padding: 5px 0 5px 0;
		}
		.list-inline>li{display:inline-block;}
		.list-inline>li+li{margin-bottom:5px !important;}

		.arb_watchlst_cont table thead tr th {
			color: #fffffe;
		text-align: center;
		}
		.arb_watchlst_cont table tbody tr td {
			color: #fffffe;
			text-align: center;
	    	padding: 3px 4px;
		}
		.arb_watchlst_cont table tbody {
			border-top: 6px solid #ffffff00;
		}
		.chred {
			color: #fffffe;
			padding: 5px 0px;
		    background: #e64c3c;
		    border-radius: 50px;
		}
		.chgreen {
			color: #fffffe;
			padding: 5px 0px;
		    background: #53b987;
		    border-radius: 50px;
		}
		.block {
			font-weight: 600;
		}
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
        background-color:#2c3e50;
    }
    .entr_wrapper_mid {
        padding: 20px 0 15px 20px;
        background-color: #34495e;
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
        background-color: #34495e;
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
		background: url(<?php echo $cdnorlocal; ?>/images/arb_preloader.svg) no-repeat 50% 50% transparent;
		background-size: 50px;
	}
	iframe.bullbearframe {
		background: url(<?php echo $cdnorlocal; ?>/images/arb_preloader.svg) no-repeat 50% 50% #2b3d4f;
		background-size: 35px;
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
		padding:5px;
		text-align:center;
		color:#bdc3c7;
	}
	.arb_watchlst_cont > table {
	    width: 100%;
	}
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
	.bullbearsents_voted,
	.bullbearsents {
		text-align:center;
		padding:0 0 4px 0;
	}
	.bullbearsents a {
		display:inline-block;
		vertical-align:middle;
	}
	.bullbearsents .bbs_bear,
	.bullbearsents .bbs_bull {
		margin:-3px 2px 0px;
	}
	.bullbearsents .bbs_bear img {
		width:15px;
	}
	.bullbearsents .bbs_bull img {
		width:18px;
	}
	.bullbearsents .bbs_bull {
		background-color: #25ae5f;
		padding: 6px;
		border-radius: 20px;
	}
	.bullbearsents .bbs_bull:hover {
		background-color: #229a55;	
	}
	.bullbearsents .bbs_bear {
		background-color: #e64c3c;
		padding: 6px;
		border-radius: 20px;
	}
	.bullbearsents .bbs_bear:hover {
		background-color: #d13c2c;
	}
	.bullbearsents span {
		display: block;
		color: #FFF;
	}
	span.bullbearsents_label {
		margin-bottom: -5px;
	}
	.bbs_bear_bar {margin-left:-2px; text-align:right;}
	.bbs_bull_bar {margin-right:-2px; text-align:left;}
	.bbs_bear_bar_inner {background-color: #e64c3c; height:4px; border-radius: 0 5px 5px 0;}
	.bbs_bull_bar_inner {background-color: #25ae5f; height:4px; border-radius: 5px 0 0 5px;}
	.bbs_bear_bar, 
	.bbs_bull_bar {
		width:0;
		vertical-align:middle;
		display:inline-block;
	}
	.bbs_bear_bar span,
	.bbs_bull_bar span {display:none;}
	.dbaronchart {
		display: inline-block;
		width: 0%;

	}
	.bbs_bull_bar, .bbs_bear_bar {
		margin-top: 11px;
	}
	#preloader {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #354960;
		z-index: 99999999;
		height: 100%;
	}
	#status {
		width: 50px;
		height: 50px;
		position: absolute;
		left: 50%;
		top: 45%;
		background-image: url(<?php echo get_home_url(); ?>/wp-content/plugins/um-social-activity/assets/img/loader.svg);
		background-size:50px;
		background-repeat: no-repeat;
		background-position: center;
		margin: -25px 0 0 -25px;
	}
	#status_txt {
		width:100%;
		position: absolute;
		top:50%;
		left:0;
		z-index:99;
		color:#fff;
		text-align:center;
		font-size:11px;
	}
	.chart_logo_arbitrage{
		position: absolute;
		z-index: 9;
		top: 5px;
		left: 10px;
	}
	#tv_chart_container iframe {background-color: #34495e !important;}
	.vertical-box-column.width-250 {
		border-right: 5px solid #34495e;
	}
	.width-250 {
		width: 260px!important;
	}
	.showsidemobile {
		position: absolute;
		z-index: 999;
		color: #fff;
		background-color: #2c3e50;
		font-size: 25px;
		padding: 1px 7px 2px;
		left: -41px;
		top: 0px;
	}
	.mobileinithide .fa-indent {display:none;}
	.chartlocker {
		display:none;
		position:absolute;
		z-index: 998;
		width:100%;
		left: 0;
		height:100%;
		background-color: rgba(44, 62, 80,0.8);
	}
	.fixbrdebtm {
		height: 5px;
		position: absolute;
		bottom: 0;
		right: 0;
		z-index: 9999;
		width: 100%;
		background-color: #34495e;
	}
	tr.ng-scope:focus,
	tr.ng-scope:active {
		background-color: #eb4d5c!important;
	}
	/* Responsive */
	@media screen and (max-width: 767px){
		.table-responsive {
			border: none;
		}
	}
	@media only screen and (max-width: 667px) { 
		.width-250.mobileinithide {
			width: 265px !important;
			position: absolute;
			z-index: 999;
			right: -260px;
			border-left: 5px solid #34495e;
		}
		.arb_buysell {
			top: 49px;
			left: -78px;
			width: 72px;
			text-align: right;
			background-color: #2c3e50;
		}
		.arb_buy, .arb_sell {width: 66px; margin-bottom:5px;border-radius: 50px 0 0 50px;}
		.vertical-box-column.mobilefull {
			width: 100%;
		}
		.groupinput.midd input {width: 59%;}
		.groupinput.midd label {width: 40%;}
		.groupinput {width: 95%;}
		iframe.bidaskbox {max-width: 100%;}
		.entr_col {width: 100%;}
	}
    </style>
	<script language="javascript">
		jQuery(document).ready(function() {
			
			jQuery(window).load(function() {
				jQuery("#status, #status_txt").fadeOut("fast");
				jQuery("#preloader").delay(400).fadeOut("slow");
			})
			
			function changicotonormal() {
				var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
				link.type = 'image/x-icon';
				link.rel = 'shortcut icon';
				link.href = '<?php echo $cdnorlocal; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-32x32.png';
				document.getElementsByTagName('head')[0].appendChild(link);
			}
			jQuery( "body" ).mousemove(function() {
			  changicotonormal();
			});
			jQuery( ".bidaskbar_btn" ).click(function() {
			  jQuery( ".bidaskbar_opt" ).slideToggle("fast");
			});
            jQuery(".bidaskbar_opt ul li a").click(function(e){
                e.preventDefault();
                var dtype = jQuery(this).attr('data-istype');
                jQuery(this).parents(".bidaskbar").find(".arb_bar").hide();
                jQuery(this).parents(".bidaskbar").find("."+dtype).show();
                jQuery(this).parents(".bidaskbar_opt").hide();
            });
			forevertickerinit();
			function forevertickerinit() {
				jQuery('.marqueethis').animate({'width': '+=100px'}, 2000, "linear", function() {
					foreverticker();
				});
			}
			function foreverticker() {
				jQuery('.marqueethis').animate({'width': '+=100px'}, 2000, "linear", function() {
					forevertickerinit();
				});
			}
			
		});
    </script>
    <script>

	</script>
</head>
<body>
<div id="preloader">
    <div id="status">&nbsp;</div>
    <div id="status_txt"></div>
</div>

<div id="page-container" class="fade page-content-full-height page-without-sidebar" ng-controller="template">
    <div id="content" class="content content-full-width" style="padding: 0; top:0 !important">
    
      <div style="height:100%" data-height="100%" ng-controller="chart">
          <div class="vertical-box-inner-cell" ng-controller="tradingview" style="height: 100%;">
              <div id="tv_chart_container"></div>
          </div>
      </div>

	</div>
</div>
<!-- begin theme-panel -->

<!-- end theme-panel -->		<!-- end #content -->
				
		
	</div>
    

	<!-- end page container -->
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo $cdnorlocal; ?>/assets/crossbrowserjs/html5shiv.js"></script>
		<script src="<?php echo $cdnorlocal; ?>/assets/crossbrowserjs/respond.min.js"></script>
		<script src="<?php echo $cdnorlocal; ?>/assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/js/apps.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.9/angular.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-numeraljs/2.0.1/angular-numeraljs.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-moment/1.2.0/angular-moment.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/angular-timeago@0.4.6/dist/angular-timeago.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.6.6/angular-sanitize.min.js"></script>
	<script src="//cdn.rawgit.com/Luegg/angularjs-scroll-glue/master/src/scrollglue.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/ng-embed/dist/ng-embed.min.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/js/jquery.fullscreen-min.js"></script>
	<script src="<?php echo $cdnorlocal; ?>/assets/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="<?php echo $cdnorlocal; ?>/assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo $cdnorlocal; ?>/assets/js/aes.js"></script>
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
		var _stocks 	= {};
		var _admin 		= false;
		var _moderator 	= false;
		var _client_id 	= 'arbitrage.ph';
		var _user_id 	= '<?php echo $user->ID; ?>'
		var _username 	= '<?php echo $user->user_email; ?>';
		var _symbol 	= 'BDO';
	</script>
<script src="<?php echo $cdnorlocal; ?>/assets/js/angular/functions.js?v=1.218"></script>
<script src="<?php echo $cdnorlocal; ?>/assets/js/angular/controllers.js?v=1.218"></script>
<script src="<?php echo $cdnorlocal; ?>/assets/js/angular/directives.js?v=1.218"></script>
<script src="<?php echo $cdnorlocal; ?>/assets/js/angular/filters.js?v=1.218"></script>
<script src="<?php echo $cdnorlocal; ?>/assets/tradingview/charting_library/charting_library.min.js?v=1.218"></script>
<script src="<?php echo $cdnorlocal; ?>/assets/js/datafeed.js?v=2.218"></script>
<!-- <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/arphie-script.js"></script> -->
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
	.nav-tabs {
		background: #34495e;
		padding-top: 4px;
	}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
		font-family: "Roboto", Arial !important;
		font-weight: normal !important;
		padding: 0px 7px 0 3px !important;
		border: none !important;
	}
	.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
		color: #fff !important;
		background-color: #2c3e50 !important;
		border-radius: 0;
		padding-top:5px !important;
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
		width: 20%;
		font-size: 20px;
		color: #ffffff;
		padding: 4px 0 0;
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
		border-radius: 6px 6px 0 0 !important;
		overflow: hidden;
	}
	.nav>li>a:focus, .nav>li>a:hover,
	.nav-tabs li:hover {border-radius:4px 4px 0 0 !important;}
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