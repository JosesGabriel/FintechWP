<?php if ( ! defined( 'ABSPATH' ) ) exit;


$user = wp_get_current_user();
$profile_id = um_profile_id();
$ismyprofile = ($user->id == $profile_id ? true : false);



$note = ( $user_id == get_current_user_id() ) ? __( 'You do not have any friends yet.', 'um-friends' ) : __( 'This user does not have any friends yet.', 'um-friends' );

if ( isset( $_is_reqs ) ) {
	$note = __( 'You do not have pending friend requests yet.', 'um-friends' );
}

if ( isset( $_sent ) ) {
	$note = __( 'You have not sent any friend requests yet.', 'um-friends' );
}

if ( $friends ) {
	foreach ( $friends as $k => $arr ) {

		extract( $arr );

		if ( isset( $_sent ) ) {
			$user_id2 = $user_id1;
		}

		if ( $user_id2 == $user_id ) {
			$user_id2 = $user_id1;
		}

		um_fetch_user( $user_id2 ); ?>
	
		<div class="um-friends-user" style="border-bottom: 0px;">


		
			<a href="<?php echo um_user_profile_url(); ?>" class="um-friends-user-photo" title="<?php echo um_user('display_name'); ?>"><?php echo get_avatar( um_user('ID'), 50 ); ?></a>

			<div class="um-friends-user-btn">
				<?php if ( $user_id2 == get_current_user_id() ) {
					echo '<a href="' . um_edit_profile_url() . '" class="um-friend-edit um-button um-alt">' . __( 'Edit profile', 'um-friends' ) . '</a>';
				} else {
					echo UM()->Friends_API()->api()->friend_button( $user_id2, get_current_user_id(), true );
				} ?>
			</div>

			<div class="um-friends-user-name">
				<a href="<?php echo um_user_profile_url(); ?>" title="<?php echo um_user( 'display_name' ); ?>" style="color: #d8d8d8" ><?php echo um_user( 'display_name' ); ?></a>

				<?php do_action( 'um_friends_list_post_user_name', $user_id, $user_id2 );
				do_action( 'um_friends_list_after_user_name', $user_id, $user_id2 ); ?>

						<div class="friendslist" style="float: right;">


							<ul >																			
										<li >
											<?php echo UM()->Friends_API()->api()->friend_button( $user_id2, get_current_user_id() ); ?>
										</li>
							</ul>
						</div>	

			</div>


			<div class="Peertxt" style="font-weight: 300; font-size: 11px; color: #aaa;"><?php 

			
			//echo UM()->Friends_API()->api()->count_friends($user_id2); 
			$peers = UM()->Friends_API()->api()->count_friends($user_id2); 
			echo $peers;
			echo ' Peers';

			//if($peers > 1 ) { 
				//	echo ' Peer';
			//} else {
				//	echo ' Peers';
			//}
				?> </div>


			<?php //do_action( 'um_friends_list_pre_user_bio', $user_id, $user_id2 ); ?>

			<!--<div class="um-friends-user-bio">
				<?php //echo um_filtered_value( 'description' ); ?>
			</div>

			<?php// do_action('um_friends_list_post_user_bio', $user_id, $user_id2 ); ?>-->




			<!--
			<div class="onbfollow">				  		
				<a href="#" id="mingle-btn" class="um-friend-btn um-button um-alt outmingle" data-user_id1="<?php echo $value['id']; ?>" data-user_id2="<?php echo $user->id; ?>">Mingle</a>					  		
			 </div>-->
		 

		</div>

	<?php }

} else { ?>

	<div class="um-profile-note">
		<span><?php echo $note; ?></span>
	</div>

<?php } ?>

