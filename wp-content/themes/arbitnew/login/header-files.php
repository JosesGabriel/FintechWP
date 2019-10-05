<?php
global $current_user;
$user = wp_get_current_user();

	/**
	 * Fires in the head, before {@see wp_head()} is called. This action can be used to
	 * insert elements into the beginning of the head before any styles or scripts.
	 *
	 * @since 1.0
	 */
	do_action( 'et_head_meta' );

	$template_directory_uri = get_template_directory_uri();
	$homeurlgen = get_home_url();
?>
<!DOCTYPE html><!-- Bidvertiser2000920 -->
<html <?php language_attributes(); ?>><head>
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
	
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta property="og:title" content="Arbitrage | Free Stock Trading Platform" />
	<!-- <meta property="og:image" content="<?php echo $homeurlgen ?>/wp-content/uploads/2019/09/2f2a3a12-3a4bc05c-arbitrage-og-02.jpg" /> -->
	<meta property="og:image" content="<?php echo $homeurlgen ?>/wp-content/themes/arbitrage-child/images/ogimage_mage.png" />
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700" rel="stylesheet">
	
	<?php // Countdown ?>
	<link rel="stylesheet" type="text/css" href="<?php echo get_home_url(); ?>/wp-content/themes/arbitrage-child/cd/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_home_url(); ?>/wp-content/themes/arbitrage-child/cd/css/demo.css">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>

	<?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/login/login_style.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/responsive.css?<?php echo time(); ?>">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<style>
	<?php if (isset($_GET['b'])){ 
		$getrand = $_GET['b'];
		$get_bgfimage = "loginbg".$getrand.".jpg";?>
		html {background: url("<?php echo $homeurlgen; ?>/images/<?php echo $get_bgfimage; ?>") 50% 0 no-repeat #2c3e50 fixed;background-size: cover;}
	<?php } ?>
    #status {
		width: 50px;
		height: 50px;
		position: absolute;
		left: 50%;
		top: 35%;
		background-image: url(<?php echo $homeurlgen; ?>/images/arb_preloader.svg);
		background-size:50px;
		background-repeat: no-repeat;
		background-position: center;
		margin: -25px 0 0 -25px;
	}
    </style>
	<link href="<?php echo $homeurlgen; ?>/assets/css/preloader.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> 
    <script language="javascript">
	
		jQuery(window).on('load', function(){
			jQuery("#status, #status_txt").fadeOut();
			jQuery("#preloader").delay(400).fadeOut("slow");
			jQuery(".um-field-checkbox-option").html("");
			jQuery(".forgotpass-wrapper .um-button").val("Reset password");
			// jQuery(".um-field-error").html("!");
		});
		jQuery(document).ready(function(){
			jQuery("#emailNotify__form").submit(function(){
				var hasemail = jQuery("#email--input").val().length;
				var email = jQuery("#email--input").val();
				if( hasemail >= 1 ) {
					jQuery.ajax({
						method: "POST",
						url: "/apipge/?daction=notify_me_email",
						// url: 'https://api2.pse.tools/api/quotes',
						data: {
							'email' : email
						},
						success: function(data) {
							jQuery("#email__text").show();
						},
						error: function(requestObject, error, errorThrown) {

						}
					});
				}
			});
		});
		
	</script>
    <?php /* Global Header Scritps */ //get_template_part('parts/global', 'scripts'); ?>
</head>
<body <?php body_class(); ?>>
	  <?php /* Responsive 2 */ //get_template_part('parts/global', 'responsivetwo'); ?>

<div class="form-success-email">
	<div class="success--content">
		<!-- <i class="far fa-check-circle"></i> -->
		<span class="success-word"> Thank you for signing up, talk to you soon!</span>
	</div>
</div>



<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script> 
<script type="text/javascript" src="<?php echo get_home_url(); ?>/wp-content/themes/arbitrage-child/cd/js/kinetic.js"></script>
<script type="text/javascript" src="<?php echo get_home_url(); ?>/wp-content/themes/arbitrage-child/jquery.final-countdown.js"></script> -->
<script type="text/javascript">  
    $('document').ready(function() {
 /*       'use strict';
        const timestamp = parseInt(Date.now()/1000);
    	$('.countdown').final_countdown({
            'start': 1565338684,
            'end': 1568595600,
            'now': timestamp     
        }); */
    });
</script>
<?php /* Global CSS Overrides  get_template_part('parts/global', 'css'); */ ?>
<div id="preloader">
    <div id="status">&nbsp;</div>
    <div id="status_txt"></div>
</div>    
	<?php
		$main_header = ob_get_clean();

		/**
		 * Filters the HTML output for the main header.
		 *
		 * @since ??
		 *
		 * @param string $main_header
		 */
		echo apply_filters( 'et_html_main_header', $main_header );
	?>
		<div id="et-main-area">
	<?php
		/**
		 * Fires after the header, before the main content is output.
		 *
		 * @since ??
		 */
		do_action( 'et_before_main_content' );
