
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" />
	<link rel="stylesheet" href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" />
	<link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/assets/css/animate.min.css" />
	<link rel="stylesheet" href="/assets/css/style.min.css" />
	<link rel="stylesheet" href="/assets/css/theme/default.css" id="theme" />
    <link rel="stylesheet" href="/assets/plugins/gritter/css/jquery.gritter.css" />
	<link rel="stylesheet" href="/assets/plugins/ng-embed/dist/ng-embed.min.css" />

    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/parts_style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/page_style.css?<?php echo time(); ?>"> 
	<!-- Madaot calcs sa chart if dili ni iload ang duha ka css. To be refractored -->
	
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta property="og:title" content="Arbitrage | Stock Trading Platform" />
    <meta property="og:description" content="Arbitrage is a free stock trading platform in the Philippines. Effectively trade the Philippine Equity Market with our realtime market data & multiple stock trading tools.">
	<!-- <meta property="og:image" content="<?php echo $homeurlgen ?>/wp-content/uploads/2019/09/2f2a3a12-3a4bc05c-arbitrage-og-02.jpg" /> -->
	<meta property="og:image" content="<?php echo $homeurlgen ?>/wp-content/themes/arbitnew/images/ogimage_mage.png" />

    <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/css/style-chart.css" rel="stylesheet" />

    <!-- <script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
	$( function() {
		jQuery( "#draggable_buysell" ).draggable();
		alert('here');
	} );
	</script>
    <!-- <script src="/wp-content/themes/arbitnew/interactivechart/jquery.webticker.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/jquery.marquee@1.5.0/jquery.marquee.min.js" type="text/javascript"></script> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/interactivechart/interactive-style.css?<?php echo time(); ?>">
    
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
		.list-inline>li{display:inline-block;}
		.list-inline>li+li{margin-bottom:5px !important;}
		.marqueethis {
			width: 100%;
			height:40px;
			right:-45px;
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
        div.tickercontainer{
            margin-top: -4px;
        }
	</style>