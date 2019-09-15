<?php
	/* Template Name: Multichart Main Page */
    global $current_user; 
    $url = get_home_url();
	$user = wp_get_current_user();
	if ( is_user_logged_in() ) {
        // user is now logged in
	} else {
        wp_redirect( $url.'/login/', 301 );
		exit;
    }
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Arbitrage | Multicharts</title>
<link rel="shortcut icon" href="https://1948265747.rsc.cdn77.org/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-192x192.png" />
<style>
html, body {
	height:100%;
	margin:0;
	padding:0;
	background-color:#354960;
}
iframe {
	border:none;
	display:block;
}
.chart_logo_arbitrage{
		position: absolute;
		z-index: 9;
		top: 4px;
		left: 9px;
	}
	.arb_right_icons_trans {
			position: absolute;
		    width: 275px;
		    right: -54px;
		    top: 2px;
			padding-left: 110px;
		    background: linear-gradient(to right, #2c3e5000 26%, #34495e 43%);
		    z-index: 9;
		}
		.arb_right_icons_trans {display:block;}
		ul.main-drops-chart > ul:before {
	    bottom: 100% !important;
	    right: 2% !important;
	    border: solid transparent !important;
	    content: " " !important;
	    height: 0 !important;
	    width: 0 !important;
	    position: absolute !important;
	    pointer-events: none !important;
	    margin-left: -36px !important;
		border-bottom-color: #142c46 !important;
	    border-width: 9px !important;
	}
	ul.main-drops-chart > ul {
		font-size: 13px !important;
	    position: absolute !important;
		right: 139px !important;
	    top: 37px !important;
	    background: #142c46 !important;
	    min-width: 180px !important;
	    text-align: left !important;
	    border: none !important;
	    border-radius: 4px !important;
	    list-style: none !important;
	    padding: 0 !important;
	}
	ul.main-drops-chart {
	    display: inline-block !important;
	    width: 12% !important;
	    padding-left: 0 !important;
	}
	ul.main-drops-chart > ul li a {
	    color: #fff !important;
	    display: block !important;
	    font-size: 12px !important;
	    text-decoration: none !important;
	    font-weight: 500 !important;
	    font-family: 'roboto', sans-serif !important;
	}
	ul.main-drops-chart > ul:before {
	    border-bottom-color: #142c46 !important;
	    right: 4% !important;
	    border-width: 9px !important;
	}
	ul.main-drops-chart > ul li:hover {
	    background: #0d1f33;
	}
	ul.main-drops-chart > ul li {
	    padding: 6px 15px;
	}
	ul.main-drops-chart > ul li:first-child {
	    border-top-left-radius: 4px !important;
	    border-top-right-radius: 4px !important;
	}
	ul.main-drops-chart > ul li:last-child {
	    border-bottom-left-radius: 4px !important;
	    border-bottom-right-radius: 4px !important;
	}
	a.arb-side-icon {
		text-align: center;
		width: 13%;
		font-size: 20px;
		color: #ffffff;
		padding: 4px 0 0;
		display: inline-block;
	}
	a.arb-side-icon span {
		text-align: center;
		font-size: 11px;
		color: #fff;
		display:block;
	}
</style>
</head>

<body>
<div>
		<div class="chart_logo_arbitrage"><a href="<?php echo $url; ?>" target="_blank"><img src="https://arbitrage.ph/wp-content/themes/arbitrage-child/images/arblogo_svg1.svg" style="width: 33px;"></a></div>

		<iframe style="border:0;width:100%;height: 40px;border-bottom: 4px #34495e solid;overflow: hidden;" scrolling="no" src="<?php echo $homeurlgen; ?>/stock-ticker/"></iframe>

		<?php //get_template_part('parts/global', 'css'); ?>

	   
	</div>
<div style="height:50%;">
    <iframe src="<?php echo $url; ?>/multicharts/chart-part-1/" scrolling="no" frameborder="0" allowtransparency="yes" style="width:50%; height:100%; float:left;"></iframe>
    <iframe src="<?php echo $url; ?>/multicharts/chart-part-2/" scrolling="no" frameborder="0" allowtransparency="yes" style="width:50%; height:100%; float:right;"></iframe>
</div>
<div style="clear:both"></div>
<div style="height:50%;">
    <iframe src="<?php echo $url; ?>/multicharts/chart-part-3/" scrolling="no" frameborder="0" allowtransparency="yes" style="width:50%; height:100%; float:left;"></iframe>
    <iframe src="<?php echo $url; ?>/multicharts/chart-part-4/" scrolling="no" frameborder="0" allowtransparency="yes" style="width:50%; height:100%; float:right;"></iframe>
</div>
</body>
</html>
