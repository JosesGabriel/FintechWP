<?php
	/*
	* Template Name: Get User Profile
	*/ 

?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Loading...</title>
	<style>
		html, body {
			background: #0d1f33 !important;
		}
	</style>
</head>

<body>
	<?php 
	
		if (isset($_GET['eml'])){

			$gethomeurl = get_home_url();
			$emailvalue = $_GET['eml'];
			$user = get_user_by( 'email', $emailvalue );
			$userId = $user->ID;

			/* $user_info = get_userdata($userId);
			print_r($user_info); */

			// $all_meta_for_user = get_user_meta($userId);

			$userproflink = get_user_meta( $userId, 'um_user_profile_url_slug_user_login', true ); 
			$userproflink;

			// header("Location: ".$gethomeurl."/user/".$userproflink."/"); 
			// exit();
		}
	
	?><script>
	top.location = "<?php echo $gethomeurl; ?>/user/<?php echo $userproflink; ?>";
	</script>
</body>
</html>
