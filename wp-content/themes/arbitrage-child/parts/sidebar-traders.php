<?php
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
	$topargs = array(
		'role'          =>  '',
		// 'meta_key'      =>  'account_status',
		// 'meta_value'    =>  'approved'
	);

	$users = get_users($topargs);
	$newuserlist = array();
	foreach ($users as $key => $value) {
		// if (UM()->Friends_API()->api()->is_friend($value->id, $userID)) {
		// 	// echo $value->data->display_name.' is your friend - ';
		// } else {
		// 	// echo $value->data->display_name." is not your friend - ";
		// }
		// $isfollowing = UM()->Followers_API()->api()->followed($value->id, $userID);
		// if ($isfollowing == "" || $isfollowing < 0 ) {
		// 	$userdetails['id'] = $value->id;
		// 	$userdetails['displayname'] = (!empty($value->data->display_name) ? $value->data->display_name : $value->data->user_login);
		// 	$userdetails['followers'] = UM()->Followers_API()->api()->count_followers( $value->id );
		// 	$userdetails['user_nicename'] = $value->data->user_nicename;
		// 	array_push($newuserlist, $userdetails);
		// }

		// echo UM()->Followers_API()->api()->is_friend_pending($value->id, $userID)." - ";

		if (!UM()->Friends_API()->api()->is_friend($value->id, $userID) && $value->id != $userID) {
			
			if ( $pending = UM()->Friends_API()->api()->is_friend_pending( $value->id, $userID) ) {
				// if ($pending == $userID) {
				// 	echo $value->data->user_login." respond to request -<br />";
				// } else {
				// 	echo $value->data->user_login." request sent -<br />";
				// }
			} else {
				$userdetails['id'] = $value->id;
				$userdetails['displayname'] = (!empty($value->data->display_name) ? $value->data->display_name : $value->data->user_login);
				$userdetails['followers'] = UM()->Followers_API()->api()->count_followers( $value->id );
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
<div class="top-traiders">
  <div class="top-traiders-inner">
	  <div class="to-top-title">Who to Mingle</div>
	  <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
	  <div class="to-content-part to-back-back">
		  <div class="content-inner-part">
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
								  <div class="circle-frame" style="border: 2px solid #1e3554;padding: 4px !important;border-radius: 50%;width: 47px;height: 47px;">
								  <div class="side-image" style="background: url('<?php echo esc_url( get_avatar_url( $value['id'] ) ); ?>') no-repeat center center;">&nbsp;</div>
								  </div>
							  </div>
							  <div class="traider-details">
							  	<?php $unametype = get_user_meta($value['id'], 'disname', true); ?>
								  <div class="traider-name"><a href="https://arbitrage.ph/user/<?php echo $value['user_nicename']; ?>">
								  	<?php if ($unametype == "" || $unametype == "rn") { ?>
								  		<?php //echo $value['displayname']; ?>
								  		<?php echo $first_name." ".$last_name; ?>
								  	<?php } else { ?>
								  		<?php echo $nickname; ?>
								  	<?php } ?>
								  </a>
								  <div class="login"></div>
								  </div>
								  <div class="traider-follower">
									  <div class="onbfollow">
									  		

									  		<a href="#" id="mingle-btn" class="um-friend-btn um-button um-alt outmingle" data-user_id1="<?php echo $value['id']; ?>" data-user_id2="<?php echo $user->id; ?>">Mingle</a>
									  		
										  <!-- <a href="#" id="mingle-btn" class="um-follow-btn mingle-btn um-button um-alt" data-user_id1="<?php echo $value['id']; ?>" data-user_id2="<?php echo $user->id; ?>">Mingle</a> -->
									  </div>
								  </div>
							  </div>
						  </div>
					  </div>
			  <?php
					  $i++;
					  if($i==5) break;
				  } 
			  ?>

			   <div class="see-more-btn" style="padding: 0 0 0px 2px;">
				  <a href="https://arbitrage.ph/member-directory/">
				 	 <strong style="font-size:13px;font-weight: 400;">View all members</strong>
				  </a>
		  	  </div>

		  </div>

		  
		  
	  </div>

	 
  </div>

  
</div>
<style type="text/css">
	.top-traiders .to-content-part .trader-item .traider-details .traider-follower .onbfollow a.um-friend-pending-btn.um-button.um-alt {
	    padding: 6px 1px !important;
    	width: 110px !important;
    	font-size: 10px !important;
	}
</style>