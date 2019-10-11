<?php
	if ( is_user_logged_in() ) {
		// echo 'Welcome, registered user!';
	} else {
		wp_redirect( '/login', 301 );
		exit;
	}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title><?php bloginfo('name'); ?></title>
	<meta charset="UTF-8" />
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/apple-touch-icon-152x152.png" />
	<link rel="icon" type="image/png" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="<?php echo get_home_url(); ?>/wp-content/themes/favicon/favicon-128.png" sizes="128x128" />
	<meta name="application-name" content="Arbitrage"/>
	<meta name="msapplication-TileColor" content="#0D1F33" />
	<meta name="msapplication-TileImage" content="<?php echo get_home_url(); ?>/wp-content/themes/favicon/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="<?php echo get_home_url(); ?>/wp-content/themes/favicon/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="<?php echo get_home_url(); ?>/wp-content/themes/favicon/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="<?php echo get_home_url(); ?>/wp-content/themes/favicon/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="<?php echo get_home_url(); ?>/wp-content/themes/favicon/mstile-310x310.png" />
	<meta name="mobile-web-app-capable" content="yes">
    <meta property="og:title" content="Arbitrage | Stock Trading Platform" />
    <meta property="og:description" content="Arbitrage is a free stock trading platform in the Philippines. Effectively trade the Philippine Equity Market with our realtime market data & multiple stock trading tools.">
	<!-- <meta property="og:image" content="<?php echo $homeurlgen ?>/wp-content/uploads/2019/09/2f2a3a12-3a4bc05c-arbitrage-og-02.jpg" /> -->
    <meta property="og:image" content="<?php echo $homeurlgen ?>/wp-content/themes/arbitnew/images/ogimage_mage.png" />
     
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

    <?php if (WP_PROD_ENV): ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-147416476-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-147416476-1');
	</script>

	<!-- Global site tag (gtag.js) - Google Ads: 753053364 -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-753053364"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'AW-753053364');
	</script>

	<!-- Event snippet for Traffic to Site conversion page -->
	<script>
	gtag('event', 'conversion', {'send_to': 'AW-753053364/BJxpCLndqK4BELTdiucC'});
	</script>
	<?php endif ?>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="/wp-content/plugins/um-friends/assets/css/um-friends.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/notification/notification-style.css">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/parts_style.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/page_style.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/responsive.css?<?php echo time(); ?>">
    <?php wp_head(); ?>

</head>
<body>
<?php
    $user = wp_get_current_user();
    $cdnorlocal = get_home_url();
?>
