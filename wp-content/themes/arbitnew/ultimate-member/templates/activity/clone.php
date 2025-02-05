<?php 
global $user_ID, $post;

um_fetch_user( $user_ID );

date_default_timezone_set("Asia/Manila");
?>
<style type="text/css">

	.um-activity-widget.um-activity-new-clone.unready {
		position: relative;
		pointer-events: none;
	}
	.um-activity-widget.um-activity-new-clone.unready > :not(.arbitrage-wall-post-loader) {
		opacity: 0.5;
	}
	.um-activity-widget.um-activity-new-clone.unready > .arbitrage-wall-post-loader {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		width: 50px;
		z-index: 2;
	}
	.um-activity-widget:not(.unready) > .arbitrage-wall-post-loader {
		display: none;
	}
</style>

<script type="text/template" id="tmpl-um-activity-widget">

	<div class="um-activity-widget um-activity-new-clone unready hala-clone" id="postid-{{{data.post_id}}}">

		<img class="arbitrage-wall-post-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" alt="loading post">

		<div class="um-activity-head">

			<div class="um-activity-left um-activity-author">

				<div class="um-activity-ava">

					<a href="<?php echo esc_attr( um_user_profile_url() ); ?>">

						<?php echo get_avatar( um_user( 'ID' ), 80 ); ?>

					</a>

				</div>

				<div class="um-activity-author-meta">

					<div class="um-activity-author-url">

						<a href="<?php echo esc_attr( um_user_profile_url() ); ?>" class="um-link">

							<?php echo um_user( 'display_name', 'html' ); ?>

						</a>

						<# if ( data.wall_id != data.user_id && data.wall_id && data.user_id ) { #>

							<i class="um-icon-forward"></i>

							<a href="{{{data.wall_user_url}}}" class="um-link">

								{{{data.wall_user_name}}}

							</a>

						<# } #>

					</div>

					<span class="um-activity-metadata">

						<a href="{{{data.post_url}}}"><?php _e( 'Just now', 'um-activity' ); ?></a>

					</span>

				</div>

			</div>



			<div class="um-activity-right">



				<?php if ( is_user_logged_in() ) { ?>



					<a href="#" class="um-activity-ticon um-activity-start-dialog" data-role="um-activity-tool-dialog"><i class="fas fa-ellipsis-h drop-over-post"></i></a>



					<div class="um-activity-dialog um-activity-tool-dialog">



						<a href="javascript:void(0);" class="um-activity-manage"><?php _e('Edit','um-activity'); ?></a>



						<a href="javascript:void(0);" class="um-activity-trash" data-msg="<?php _e('Are you sure you want to delete this post?','um-activity'); ?>"><?php _e('Delete','um-activity'); ?></a>



					</div>



				<?php } ?>



			</div>



			<div class="um-clear"></div>



		</div>



		<div class="um-activity-body">



			<div class="um-activity-bodyinner <# if ( data.video ) { #>has-embeded-video<# } #><# if ( data.oembed ) { #> has-oembeded<# } #>">



				<div class="um-activity-bodyinner-edit">

					<textarea style="display:none!important">{{{data.content}}}</textarea>

					<input type="hidden" name="_photo" value="{{{data.img_src}}}" />

					<input type="hidden" name="_photo_url" value="{{{data.img_src_url}}}" />

				</div>



				<# if ( data.content.trim().length > 0 ) { #>

				<div class="um-activity-bodyinner-txt">
					{{{data.content}}}
				</div>

				<# } #>

				<# if ( data.photo ) { #>

				<div class="um-activity-bodyinner-photo">

					<a href="#" class="um-photo-modal" data-src="{{{data.img_src_url}}}">

						<img src="{{{data.img_src_url}}}" alt="" />

					</a>

				</div>

				<# } #>



				<div class="um-activity-bodyinner-video">

					{{{data.video_content}}}

				</div>

			</div>



		</div>

		<?php

			$numbullish = UM()->Activity_API()->api()->get_bullish_number( $post->ID );

			$numbear = UM()->Activity_API()->api()->get_bearish_number( $post->ID );

		?>

		<div class="um-activity-foot status" id="wallcomments-{{{data.post_id}}}">

			<div class="um-activity-left um-activity-actions">



				<div class="um-activity-bullish <?php echo (UM()->Activity_API()->api()->user_is_bullish($post->ID) ? 'active' : '') ?>" data-numbull="<?php echo $numbullish; ?>">

					<a href="#">

						<span class="diconbase"><img src="/assets/svg/ico_bullish_no_ring.svg"></span>

						<span class="dnumof"><?php echo $numbullish; ?></span>

					</a>

				</div>

				<div class="um-activity-bearish <?php echo (UM()->Activity_API()->api()->user_is_bearish($post->ID) ? 'active' : '') ?>" data-numbear="<?php echo $numbear; ?>">

					<a href="#">

						<span class="diconbase"><img src="/assets/svg/ico_bearish_no_ring.svg"></span>

						<span class="dnumof"><?php echo $numbear; ?></span>

					</a>

				</div>
			

			
				

			</div>
			<!-- <div class="um-clear"></div> -->
			<hr class="style14 style11">
		</div>

		<div class="um-activity-comments">



			<?php if ( is_user_logged_in() && UM()->Activity_API()->api()->can_comment() ) { //hidden comment area for clone ?>



				<div class="um-activity-commentl um-activity-comment-area">

					<div class="um-activity-comment-avatar">

						<?php echo get_avatar( get_current_user_id(), 80 ); ?>

					</div>

					<div class="um-activity-comment-box" >

						<textarea class="um-activity-comment-textarea"

						          data-replytext="<?php esc_attr_e('Write a reply...','um-activity'); ?>"

						          data-reply_to="0"

						          placeholder="<?php esc_attr_e('Write a comment...','um-activity'); ?>"></textarea>
						

					</div>

					<div class="um-activity-right">

						<a href="javascript:void(0);" class="um-button um-activity-comment-post um-disabled">

							<?php _e( 'Comment', 'um-activity' ); ?>

						</a>

					</div>



					<div class="um-clear"></div>

				</div>



			<?php } ?>



			<div class="um-activity-comments-loop"></div>



		</div>



	</div>

