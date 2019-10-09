<!DOCTYPE html>
<html <?php language_attributes(); ?> ng-app="arbitrage_wl">
<head>
    <title><?php bloginfo('name'); ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="/wp-content/plugins/um-friends/assets/css/um-friends.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/dashboard/dashboard-style.css">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/parts_style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/page_style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/responsive.css?<?php echo time(); ?>">
    <link href="/wp-content/themes/arbitnew/watchlist/watchlist-style.css?<?php echo time(); ?>" rel="stylesheet">
    
    <?php wp_head(); ?>
    
</head>

<body>

<?php
    $user = wp_get_current_user();
    $cdnorlocal = get_home_url();
?>
