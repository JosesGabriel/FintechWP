<?php if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Add stats to member directory
 *
 * @param $user_id
 * @param $args
 */
function um_friends_friend_button_in_directory( $user_id, $args ) {
	wp_enqueue_script( 'um_friends' );
	wp_enqueue_style( 'um_friends' );

	$can_view = true;

	if ( ! is_user_logged_in() || get_current_user_id() != $user_id ) {
		$is_private_case_old = UM()->user()->is_private_case( $user_id, __( 'Friends only', 'um-friends' ) );
		$is_private_case = UM()->user()->is_private_case( $user_id, 'friends' );
		if ( $is_private_case || $is_private_case_old ) { // only friends can view my profile
			$can_view = false;
		}
	}

	if ( UM()->options()->get( 'friends_show_stats' ) && $can_view ) { ?>
		<div class="um-members-friend-stats">
			<div><?php echo UM()->Friends_API()->api()->count_friends( $user_id ); ?><?php _e( 'friends', 'um-friends' ); ?></div>
		</div>
	<?php }

	$show_button = apply_filters( 'um_friends_show_button', UM()->options()->get( 'friends_show_button' ), $user_id, get_current_user_id() );
	if ( $show_button ) {
		$btn = UM()->Friends_API()->api()->friend_button( $user_id, get_current_user_id() );

		if ( $btn ) {
			echo '<div class="um-members-friend-btn">' . $btn . '</div>';
		}
	}
}
add_action( 'um_members_just_after_name', 'um_friends_friend_button_in_directory', 99, 2 );