</script>





<script type="text/template" id="tmpl-um-activity-post">

	<div class="um-activity-bodyinner <# if ( data.video ) { #>has-embeded-video<# } #><# if ( data.oembed ) { #> has-oembeded<# } #>">

		<div class="um-activity-bodyinner-edit">

			<textarea style="display:none!important">{{{data.content}}}</textarea>

			<input type="hidden" name="_photo" value="{{{data.img_src}}}" />

			<input type="hidden" name="_photo_url" value="{{{data.img_src_url}}}" />

		</div>



		<# if ( data.content.trim().length > 0 ) { #>

			<div class="um-activity-bodyinner-txt">
				<div class="dcontent-wrap">{{{data.content}}}
				</div>
			</div>

		<# } #>



		<# if ( data.photo ) { #>

		<div class="um-activity-bodyinner-photo">

			<a href="#" class="um-photo-modal" data-src="{{{data.img_src_url}}}">

				<img src="{{{data.img_src_url}}}" alt="" />

			</a>

		</div>

		<# } #>



		<div class="um-activity-bodyinner-video">

			{{{data.video_content}}}

		</div>

	</div>

</script>





<script type="text/template" id="tmpl-um-activity-comment">



	<div class="um-activity-commentwrap" data-comment_id="{{{data.comment_id}}}">



		<div class="um-activity-commentl um-activity-commentl-clone unready" id="commentid-{{{data.comment_id}}}">



			<?php if ( is_user_logged_in() ) { ?>

				<# if ( ! data.user_hidden ) { #>

					<a href="javascript:void(0);" class="um-activity-comment-hide um-tip-s" title="<?php esc_attr_e('Hide','um-activity'); ?>">

						<i class="um-icon-close-round"></i>

					</a>

				<# } #>

			<?php } ?>



			<div class="um-activity-comment-avatar hidden-{{{data.user_hidden}}}">

				<a href="<?php echo esc_attr( um_user_profile_url() ); ?>">

					<?php echo get_avatar( get_current_user_id(), 80 ); ?>

				</a>

			</div>



			<div class="um-activity-comment-hidden hidden-{{{data.user_hidden}}}">

				<?php _e('Comment hidden. <a href="javascript:void(0);" class="um-link">Show this comment</a>','um-activity' ); ?>

			</div>



			<div class="um-activity-comment-info hidden-{{{data.user_hidden}}}">

				<div class="um-activity-comment-data">

					<span class="um-activity-comment-author-link">

						<a href="<?php echo esc_attr( um_user_profile_url() ); ?>" class="um-link">

							<?php echo um_user('display_name'); ?>

						</a>

					</span>

					
					<span class="um-activity-comment-text" >{{{data.comment}}}</span>


					<textarea id="um-activity-reply-{{{data.comment_id}}}" class="original-content" style="display:none!important">{{{data.comment}}}</textarea>

				</div>

				<div class="um-activity-comment-meta">

					<?php if ( is_user_logged_in() ) { ?>

						<span>

							<a href="javascript:void(0);" class="um-link um-activity-comment-like"

							   data-like_text="<?php esc_attr_e( 'Like','um-activity' ); ?>"

							   data-unlike_text="<?php esc_attr_e('Unlike','um-activity'); ?>">

								<?php _e('Like','um-activity'); ?>

							</a>

						</span>



						<?php if ( UM()->Activity_API()->api()->can_comment() ) { ?>

							<span>

								<a href="javascript:void(0);" class="um-link um-activity-comment-reply" data-commentid="{{{data.comment_id}}}">

									<?php _e('Reply','um-activity'); ?>

								</a>

							</span>

						<?php } ?>


						<# if ( data.can_edit_comment ) { #>

						<span class="um-activity-editc">

							<a href="javascript:void(0);" style="font-size: 12px; color: #6583A8;" >Edit</a>

							<span class="um-activity-editc-d">

								<a href="javascript:void(0);" class="edit" data-commentid="{{{data.comment_id}}}"><?php _e('Edit','um-activity'); ?></a>

								<a href="javascript:void(0);" class="delete" data-msg="<?php _e('Are you sure you want to delete this comment?','um-activity'); ?>">

									<?php _e('Delete','um-activity'); ?>

								</a>

							</span>

						</span>

						<# } #>




						<span>

							<a href="{{{data.permalink}}}" class="um-activity-comment-permalink">

								<!-- {{{data.time}}} -->
								Just Now

							</a>

						</span>


						

					<?php } ?>

				</div>

			</div>

		</div>

	</div>

