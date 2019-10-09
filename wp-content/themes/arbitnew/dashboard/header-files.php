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
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-147416476-1"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-147416476-1');
		</script>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta property="og:title" content="Arbitrage | Free Stock Trading Platform">
	<!-- <meta property="og:description" content="Offering tour packages for individuals or groups."> -->
	<meta property="og:image" content="<?php echo $homeurlgen ?>/wp-content/themes/arbitnew/images/ogimage_mage.png">
	<meta property="og:url" content="https://arbitrage.ph">

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="/wp-content/plugins/um-friends/assets/css/um-friends.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/dashboard/dashboard-style.css">
    <!-- <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/parts_style.css?<?php echo time(); ?>"> -->
	<!-- <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/page_style.css?<?php echo time(); ?>"> -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/responsive.css?<?php echo time(); ?>">
    <?php wp_head(); ?>

</head>
<body>
<?php
    $user = wp_get_current_user();
    $cdnorlocal = get_home_url();
?>
