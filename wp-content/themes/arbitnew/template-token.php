<?php /* Template Name: Token Checker */ ?>
<?php
	require_once 'function-jwt.php';

    global $current_user;
    $user = wp_get_current_user();
	$userID = $current_user->ID;

	$jwt = new JWTBuilder();
	sso_login($_GET, $jwt);
	
?>
<html>
<head>
<style>
html {
    background: #0d1f33 !important;
}
body {overflow:hidden}
#preloader {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #354960;
	z-index: 999999;
	height: 120%;
}
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
</head>
<body>
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
</body>
</html>