<?php date_default_timezone_set("Asia/Manila"); ?>
<?php
if (!function_exists('getnumformat'))
{
    function getnumformat( $n, $precision = 1 ) {
		if ($n < 900) {
			// 0 - 900
			$n_format = number_format($n, $precision);
			$suffix = '';
		} else if ($n < 900000) {
			// 0.9k-850k
			$n_format = number_format($n / 1000, $precision);
			$suffix = 'K';
		} else if ($n < 900000000) {
			// 0.9m-850m
			$n_format = number_format($n / 1000000, $precision);
			$suffix = 'M';
		} else if ($n < 900000000000) {
			// 0.9b-850b
			$n_format = number_format($n / 1000000000, $precision);
			$suffix = 'B';
		} else {
			// 0.9t+
			$n_format = number_format($n / 1000000000000, $precision);
			$suffix = 'T';
		}

		if ( $precision > 0 ) {
			$dotzero = '.' . str_repeat( '0', $precision );
			$n_format = str_replace( $dotzero, '', $n_format );
		}
		return $n_format . $suffix;
	}

}

//build posts query

$args = array(

	'post_type'     => 'um_activity',

	'post_status'   => array( 'publish' ),

);



if ( isset( $wall_post ) && $wall_post > 0 ) {



	$args['post__in'] = array( $wall_post );



	// $followed_ids = UM()->Activity_API()->api()->followed_ids();

	// if ( $followed_ids ) {

	// 	$args['meta_query'][] = array(

	// 		'key'       => '_user_id',

	// 		'value'     => $followed_ids,

	// 		'compare'   => 'IN'

	// 	);

	// }



	// $friends_ids = UM()->Activity_API()->api()->friends_ids();

	// if ( $friends_ids ) {

	// 	$args['meta_query'][] = array(

	// 		'key'       => '_user_id',

	// 		'value'     => $friends_ids,

	// 		'compare'   => 'IN'

	// 	);

	// }



} else {



	//set offset when pagination

	$args['posts_per_page'] = UM()->Activity_API()->api()->get_posts_per_page();

	if ( isset( $offset ) ) {

		$args['offset'] = $offset;

	}

	//If $user_wall == 0 - Loads Global Site Activity
	//If $user_wall == 1 - Loads User Wall and $user_id

	if ( ! empty( $user_wall ) ) {

		if ( ! empty( $user_id ) ) {

			$args['meta_query'][] = array(

				'relation'	=> 'OR',

				array(

					'key'       => '_wall_id',

					'value'     => $user_id,

					'compare'   => '='

				),

				array(

					'key'       => '_user_id',

					'value'     => $user_id,

					'compare'   => '='

				)

			);

		}

	} else {

		// $followed_ids = UM()->Activity_API()->api()->followed_ids();

		// if ( $followed_ids ) {

		// 	$args['meta_query'][] = array(

		// 		'key'       => '_user_id',

		// 		'value'     => $followed_ids,

		// 		'compare'   => 'IN'

		// 	);

		// }



		// $friends_ids = UM()->Activity_API()->api()->friends_ids();

		// if ( $friends_ids ) {

		// 	$args['meta_query'][] = array(

		// 		'key'       => '_user_id',

		// 		'value'     => $friends_ids,

		// 		'compare'   => 'IN'

		// 	);

		// }

	}





	if ( isset( $hashtag ) && $hashtag ) {



		$args['tax_query'] = array(

			array(

				'taxonomy'  => 'um_hashtag',

				'field'     => 'slug',

				'terms'     => array ( $hashtag )

			)

		);



	}

}



/*******************************************************************/



$args = apply_filters( 'um_activity_wall_args', $args );



$wallposts = new WP_Query( $args );


$get_current_user_id = get_current_user_id();

if ( $wallposts->found_posts == 0 ) {

	return;

}

$adscount = 0;