</script>





<script type="text/template" id="tmpl-um-activity-comment-edit">

	<div class="um-activity-commentl um-activity-comment-area" style="padding-top:0;padding-left:0;">

		<div class="um-activity-comment-box">

			<textarea class="um-activity-comment-textarea" data-commentid="{{{data.comment_id}}}" data-reply_to="{{{data.reply_to}}}"

			          placeholder="<?php esc_attr_e('Write a comment...','um-activity'); ?>">{{{data.comment}}}</textarea>	
		</div>

		<div class="um-activity-right">

			<a href="javascript:void(0);" class="um-activity-comment-edit-cancel">

				<?php _e( 'Cancel editing', 'um-activity' ); ?>

			</a>

			<a href="javascript:void(0);" class="um-button um-activity-comment-post um-disabled">

				<?php _e( 'Update', 'um-activity' ); ?>

			</a>

		</div>



		<div class="um-clear"></div>

	</div>







	<div class="um-activity-commentwrap" data-comment_id="{{{data.comment_id}}}">



		<div class="um-activity-commentl um-activity-commentl-clone unready" id="commentid-{{{data.comment_id}}}">



			<?php if ( is_user_logged_in() ) { ?>

				<# if ( ! data.user_hidden ) { #>

					<a href="javascript:void(0);" class="um-activity-comment-hide um-tip-s" title="<?php esc_attr_e('Hide','um-activity'); ?>">

						<i class="um-icon-close-round"></i>

					</a>

				<# } #>

			<?php } ?>



			<div class="um-activity-comment-avatar hidden-{{{data.user_hidden}}}">

				<a href="<?php echo esc_attr( um_user_profile_url() ); ?>">

					<?php echo get_avatar( get_current_user_id(), 80 ); ?>

				</a>

			</div>



			<div class="um-activity-comment-hidden hidden-{{{data.user_hidden}}}">

				<?php _e('Comment hidden. <a href="javascript:void(0);" class="um-link">Show this comment</a>','um-activity' ); ?>

			</div>



			<div class="um-activity-comment-info hidden-{{{data.user_hidden}}}">

				<div class="um-activity-comment-data">

					<span class="um-activity-comment-author-link">

						<a href="<?php echo esc_attr( um_user_profile_url() ); ?>" class="um-link">

							<?php echo um_user('display_name'); ?>

						</a>

					</span>

					<span class="um-activity-comment-text">{{{data.comment}}}</span>

					<textarea id="um-activity-reply-{{{data.comment_id}}}" class="original-content" style="display:none!important">{{{data.comment}}}</textarea>

				</div>

				<div class="um-activity-comment-meta">

					<?php if ( is_user_logged_in() ) { ?>

						<span>

							<a href="javascript:void(0);" class="um-link um-activity-comment-like"

							   data-like_text="<?php esc_attr_e( 'Like','um-activity' ); ?>"

							   data-unlike_text="<?php esc_attr_e('Unlike','um-activity'); ?>">

								<?php _e('Like','um-activity'); ?>

							</a>

						</span>



						<?php if ( UM()->Activity_API()->api()->can_comment() ) { ?>

							<span>

								<a href="javascript:void(0);" class="um-link um-activity-comment-reply" data-commentid="{{{data.comment_id}}}">

									<?php _e('Reply','um-activity'); ?>

								</a>

							</span>

						<?php } ?>


						<# if ( data.can_edit_comment ) { #>

						<span class="um-activity-editc">

							<a href="javascript:void(0);" style="font-size: 12px; color: #6583A8;">Edit</a>

							<span class="um-activity-editc-d">

								<a href="javascript:void(0);" class="edit"><?php _e('Edit','um-activity'); ?></a>

								<a href="javascript:void(0);" class="delete" data-msg="<?php _e('Are you sure you want to delete this comment?','um-activity'); ?>">

									<?php _e('Delete','um-activity'); ?>

								</a>

							</span>

						</span>

						<# } #>



						<span>

							<a href="{{{data.permalink}}}" class="um-activity-comment-permalink">

								<!-- {{{data.time}}} -->
								Just Now

							</a>

						</span>



					

					<?php } ?>

				</div>

			</div>

		</div>

	</div>

