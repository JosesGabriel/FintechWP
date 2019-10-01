<?php
	global $current_user;
	$user = wp_get_current_user();
	if ( is_user_logged_in() ) {
		// echo 'Welcome, registered user!';
	} else {
		wp_redirect( 'login', 301 );
		exit;
	}

	$profile_id = um_profile_id();
	$default_cover = UM()->options()->get( 'default_cover' );
	um_fetch_user($profile_id);

	$homeurlgen = '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> ng-app="arbitrage_wl">
<head>
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
	<link rel="manifest" href="/manifest.json">     
	<meta name="msapplication-TileColor" content="#142c46">
	<meta name="msapplication-TileImage" content="/assets/icons/launcher-icon-4x.png">
	<meta name="theme-color" content="#0d1f33">
	<!-- THIS IS WHERE JQUERY IS -->
	
<?php
	//elegant_description();
	//elegant_keywords();
	//elegant_canonical();
	/**
	 * Fires in the head, before {@see wp_head()} is called. This action can be used to
	 * insert elements into the beginning of the head before any styles or scripts.
	 *
	 * @since 1.0
	 */
	// do_action( 'et_head_meta' );
?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>
	<?php wp_head(); ?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="shortcut icon" href="/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-192x192.png" />
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css" integrity="sha256-Qc3yyFhqacL9loe3ItFKo9WaSdTwZhpZRMYBvEpR2Cw=" crossorigin="anonymous" />
	<link href="/wp-content/plugins/um-friends/assets/css/um-friends.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,600i" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/parts_style.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/page_style.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/responsive.css?<?php echo time(); ?>">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<?php if (isset($_GET['arbitaction']) && $_GET['arbitaction'] == "editphoto"): ?>
	<script>
		jQuery(document).ready(function () {
			jQuery('.um-profile-photo .um-btn-auto-width').trigger('click');
			UM_hide_menus();
		})
	</script>
	<?php endif ?>
	<?php if (isset($_GET['arbitaction']) && $_GET['arbitaction'] == "editcover"): ?>
	<script>
		jQuery(document).ready(function () {
			jQuery('.um-cover .um-btn-auto-width').trigger('click');
			UM_hide_menus();
		})
	</script>
	<?php endif ?>
    <?php /* Global Header Scritps */ get_template_part('parts/global', 'scripts'); ?>
</head>
<body <?php body_class(); ?>>
<script>
	jQuery(document).ready(function(e) {
		jQuery(".um-activity-new-post .um-activity-body .um-activity-textarea").append('<img class="arb_newpostimg" src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" alt="<?php echo ucfirst(um_user('first_name')); ?>">');
	});
</script>
<?php
	$product_tour_enabled = et_builder_is_product_tour_enabled();
	$page_container_style = $product_tour_enabled ? ' style="padding-top: 0px;"' : ''; ?>
	<div id="page-container"<?php echo $page_container_style; ?>>

<div class="slidecloseoverlay" id="slidecloseoverlay"></div>
<div class="left-slide-trigger" id="left-slide-trigger"></div>
<div class="right-slidecloseoverlay" id="right-slidecloseoverlay"></div>
<div class="top-slide-trigger" id="top-slide-trigger"></div>
	

	<?php ob_start(); ?>
        <?php get_template_part('parts/global', 'header'); ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.um-activity-post').html('Post');
			});
		</script>
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
	?>
	<script data-obct type="text/javascript">
	  /** DO NOT MODIFY THIS CODE**/
	  !function(_window, _document) {
	    var OB_ADV_ID='00dd522c52b0f61db8089b1a2293a364e0';
	    if (_window.obApi) {var toArray = function(object) {return Object.prototype.toString.call(object) === '[object Array]' ? object : [object];};_window.obApi.marketerId = toArray(_window.obApi.marketerId).concat(toArray(OB_ADV_ID));return;}
	    var api = _window.obApi = function() {api.dispatch ? api.dispatch.apply(api, arguments) : api.queue.push(arguments);};api.version = '1.1';api.loaded = true;api.marketerId = OB_ADV_ID;api.queue = [];var tag = _document.createElement('script');tag.async = true;tag.src = '//amplify.outbrain.com/cp/obtp.js';tag.type = 'text/javascript';var script = _document.getElementsByTagName('script')[0];script.parentNode.insertBefore(tag, script);}(window, document);
	obApi('track', 'PAGE_VIEW');
	</script>
