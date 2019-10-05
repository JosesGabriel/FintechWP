<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="arbitrage">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
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