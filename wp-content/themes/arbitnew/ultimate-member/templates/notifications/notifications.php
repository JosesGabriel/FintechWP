<div class="um-notification-header">
	<div class="um-notification-left">
<?php use function GuzzleHttp\json_encode;
	_e('Notifications','um-notifications'); 
?></div>
	<div class="um-notification-right">
		<a href="<?php echo UM()->account()->tab_link( 'webnotifications' ); ?>" class="um-notification-i-settings"><i class="um-faicon-cog"></i></a>
		<a href="#" class="um-notification-i-close"><i class="um-icon-android-close"></i></a>
	</div>
	<div class="um-clear"></div>
</div>

<div class="um-notification-ajax">
	<?php foreach ( $notifications as $notification ) {
		if ( ! isset( $notification->id ) ) {
			continue;
		}
		// echo json_encode($notification->ID);
		// types of notification to parse
		$notification_types = [
			'',
			'comment_reply',
			'new_mention',
			'new_post_bear',
			'new_post_bull',
			'new_wall_comment',
			'new_wall_post',
		];

        if (in_array($notification->type, $notification_types)) {
            $notification->url = get_site_url() . '/?' . parse_url($notification->url, PHP_URL_QUERY);
        }
        ?>

		<div class="um-notification <?php echo $notification->type; ?> <?php echo $notification->status; ?>" data-notification_id="<?php echo $notification->id; ?>"  data-notification_uri="<?php echo $notification->url; ?>">
			<div class="um-notification-inner">
				<?php echo '<img src="'. um_secure_media_uri( $notification->photo ) .'" data-default="'. um_secure_media_uri( um_get_default_avatar_uri() ) .'" alt="" class="um-notification-photo" />'; ?>

				<?php echo stripslashes( $notification->content ); ?>

				<span class="b2" data-time-raw="<?php echo $notification->time;?>"><?php echo UM()->Notifications_API()->api()->get_icon( $notification->type ); ?><?php echo UM()->Notifications_API()->api()->nice_time( $notification->time ); ?></span>
				
				<span class="um-notification-hide"><a href="javascript:void(0);"><i class="um-icon-android-close"></i></a></span>
			</div>
			
		</div>

	<?php } ?>
</div>
<script type='text/javascript'>
// jQuery(document).ready( function() {
// 	jQuery('.um-notification-inner').on('click', function() {
// 	alert('ahsdbasdasjbdajsbdjasbd');
// 		var notification_uri = jQuery(".um-notification-inner").attr("data-notification_uri");
// 		console.log(notification_uri)
// 		if ( notification_uri ) {

// 			window.location = notification_uri;
// 		}

// 	});
// });
</script>
<div class="um-notifications-none" style="display:none;">
	<i class="um-icon-ios-bell"></i>
	<?php _e( 'No new notifications', 'um-notifications' ); ?>
</div>

<div class="um-notification-more">
	<a href="<?php echo um_get_core_page( 'notifications' ); ?>"><?php _e( 'See all notifications', 'um-notifications' ); ?></a>
</div>