foreach ( $wallposts->posts as $post ) {

	$author_id = UM()->Activity_API()->api()->get_author( $post->ID );

	$can_view = UM()->Activity_API()->api()->can_view_wall( $author_id );

	// exclude private walls

	if ( $can_view !== true ) {

		continue;

	}



	$wall_id = UM()->Activity_API()->api()->get_wall( $post->ID );

	$post_link = UM()->Activity_API()->api()->get_permalink( $post->ID );

	um_fetch_user( $author_id );

	$um_user_profile_url = um_user_profile_url();

	?>



	<div class="um-activity-widget hala-user-wall-else" style="box-shadow: 0px 1px 2px -1px rgba(4,13,23,1) !important;" id="postid-<?php echo $post->ID; ?>">



		<div class="um-activity-head">



			<div class="um-activity-left um-activity-author">

				<div class="um-activity-ava">

					<a href="<?php echo esc_attr( $um_user_profile_url ); ?>">

						<?php echo get_avatar( $author_id, 80 ); ?>

					</a>

				</div>
				<?php $unametype = get_user_meta($author_id, 'disname', true); ?>
				<div class="um-activity-author-meta">

					<div class="um-activity-author-url">
						<a href="<?php echo $um_user_profile_url; ?>" class="um-link">
							<?php if ($unametype == "" || $unametype == 'rn'): ?>
								<?php echo um_user('display_name', 'html'); ?>
							<?php else: ?>
								<?php echo um_user('nickname', 'html'); ?>
							<?php endif ?>


						</a>
            <!-- Mingle button on user wall ---->
	

			<!-- Mingle button on user wall ---->
					<span>
						<?php 
							$author_sentiment = get_post_meta( $post->ID, '_author_sentiment', TRUE );
							if ($author_sentiment != '' && $author_sentiment == 0) {
								echo('<span class="authorSentiment__dash"><i class="fas fa-minus"></i></span>');
								echo('<span class="authorSentiment authorSentiment--bullish">BULLISH</span>');
							} else if ($author_sentiment != '' && $author_sentiment == 1) {
								echo('<span class="authorSentiment__dash"><i class="fas fa-minus"></i></span>');
								echo('<span class="authorSentiment authorSentiment--bearish">BEARISH</span>');
							}
						?>
					</span>
						<?php if ( $wall_id && $wall_id != $author_id ) {

							um_fetch_user( $wall_id ); ?>

							<i class="um-icon-forward"></i>

							<a href="<?php esc_attr( $um_user_profile_url ) ?>" class="um-link">

								<?php echo um_user( 'display_name' ) ?>

							</a>

						<?php } ?>

					</div>

					<span class="um-activity-metadata">

						<a href="<?php echo esc_attr( $post_link ); ?>">

							<?php echo UM()->Activity_API()->api()->get_post_time( $post->ID ); ?>

						</a>

					</span>

				</div>

			</div>



			<div class="um-activity-right">

				<?php if ( $get_current_user_id ) { ?>

					<a href="#" class="um-activity-ticon um-activity-start-dialog" data-role="um-activity-tool-dialog">

						<i class="fas fa-ellipsis-h drop-over-post"></i>

					</a>


					<div class="um-activity-dialog um-activity-tool-dialog">
					<?php
						#do not display button if post author is yourself
						if (get_current_user_id() != $author_id){
						if(author_is_a_friend($author_id, get_current_user_id()) == "false"){
						?>
							<a href="#" id="soc-mingle-btn" class="um-friend-btn um-button um-alt outmingle" data-user_id1="<?php echo $author_id; ?>" data-user_id2="<?php echo get_current_user_id(); ?>">
								Mingle
							</a>
					<?php
					}
					}
					?>


						<?php if ( ( current_user_can('edit_users') || $author_id == $get_current_user_id ) && ( UM()->Activity_API()->api()->get_action_type( $post->ID ) == 'status' ) ) { ?>

							<a href="javascript:void(0);" class="um-activity-manage">

								<?php _e('Edit','um-activity'); ?>

							</a>

						<?php }



						if ( current_user_can('edit_users') || $author_id == $get_current_user_id ) { ?>

							<a href="javascript:void(0);" class="um-activity-trash"

							   data-msg="<?php esc_attr_e('Are you sure you want to delete this post?','um-activity'); ?>">

								<?php _e('Delete','um-activity'); ?>

							</a>

						<?php }



						if ( $author_id != $get_current_user_id ) { ?>

							<span class="sep"></span>

							<a href="#" class="um-activity-report <?php if ( UM()->Activity_API()->api()->reported( $post->ID ) ) echo 'flagged'; ?>"

							   data-report="<?php esc_attr_e('Report','um-activity'); ?>"

							   data-cancel_report="<?php esc_attr_e('Cancel report','um-activity'); ?>">

								<?php echo ( UM()->Activity_API()->api()->reported( $post->ID, $get_current_user_id ) ) ? __('Cancel report','um-activity') : __('Report','um-activity'); ?>

							</a>

						<?php }  ?>



					</div>



				<?php } ?>

			</div>



			<div class="um-clear"></div>

		</div>



		<?php $has_video = UM()->Activity_API()->api()->get_video( $post->ID );

		$has_text_video = get_post_meta( $post->ID , '_video_url', true );

		$has_oembed = get_post_meta( $post->ID , '_oembed', true ); ?>



		<div class="um-activity-body">

			<div class="um-activity-bodyinner<?php if( $has_video || $has_text_video ){ echo ' has-embeded-video'; } ?> <?php if( $has_oembed ){ echo ' has-oembeded'; } ?>">

				<div class="um-activity-bodyinner-edit">

					<textarea style="display: none;"><?php echo esc_attr( get_post_meta( $post->ID, '_original_content', true ) ); ?></textarea>



					<?php $photo_base = get_post_meta( $post->ID, '_photo', true );

					$photo_url = UM()->Activity_API()->api()->get_download_link( $post->ID, $author_id ); ?>

					<input type="hidden" name="_photo" value="<?php echo $photo_base; ?>" />

					<input type="hidden" name="_photo_url" value="<?php echo $photo_url; ?>" />

				</div>



				<?php $um_activity_post = UM()->Activity_API()->api()->get_content( $post->ID, $has_video ); ?>

				<?php $um_shared_link = get_post_meta( $post->ID, '_shared_link', true ); ?>

				<?php if ( $um_activity_post || $um_shared_link ) { ?>

					<div class="um-activity-bodyinner-txt">

						<?php
						// if ($um_activity_post != "") {
						// 	$newconts = "";
						// 	$dprocessedtext = explode(" ", $um_activity_post);
						// 	foreach ($dprocessedtext as $dwordpkey => $dwordpvalue) {
						// 		if (strpos($dwordpvalue, '$') !== false) {
						// 		    echo $dwordpvalue;
						// 		    $dstock = str_replace("$", "", $dwordpvalue);
						// 		    $dlink = '<a href="/chart/'.$dstock.'">'.$dwordpvalue.'</a>';
						// 		    $newconts .= " ".$dlink;
						// 		} else {
						// 			$newconts .= " ".$dwordpvalue;
						// 		}
						// 	}
						// }

						?>

						<?php echo $um_activity_post; ?>

					</div>

				<?php } ?>



				<div class="um-activity-bodyinner-photo">

					<?php echo UM()->Activity_API()->api()->get_photo( $post->ID, '', $author_id ); ?>

				</div>



				<?php if ( empty( $um_shared_link ) ) { ?>

					<div class="um-activity-bodyinner-video">

						<?php echo $has_video; ?>

					</div>

				<?php } ?>

			</div>



			<?php



			$numbullish = UM()->Activity_API()->api()->get_bullish_number( $post->ID );

			$numbear = UM()->Activity_API()->api()->get_bearish_number( $post->ID );

			$comments = UM()->Activity_API()->api()->get_comments_number( $post->ID );

			?>

		</div>

		<style type="text/css">
			.totabs active {
				border-bottom: 2px solid #e77e24;
			}
			.mingle-btn {
				background-color: transparent;
				border: 1px solid #e77e24;
				color: white !important;
				cursor: pointer;
				border-radius: 40px;
				padding: 0 6px;
				width: 10px;
				height: 20px;
				overflow: hidden;
				-webkit-transition: width 1s;
				transition: width 1s;
				white-space: nowrap; 
				transform: scale(0.8);
				position: relative;
				bottom: 8px;
			}
			.mingle-btn i {
				width: 0.4em !important;
				font-size: 0.7em !important;
				margin-left: 1px !important; 
				margin-bottom: 4px;
				color: #e77e24 !important;
				top: 0px !important;
			}
			.mingle-btn:hover {
				background-color: #e77e24;
				width: 80px;
				-webkit-transition: width 1s;
				transition: width 1s;
			}
			.mingle-btn:hover::after {
				content: 'Mingle';
				font-size: 0.8em;
			}
			.mingle-btn:hover i {
				color: white !important;
			}
		</style>
		<div class="taggedStock__wrapper">
			<input type="hidden" value="<?php $tagged_stock = get_post_meta( $post->ID, '_stock_tagged', TRUE ); echo($tagged_stock);?>">
			<span class="taggedStock__totalChange" id="stockTotalChange-<?php echo $post->ID ?>"></span>
			<?php echo $tagged_stock ? '<span class="taggedStock__anchor" id="taggedStock__anchor-'. $post->ID .'""><a class="um-link" onclick="checkCurrentPrice('. "'" . $tagged_stock . "','". $post->ID. "'". ')">See Stock Details</a></span>' : '' ?>
		</div>
		<div class="um-activity-foot status" id="wallcomments-<?php echo $post->ID; ?>">

			<?php if ( $get_current_user_id ) { ?>

				<div class="um-activity-left um-activity-actions">

					<div class="um-activity-bullish <?php echo (UM()->Activity_API()->api()->user_is_bullish($post->ID) ? 'active isyours' : 'notyours') ?>" data-numbull="<?php echo $numbullish; ?>">

						<a href="#">

							<span class="diconbase"><img src="/assets/svg/ico_bullish_no_ring.svg"></span>



						</a>

						<span class="dnumof" data-istab="bullish" data-modalx="mod<?php echo $post->ID; ?>"><?php echo getnumformat($numbullish); ?></span>

					</div>

					<div class="um-activity-bearish <?php echo (UM()->Activity_API()->api()->user_is_bearish($post->ID) ? 'active isyours' : 'notyours') ?>" data-numbear="<?php echo $numbear; ?>">

						<a href="#">

							<span class="diconbase"><img src="/assets/svg/ico_bearish_no_ring.svg"></span>



						</a>

						<span class="dnumof" data-istab="bearish" data-modalx="mod<?php echo $post->ID; ?>"><?php echo getnumformat($numbear); ?></span>

					</div>



					<div class="dpartmodal">

						<div class="modal fade" id="mod<?php echo $post->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 60px;">

						  <div class="modal-dialog" role="document" style="float: none; max-width: 300px;">

						    <div class="modal-content" style="border-radius: 20px;">

						      <div class="modal-header bullbear-Modal--header" style="border-bottom: 0px; padding: 10px;">

						        <div class="dtabspart">

						        	<ul class="tabbutton">

										<li class="totabs" style="color: white;" data-btname="bullish">
											<span style="margin-left: 0;">
												<img src="/svg/Bullish-border.svg" style="width: 30px; padding: 5px;">
											</span>
											<span style="margin-left: 0px;" class="dnumof" data-istab="bullish" data-modalx="mod<?php echo $post->ID; ?>"><?php echo getnumformat($numbullish); ?></span>
										</li>

										<li class="totabs" style="color: white;" data-btname="bearish">
											<span style="margin-left: 0;">
												<img src="/svg/Bearish-border.svg" style="width: 30px; padding: 5px;">
											</span>
											<span style="margin-left: 0px;" class="dnumof" data-istab="bearish" data-modalx="mod<?php echo $post->ID; ?>"><?php echo getnumformat($numbear); ?></span>
										</li>

						        	</ul>

						        </div>

						        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">

						          <span aria-hidden="true">&times;</span>

						        </button>

						      </div>
							<div style="height: 3px; background-image: linear-gradient(to right, #894b9d, #eb8023, #c2b819, #49ba6f, #2581bc);"></div>
						      <div class="modal-body bullbear-Modal--body">

						        <div class="totab">

						        	<div class="bullish">

						        		<div class="innerbull">

											<?php

												$post_bull_people = get_post_meta( $post->ID, '_bull_people', TRUE );

												if ($post_bull_people):
													foreach (get_post_meta($post->ID, '_bull_people', true) as $key => $value):
														$user_info = get_userdata($value);

											?>

													<a href="/user/<?php echo $user_info->user_login; ?>" target="_blank" style="width: 100%; font-size: 0.9em; color: white !important; margin-right: 10px; margin-left: 0px;">

													<img src="/assets/svg/ico_bullish_no_ring_notification.svg" style="width: 24px; padding: 5px;">
														<?php echo($user_info->display_name != '' ? $user_info->display_name : $user_info->user_nicename); ?>
													</a>



											<?php

													endforeach;
												endif;
											?>

						        		</div>

						        	</div>

						        	<div class="bearish">

										<?php

											$post_bear_people = get_post_meta( $post->ID, '_bear_people', TRUE );

											if ($post_bear_people):
												foreach ($post_bear_people as $key => $value):

													$user_info = get_userdata($value);

										?>

												<a href="/user/<?php echo $user_info->user_login; ?>" target="_blank" style="width: 100%; font-size: 0.9em; color: white!important; margin-right: 10px; margin-left: 0px;">

												<img src="/assets/svg/ico_bearish_no_ring_notification.svg" style="width: 20px; padding: 5px;">
													<?php echo ($user_info->display_name != "" ? $user_info->display_name : $user_info->user_nicename); ?>
												</a>

										<?php
												endforeach;
											endif;
										?>

						        	</div>

						        </div>

						      </div>

						    </div>

						  </div>

						</div>

					</div>

				</div>



			<?php } else { ?>

				<div class="um-activity-left um-activity-join"><?php echo UM()->Activity_API()->api()->login_to_interact( $post->ID ); ?></div>

			<?php } ?>



			<div class="um-clear"></div>
			<hr class="style14 style11">

		</div>



		<?php UM()->Activity_API()->shortcode()->load_template( 'comments', $post->ID ); ?>



	</div>

<?php } ?>

<div class="um-activity-load"></div>

<?php

  function author_is_a_friend($friendid,$currentuser){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $userID = $currentuser;
        $user_id_1 = 0;
        $res = $conn->query("select distinct user_id1 from arby_um_friends where user_id2 = ".$userID." and user_id1 = ".$friendid." and status = 1");
        if($res->num_rows > 0){
            return "true";
        }else{
            return "false";
        }
        mysqli_close($conn);
  }

?>