</script>





<script type="text/template" id="tmpl-um-activity-reply">

	<div class="um-activity-commentl um-activity-comment-area">

		<div class="um-activity-comment-avatar">

			<?php echo get_avatar( get_current_user_id(), 80 ); ?>

		</div>

		<div class="um-activity-comment-box">

			<textarea class="um-activity-comment-textarea"

			          data-reply_to="{{{data.replyto}}}"

			          placeholder="<?php esc_attr_e( 'Write a reply...', 'um-activity' ); ?>"></textarea>
			<div class="comment_tag_{{{data.replyto}}}"></div>
			
		</div>

		<div class="um-activity-right">

			<a href="javascript:void(0);" class="um-button um-activity-comment-post um-disabled">

				<?php _e( 'Reply', 'um-activity' ); ?>

			</a>

		</div>

		<div class="um-clear"></div>

	</div>

</script>


<script type="text/template" id="tmpl-um-activity-comment-reply">

	<div class="um-activity-commentl is-child" id="commentid-{{{data.comment_id}}}">



		<?php if ( is_user_logged_in() ) { ?>

			<# if ( ! data.user_hidden ) { #>

				<a href="javascript:void(0);" class="um-activity-comment-hide um-tip-s" title="<?php esc_attr_e('Hide','um-activity'); ?>">

					<i class="um-icon-close-round"></i>

				</a>

			<# } #>

		<?php } ?>



		<div class="um-activity-comment-avatar hidden-{{{data.user_hidden}}}">

			<a href="<?php echo esc_attr( um_user_profile_url() ); ?>">

				<?php echo get_avatar( get_current_user_id(), 80 ); ?>

			</a>

		</div>



		<div class="um-activity-comment-hidden hidden-{{{data.user_hidden}}}">

			<?php _e('Reply hidden. <a href="javascript:void(0);" class="um-link">Show this reply</a>','um-activity' ); ?>

		</div>



		<div class="um-activity-comment-info hidden-{{{data.user_hidden}}}">

			<div class="um-activity-comment-data">

				<span class="um-activity-comment-author-link"><a href="<?php echo um_user_profile_url(); ?>" class="um-link"><?php echo um_user('display_name'); ?></a></span> <span class="um-activity-comment-text">{{{data.comment}}}</span>

				<textarea id="um-activity-reply-{{{data.comment_id}}}" class="original-content" style="display:none!important">{{{data.comment}}}</textarea>

			</div>

			<div class="um-activity-comment-meta">

				<?php if ( is_user_logged_in() ) { ?>

					<span>

						<# if ( data.user_liked_comment ) { #>

							<a href="javascript:void(0);" class="um-link um-activity-comment-like active" data-like_text="<?php _e('Like','um-activity'); ?>" data-unlike_text="<?php _e('Unlike','um-activity'); ?>">

								<?php _e('Unlike','um-activity' ); ?>

							</a>

						<# } else { #>

							<a href="javascript:void(0);" class="um-link um-activity-comment-like" data-like_text="<?php _e('Like','um-activity'); ?>" data-unlike_text="<?php _e('Unlike','um-activity'); ?>">

								<?php _e('Like','um-activity' ); ?>

							</a>

						<# } #>

					</span>

					<span class="um-activity-comment-likes count-{{{data.likes}}}">

						<a href="#">

							<i class="um-faicon-thumbs-up"></i>

							<ins class="um-activity-ajaxdata-commentlikes">{{{data.likes}}}</ins>

						</a>

					</span>

				<?php } ?>


				<# if ( data.can_edit_comment ) { #>

					<span class="um-activity-editc"><a href="javascript:void(0);" style="font-size: 12px; color: #6583A8;" >Edit</a>

						<span class="um-activity-editc-d">

							<a href="javascript:void(0);" class="edit" data-commentid="{{{data.comment_id}}}"><?php _e('Edit','um-activity'); ?></a>

							<a href="javascript:void(0);" class="delete" data-msg="<?php _e('Are you sure you want to delete this comment?','um-activity'); ?>">

								<?php _e('Delete','um-activity'); ?>

							</a>

						</span>

					</span>

				<# } #>




				<span>

					<a href="{{{data.permalink}}}" class="um-activity-comment-permalink">

						<!-- {{{data.time}}} -->
						Just Now

					</a>

				</span>
				

			</div>

		</div>

	</div>

</script>

