<?php
	// global $current_user;
	// $user = wp_get_current_user();
	// $userID = $current_user->ID;
	// $topargs = array(
	// 	'role'          =>  '',
	// );
	// $users = get_users($topargs);
	// $newuserlist = array();
	// foreach ($users as $key => $value) {

	// 	if (!UM()->Friends_API()->api()->is_friend($value->ID, $userID) && $value->ID != $userID) {
			
	// 		if ( $pending = UM()->Friends_API()->api()->is_friend_pending( $value->ID, $userID) ) {
	// 			// if ($pending == $userID) {
	// 			// 	echo $value->data->user_login." respond to request -<br />";
	// 			// } else {
	// 			// 	echo $value->data->user_login." request sent -<br />";
	// 			// }
	// 		} else {
	// 			$userdetails['id'] = $value->ID;
	// 			$userdetails['displayname'] = (!empty($value->data->display_name) ? $value->data->display_name : $value->data->user_login);
	// 			$userdetails['followers'] = UM()->Followers_API()->api()->count_followers( $value->ID );
	// 			$userdetails['user_nicename'] = $value->data->user_nicename;
	// 			array_push($newuserlist, $userdetails);
	// 		}
	// 	}
	// }

	// usort($newuserlist, function($a, $b) {
	// 	return $a['followers'] <=> $b['followers'];
	// });
	// $toptraiders = array_reverse($newuserlist);

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
			  

			   <div class="see-more-btn see-all-members" style="padding: 0 0 0px 2px;">
				  <a href="https://arbitrage.ph/member-directory/">
				 	 <strong style="font-size:13px;font-weight: 400;">View all members</strong>
				  </a>
		  	  </div>

		  </div>
	  </div>
  </div>
</div>