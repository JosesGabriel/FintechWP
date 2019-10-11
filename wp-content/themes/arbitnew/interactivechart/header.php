<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="arbitrage">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="https://arbitrage.ph/favicon/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://arbitrage.ph/favicon/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://arbitrage.ph/favicon/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://arbitrage.ph/favicon/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="https://arbitrage.ph/favicon/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="https://arbitrage.ph/favicon/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="https://arbitrage.ph/favicon/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="https://arbitrage.ph/favicon/apple-touch-icon-152x152.png" />
	<link rel="icon" type="image/png" href="https://arbitrage.ph/favicon/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="https://arbitrage.ph/favicon/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="https://arbitrage.ph/favicon/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="https://arbitrage.ph/favicon/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="https://arbitrage.ph/favicon/favicon-128.png" sizes="128x128" />
	<meta name="application-name" content="Arbitrage"/>
	<meta name="msapplication-TileColor" content="#0D1F33" />
	<meta name="msapplication-TileImage" content="https://arbitrage.ph/favicon/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="https://arbitrage.ph/favicon/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="https://arbitrage.ph/favicon/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="https://arbitrage.ph/favicon/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="https://arbitrage.ph/favicon/mstile-310x310.png" />
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
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
	
	<title>Arbitrage Trading Tools | Chart</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta name="robots" content="noindex">
    <link rel="icon" href="<?php echo $homeurlgen; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-32x32.png" sizes="32x32" />
    <link rel="icon" href="<?php echo $homeurlgen; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="<?php echo $homeurlgen; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-180x180.png" />
    <meta name="msapplication-TileImage" content="<?php echo $homeurlgen; ?>/wp-content/uploads/2018/12/cropped-Arbitrage-Favicon-270x270.png" />

    <?php require "header-files.php" ?>
</head>
<body>