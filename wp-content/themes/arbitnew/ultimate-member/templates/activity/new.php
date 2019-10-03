<?php
$user = wp_get_current_user();
if ( is_user_logged_in() ) {
    // echo 'Welcome, registered user!';
} else {
    wp_redirect( '/login/', 301 );
    exit;
}
$user_first_name = get_user_meta( $user->ID, 'first_name', true );
$profile_id = um_profile_id();
$default_cover = UM()->options()->get( 'default_cover' );
um_fetch_user($profile_id);
$ismyprofile = ($user->ID == $profile_id ? true : false);
?>
	<script
	  src="https://code.jquery.com/jquery-3.4.1.min.js"
	  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	  crossorigin="anonymous"></script>
<?php
global $current_user;
  if (!is_page(26)){ 
	  	$user_id = $user->ID;
		if(isset($_POST['check_user_share_input'])){
		  $sharecheck = $_POST['check_user_share_input'];
		  update_user_meta($user_id, 'check_user_share', $sharecheck);
		}
		$checksharing = get_user_meta( $user_id, "check_user_share", true ); 
		$checkfbshare = get_user_meta( $user_id, "_um_sso_facebook_email", true );
		if(!$checksharing){
			if($checkfbshare){
				header('Location: /share/?'.rand(12345 ,89019));
				die(); 
			}else{
				header('Location: /verify/?'.rand(12345 ,89019));
				die();
			}
		}
		arbitrage_api_verify_user($user_id);
		/* if($checksharing == "shared"){
		}elseif($checksharing == "verified"){
		}elseif(!$checksharing){
			if ($checkfbshare && !$checksharing){
				header('Location: /share/?'.rand(12345 ,89019));
				die();
			}else{
				header('Location: /verify/?'.rand(12345 ,89019));
				die();
			}
		} */
	  /*if(isset($_POST['check_user_share_input'])){
			$sharecheck = $_POST['check_user_share_input'];
			update_user_meta($user_id, 'check_user_share', $sharecheck);
	  }
	  $checksharing1 = get_user_meta( $user_id, "_um_sso_facebook_email", true );
	  $checksharing2 = get_user_meta( $user_id, "check_user_share", true );
	  if ($checksharing1 && !$checksharing2){
			echo '<script type="text/javascript">window.location.href = "/share/?'.rand(12345 ,89019).'";</script>';
	  }else{
		  	echo '<script type="text/javascript">window.location.href = "/verify/?'.rand(12345 ,89019).'";</script>';
	  }*/
  }
  if (isset($_GET['resetshare'])){
	    $user_id = $user->ID;
		update_user_meta($user_id, 'check_user_share', "");
		header('Location: /share/?'.rand(12345 ,89019));
		die();
  } 
	elegant_description();
	elegant_keywords();
	elegant_canonical();
	/**
	 * Fires in the head, before {@see wp_head()} is called. This action can be used to
	 * insert elements into the beginning of the head before any styles or scripts.
	 *
	 * @since 1.0
	 */
	do_action( 'et_head_meta' );
	$cdnorlocal = get_home_url();
	$template_directory_uri = get_template_directory_uri();
?>
<!-- New Post HTML template -->
<div class="um-activity-widget um-activity-new-post ss" style="box-shadow: 0px 1px 2px -1px rgba(4,13,23,1) !important;">
	<!-- <form action="" >
		<input type="file" onchange="previewFile()"><br>
       	<img src="" height="200" alt="Image preview...">
	</form> -->
	<form action="" method="post"  enctype="multipart/form-data" class="um-activity-publish" id="publishImage">
		<input type="hidden" name="action" id="action" value="um_activity_publish" />
		<input type="hidden" name="_post_id" id="_post_id" value="0" />
		<input type="hidden" name="_wall_id" id="_wall_id" value="<?php echo esc_attr( um_profile_id() ); ?>" />
		<input type="hidden" name="_wall_user_name" value="<?php echo um_user( 'display_name' ) ?>" />
		<input type="hidden" name="_wall_user_url" value="<?php echo um_user_profile_url() ?>" />
		<input type="hidden" name="_post_img" value="" />
		<input type="hidden" name="_post_img_url" value="" />

		<div class="um-activity-head">
			<?php if ( um_profile_id() == get_current_user_id() ) {
				_e( 'Post on your wall','um-activity' );
			} else {
				printf( __( 'Post on %s\'s wall', 'um-activity' ), um_user( 'display_name' ) );
			} ?>
		</div>

		<div class="um-activity-body">

			<div class="um-activity-textarea">
				<textarea data-photoph="<?php esc_attr_e( 'Say something about this photo', 'um-activity' ); ?>"
						  data-ph="Hey <?php echo esc_attr_e($user_first_name); ?>, penny for your thoughts?"
				          placeholder="Hey <?php echo esc_attr_e($user_first_name); ?>, penny for your thoughts?"
				          class="um-activity-textarea-elem" name="_post_content"></textarea>
				<hr class="style14 style15">
			</div>
			<div class="um-activity-preview">
				<span class="um-activity-preview-spn">
					<img src="" alt="" title="" width="" height="" />
					<span class="um-activity-img-remove">
						<i class="um-icon-close"></i>
					</span>
				</span>
			</div>
			<div class="um-clear"></div>
		</div>

		<div class="um-activity-foot">

			<div class="um-activity-left um-activity-insert">

				<?php do_action( 'um_activity_pre_insert_tools' );

				if ( ! UM()->roles()->um_user_can( 'activity_photo_off' ) ) {
					$timestamp = current_time( "timestamp" );
					$nonce = wp_create_nonce( 'um_upload_nonce-' . $timestamp ); ?>
					<a href="#" class="um-activity-insert-photo um-tip-s" data-timestamp="<?php echo esc_attr( $timestamp );?>" data-nonce="<?php echo esc_attr( $nonce );?>"title="<?php esc_attr_e( 'Add photo', 'um-activity' ); ?>" data-allowed="gif,png,jpeg,jpg"data-size-err="<?php esc_attr_e( 'Image is too large', 'um-activity' ); ?>"data-ext-err="<?php esc_attr_e( 'Please upload a valid image', 'um-activity' ); ?>">


					<div class="photo-upload-cont" style="display: inline-block;/* background-color: #11273e; */padding: 4px 14px;border-radius: 25px;border: 1px solid #1e3554 !important;">
						<img src="/svg/photo1.svg" style="width: 21px;vertical-align: bottom;">
						<span style="padding-left: 3px;font-size: 13px;color: #fffffe;">Photo</span> 
					</div>
					<!-- <div class="video-upload-cont" style="display: inline-block;background-color: #11273e;padding: 4px 14px;border-radius: 25px;    margin: 0 6px">
						<img src="/svg/camera-video.svg" style="width: 21px;vertical-align: bottom;">
						<span style="padding-left: 3px;font-size: 13px;color: #fffffe;">Video</span>
					</div>
					<div class="tag-upload-cont" style="display: inline-block;background-color: #11273e;padding: 4px 14px;border-radius: 25px;">
						<img src="/svg/user-outline.svg" style="width: 19px;vertical-align: sub;height: 18px;">
						<span style="padding-left: 3px;font-size: 13px;color: #fffffe;">People</span>
					</div> -->
					</a>


				<?php }

				do_action( 'um_activity_post_insert_tools' ); ?>

				<div class="um-clear"></div>
				
			</div>
			

			<div class="um-activity-right">
				<a href="javascript:void(0);" class="um-button um-activity-post um-disabled">
					<?php _e( 'Post', 'um-activity' ); ?>
				</a>
			</div>
			<div class="um-clear"></div>

		</div>
	</form>
