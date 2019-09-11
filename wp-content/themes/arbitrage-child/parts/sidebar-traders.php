<?php
	global $current_user;
	$user = wp_get_current_user();
	$userID = $current_user->ID;
	$topargs = array(
		'role'          =>  '',
	);
	$users = get_users($topargs);
	$newuserlist = array();
	foreach ($users as $key => $value) {

		if (!UM()->Friends_API()->api()->is_friend($value->ID, $userID) && $value->ID != $userID) {
			
			if ( $pending = UM()->Friends_API()->api()->is_friend_pending( $value->ID, $userID) ) {
				// if ($pending == $userID) {
				// 	echo $value->data->user_login." respond to request -<br />";
				// } else {
				// 	echo $value->data->user_login." request sent -<br />";
				// }
			} else {
				$userdetails['id'] = $value->ID;
				$userdetails['displayname'] = (!empty($value->data->display_name) ? $value->data->display_name : $value->data->user_login);
				$userdetails['followers'] = UM()->Followers_API()->api()->count_followers( $value->ID );
				$userdetails['user_nicename'] = $value->data->user_nicename;
				array_push($newuserlist, $userdetails);
			}
		}
	}

	usort($newuserlist, function($a, $b) {
		return $a['followers'] <=> $b['followers'];
	});
	$toptraiders = array_reverse($newuserlist);

?>
<div class="top-traiders" style="margin-top: 10px;">
  <div class="top-traiders-inner">
	  <div class="to-top-title">Who to Mingle</div>
	  <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
	  <div class="to-content-part to-back-back">
		  <div class="content-inner-part">
			  <div class="top-recommended-people">
			  	<div id="preloader" class="trendingpreloader">
					<div id="status">&nbsp;</div>
					<div id="status_txt"></div>
				</div>
			  </div>
			  <?php
				  $i=0;
				  foreach ($toptraiders as $key => $value) { ?>
				  	<?php
				  		$nickname = get_user_meta($value['id'], 'nickname', true);
				  		$first_name = get_user_meta($value['id'], 'first_name', true);
				  		$last_name = get_user_meta($value['id'], 'last_name', true);
				  	?>
					  <div class="trader-item userid_<?php echo $value['id']; ?>">
						  <div class="traider-inner">
							  <div class="traider-image">
								  <div class="circle-frame" style="border:2px solid rgba(101, 131, 168, 0.4196078431372549);padding: 4px !important;border-radius: 50%;width: 47px;height: 47px;">
								  <div class="side-image" style="background: url('<?php echo esc_url( get_avatar_url( $value['id'] ) ); ?>') no-repeat center center;">&nbsp;</div>
								  </div>
							  </div>
							  <div class="traider-details">
							  	<?php $unametype = get_user_meta($value['id'], 'disname', true); ?>
								  <div class="traider-name"><a href="https://arbitrage.ph/user/<?php echo $value['user_nicename']; ?>">
								  	<?php echo ($unametype == "" || $unametype == "rn" ? $first_name." ".$last_name : $nickname); ?>
								  </a>
								  <div class="login"></div>
								  </div>
								  <div class="traider-follower">
									  <div class="onbfollow">
									  		<a href="#" id="mingle-btn" style="border: 1.3px solid #e77e24;" class="um-friend-btn um-button um-alt outmingle" data-user_id1="<?php echo $value['id']; ?>" data-user_id2="<?php echo $user->ID; ?>">Mingle</a>
									  </div>
								  </div>
							  </div>
						  </div>
					  </div>
			  <?php
					  $i++;
					  if($i==3) break;
				  } 
			  ?>

			   <div class="see-more-btn see-all-members" style="padding: 0 0 0px 2px;">
				  <a href="https://arbitrage.ph/member-directory/">
				 	 <strong style="font-size:13px;font-weight: 400;">View all members</strong>
				  </a>
		  	  </div>

		  </div>
	  </div>
  </div>
</div>