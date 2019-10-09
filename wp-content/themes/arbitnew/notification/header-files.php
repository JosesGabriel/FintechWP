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
