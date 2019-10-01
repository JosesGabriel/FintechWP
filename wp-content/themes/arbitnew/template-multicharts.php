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
            google_ad_client: "ca-pub-7982031973729040",
            enable_page_level_ads: true
        });
    </script>
	<?php endif ?>

<title>Arbitrage | Multicharts</title>
<link rel="shortcut icon" href="/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-192x192.png" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta name="robots" content="noindex">
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
		right: 195px !important;
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
		width: auto;
		font-size: 20px;
		color: #ffffff;
		display: inline-block;
		padding: 2px 2px;
	}
	a.arb-side-icon span {
		text-align: center;
		font-size: 11px;
		color: #fff;
		display:block;
	}
    
    /* modified */
    .chart_logo_arbitrage{
		position: absolute;
		z-index: 9;
		top: 8px;
		left: 9px;
	}
        .closesidebar {
	    position: relative;
		z-index:9999;
	}
	.closesidebar a {
		width: 10px;
		height: 28px;
		display: block;
		line-height: 27px;
		left: 3px;
		bottom: -77px;
		position: absolute;
		background-color: #131722;
		text-align: center;
		border-radius: 10px;
		border: 1px solid #363c4e;
	}
	.opensidebar a:hover,
	.closesidebar a:hover {
		background-color:#299dcd;
		border-bottom-color:#3bb3e4;
	}
    .closesidebar a img {
        height: 7px;
    }
    .opensidebar {
	    position: relative;
	    display:none;
		z-index:9999;
	}
	.opensidebar a {
		width: 9px;
		height: 28px;
		display: block;
		line-height: 27px;
		left: -9px;
		top: 143px;
		position: absolute;
		background-color: #131722;
		text-align: center;
		border-radius: 10px;
		border: 1px solid #363c4e;
	}
    .opensidebar a img {
        height: 7px;
    }
    .showsidebar {
        width: 260px !important;
        border-right: 5px solid #34495e !important;
        /*transition: all 0.5s ease !important;*/
    }
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
		right: 195px !important;
	    top: 56px !important;
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
    .arb_right_icons_trans {
		position: absolute;
		width: 156px;
		right: 0px;
		top: -12px;
		padding-right: 13px;
		padding-left: 0;
		background: linear-gradient(to right, #2c3e5000 4%, #34495e 43%);
		z-index: 9;
		height: 55px;
		text-align: right;
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
        .arb_proficon{
            width: 24px;
			height: 24px;
			border-radius: 100%;
			display: inline-block;
			top: 8px;
			position: relative;
        }
</style>
</head>

<body>
    <div>
        <div class="chart_logo_arbitrage"><a href="<?php echo $url; ?>" target="_blank"><img src="/wp-content/themes/arbitrage-child/images/arblogo_svg1.svg" style="width: 33px;"></a></div>
        <iframe style="border:0;width:100%;height: 40px;border-bottom: 4px #34495e solid;overflow: hidden;" scrolling="no" src="<?php echo $url; ?>/stock-ticker/"></iframe>

		<?php //get_template_part('parts/global', 'css'); ?>

        <div class="arb_right_icons_trans">
			<?php /*?> Top Icons <?php */?>
			<ul class="main-drops-chart">
				<a href="#" class="arb-side-icon">
					<img src="<?php echo $url; ?>/svg/menu.svg" style="width: 17px;display: inline-block;vertical-align: top;margin-top: 6px;">
				</a>
				<ul id="droppouts" style="box-shadow: 0px 2px 4px 1px rgba(7, 13, 19, 0.52);display: none;">
						<li><a href="#">Buy/Sell Calculator</a></li>
						<li><a href="#">VAR Calculator</a></li>
						<li><a href="#">Average Price Calculator</a></li>
						<li><a href="<?php echo get_home_url(); ?>/multicharts/">Multichart</a></li>
				</ul>
			</ul>
			<a href="<?php echo $url; ?>/notifications/" class="arb-side-icon"><img src="<?php echo $url; ?>/svg/bell.svg" style="width: 19px;display: inline-block;vertical-align: top;margin-top: 5px;"></a>
			<a href="<?php echo $url; ?>/vyndue/" class="arb-side-icon"><img src="<?php echo $url; ?>/svg/vyndue-newlogo-white.svg" style="width: 19px;display: inline-block;vertical-align: top;margin-top: 4px;"></a>
			<a href="<?php echo $url; ?>/account/" class="arb-side-icon"><?php
				if ( $user ) : ?>
					<img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" class="arb_proficon" />
				<?php else: ?>
					<i class="fas fa-user-tie"></i>
				<?php endif; ?></a>
			<div style="clear:both"></div>
		</div>
	   
	</div>
<div style="height:46%;">
    <iframe src="<?php echo $url; ?>/multicharts/chart-part-1/" scrolling="no" frameborder="0" allowtransparency="yes" style="width:50%; height:100%; float:left;"></iframe>
    <iframe src="<?php echo $url; ?>/multicharts/chart-part-2/" scrolling="no" frameborder="0" allowtransparency="yes" style="width:50%; height:100%; float:right;"></iframe>
</div>
<div style="clear:both"></div>
<div style="height:47%;">
    <iframe src="<?php echo $url; ?>/multicharts/chart-part-3/" scrolling="no" frameborder="0" allowtransparency="yes" style="width:50%; height:100%; float:left;"></iframe>
    <iframe src="<?php echo $url; ?>/multicharts/chart-part-4/" scrolling="no" frameborder="0" allowtransparency="yes" style="width:50%; height:100%; float:right;"></iframe>
</div>
</body>
</html>
<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
    	jQuery(document).ready(function(){
			jQuery("ul.main-drops-chart").click(function(e){
                event.stopPropagation();
                var isopen = jQuery("ul.main-drops-chart > ul").hasClass("dropopen");

                if (isopen) {
                    jQuery("ul.main-drops-chart > ul").hide().removeClass("dropopen");
                } else {
                    jQuery("ul.main-drops-chart > ul").show().addClass("dropopen");
                }

            });
			jQuery(document).on("click", function () {
	            jQuery("ul.main-drops-chart > ul").hide().removeClass("dropopen");
	            jQuery("ul.main-drops > ul").hide().removeClass("dropopen");
	            jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hide().removeClass("dropopen");
	        });
		});
		jQuery(document).ready(function(){
            jQuery("ul.main-drops-chart > ul li:first-child").on("click", function () {
                event.stopPropagation();
                 var openthis = jQuery("#showplease").hasClass("dropthiss");
                 if ( openthis ) {
                     jQuery("#toghandle").hide().removeClass("dropthiss");
                } else {
                	jQuery("#toghandle").show().addClass("dropthiss");
                }
            });
            jQuery("ul.main-drops-chart > ul li:nth-child(2)").on("click", function () {
                event.stopPropagation();
                jQuery("#toghandlings").show().addClass("dropthiss");

            });
            jQuery("ul.main-drops-chart > ul li:nth-child(3)").on("click", function () {
                event.stopPropagation();
                jQuery("#toghandlingers").show().addClass("dropthiss");
            });
        });
        jQuery(document).ready(function(){
            // jQuery("#toghandle").on('click', function(){
            //     jQuery("#toghandle").hide().removeClass("dropthiss");
            // });
            // jQuery("#toghandlings").on('click', function(){
            //     jQuery("#toghandlings").hide().removeClass("dropthiss");
            // });

            jQuery(".toclassclose").on('click', function(){
                jQuery("#toghandle").hide().removeClass("dropthiss");
            });
            jQuery(".toclassclosess").on('click', function(){
                jQuery("#toghandlings").hide().removeClass("dropthiss");
            });
            jQuery(".toclasscloserss").on('click', function(){
                jQuery("#toghandlingers").hide().removeClass("dropthiss");
            });
        });
	</script>
