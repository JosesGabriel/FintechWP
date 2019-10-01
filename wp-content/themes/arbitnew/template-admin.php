<?php
	/*
	* Template Name: Administrator - User Page
	* Template page for Dashboard Social Platform
	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
get_header( 'dashboard' );

date_default_timezone_set('Asia/Manila');
$currentdate = date("Y-m-d", time());

	$topargs = array(
	    'role'          =>  '',
	    // 'meta_key'      =>  'account_status',
	    // 'meta_value'    =>  'approved'
	);

	$users = get_users($topargs);
	$newuserlist = array();
	foreach ($users as $key => $value) {
		$userdetails['id'] = $value->ID;
		$userdetails['displayname'] = (!empty($value->data->display_name) ? $value->data->display_name : $value->data->user_login);
		$userdetails['followers'] = UM()->Followers_API()->api()->count_followers( $value->ID );
		$userdetails['user_nicename'] = $value->data->user_nicename;

		array_push($newuserlist, $userdetails);
	}

	usort($newuserlist, function($a, $b) {
	    return $a['followers'] <=> $b['followers'];
	});
	$toptraiders = array_reverse($newuserlist);

	

	if (isset($_POST) && !empty($_POST)):
		// echo "<pre>";
		// 	print_r($_POST);
		// echo "</pre>";
		if (isset($_POST['dtype']) && $_POST['dtype'] == 'change_from_user') {
			echo 'here';
			 update_user_meta( get_current_user_id(), 'refforuser', $_POST['drefcodehere'] );
		} else {
			 update_user_meta( get_current_user_id(), 'refformentor', $_POST['dcode'] );
		}
		// update_user_meta( get_current_user_id(), 'refformentor', $_POST['dcode'] );
		//rwvng2l0

		wp_redirect('/administrator/');
		exit;
	endif;

?>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,600i" rel="stylesheet">
<style type="text/css">
    .btn-tradelog {
        border-radius: 0px;
        margin: 10px 0px;
        background: #273647;
        border: 1px solid #273647;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
    }

    .side-header .right-image .onto-user-name {
        margin-bottom: 5px;
        font-family: 'Montserrat', sans-serif;
    }
</style>



<div id="main-content" class="ondashboardpage">

	<div class="inner-placeholder">
		<div class="inner-main-content">
			
			<div class="center-dashboard-part" style="width: 100%;float:none;">
				<div class="inner-center-dashboard">
					<div class="generate-code">
						<?php if ($user->ID == '5'): ?>
							<?php include 'template-admin-stats.php';  ?>
						<?php else: ?>
							<?php if ($user->roles[0] == 'administrator'): ?>
								<?php include 'template-mentor-stats.php';  ?>
							<?php else: ?>
								<?php include 'template-user-stats.php';  ?>
							<?php endif ?>
						<?php endif; ?>

					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>

</div> <!-- #main-content -->

<?php

get_footer('admin');