</div>

<!-- Edit Post JS Template -->
<script type="text/template" id="tmpl-um-edit-post">
	<form action="" method="post" class="um-activity-publish">
		<input type="hidden" name="action" value="um_activity_publish" />
		<input type="hidden" name="_post_id" value="{{{data.post_id}}}" />
		<input type="hidden" name="_wall_id" value="<?php echo esc_attr( um_profile_id() ); ?>" />
		<input type="hidden" name="_post_img" value="{{{data._photo}}}" />
		<input type="hidden" name="_post_img_url" value="{{{data._photo_url}}}" />

		<div class="um-activity-body">

			<div class="um-activity-textarea">
				<textarea data-photoph="<?php esc_attr_e( 'Say something about this photo', 'um-activity' ); ?>"
				          data-ph="Hey <?php echo esc_attr_e($user_first_name); ?>, penny for your thoughts?"
				          placeholder="Hey <?php echo esc_attr_e($user_first_name); ?>, penny for your thoughts?"
				          class="um-activity-textarea-elem" name="_post_content">{{{data.textarea}}}</textarea>
			</div>

			<div class="um-activity-preview">
				<span class="um-activity-preview-spn">
					<img src="{{{data._photo_url}}}" alt="" title="" width="" height="" />
					<span class="um-activity-img-remove">
						<i class="um-icon-close"></i>
					</span>
				</span>
			</div>

			<div class="um-clear"></div>
		</div>

		<div class="um-activity-foot">

			<div class="um-activity-left um-activity-insert">

				<?php do_action( 'um_activity_pre_insert_tools' );

				if ( ! UM()->roles()->um_user_can( 'activity_photo_off' ) ) {
					$timestamp = current_time( "timestamp" );
					$nonce = wp_create_nonce( 'um_upload_nonce-' . $timestamp ); ?>
					<a href="#" class="um-activity-insert-photo um-tip-s" data-timestamp="<?php echo esc_attr( $timestamp );?>" data-nonce="<?php echo esc_attr( $nonce );?>"
					   title="<?php esc_attr_e( 'Add photo', 'um-activity' ); ?>" data-allowed="gif,png,jpeg,jpg"
					   data-size-err="<?php esc_attr_e( 'Image is too large', 'um-activity' ); ?>"
					   data-ext-err="<?php esc_attr_e( 'Please upload a valid image', 'um-activity' ); ?>">
						<div class="photo-upload-cont" style="display: inline-block;/* background-color: #11273e; */padding: 4px 14px;border-radius:25px;border: 1px solid #1e3554 !important;margin-top: -2px;">
							<img src="/svg/photo1.svg" style="width: 21px;vertical-align: bottom;">
							<span style="padding-left: 3px;font-size: 13px;color: #fffffe;">Photo</span> 
						</div>
					</a>
				<?php }

				do_action( 'um_activity_post_insert_tools' ); ?>

				<div class="um-clear"></div>
			</div>

			<div class="um-activity-right">
				<a href="javascript:void(0);" class="um-activity-edit-cancel">
					<?php _e( 'Cancel editing', 'um-activity' ); ?>
				</a>
				<a href="javascript:void(0);" class="um-button um-activity-post um-disabled">
					<?php _e( 'Update', 'um-activity' ); ?>
				</a>
			</div>
			<div class="um-clear"></div>

		</div>
	</form>
</script>