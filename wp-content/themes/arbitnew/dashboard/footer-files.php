<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>


<script type="text/javascript">
			jQuery(document).ready(function(){
				//jQuery('.um-activity-post').html('Post');
			});
</script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

        <script src="/wp-content/plugins/um-friends/assets/js/um-friends.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script> 
		<script src="<?php echo get_stylesheet_directory_uri(); ?>/dashboard/dashboard-scripts.js?<?php echo time(); ?>"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/parts.js?<?php echo time(); ?>"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/pages.js?<?php echo time(); ?>"></script>
        <?php wp_footer(); ?>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/lazyfunc.js?<?php echo time(); ?>"></script>
        <?php $user_id = get_current_user_id(); ?>
    </body>
</html>

<script>

(function ($) {
    var user_id = '<?php echo $user_id ?>'

    function add_loading_btn($btn) {
        $btn.append('&nbsp;<i class="fa fa-spinner fa-spin" style="margin: 0" aria-hidden="true"></i>')
    }

    function remove_loading_btn($btn) {
        $btn.find('i.fa').remove();
    }

    function wall_temporary_post(temporary_id, $form ) {
        var wall = $form.parents('.um').find('.um-activity-wall');

        widget_template = wp.template( 'um-activity-widget' );
        template_data = {
            'content'       : '<div class="desc-note">' + $form.find('[name="_post_content"]').val() + '</div>',
            'img_src'       : $form.find('input[name="_post_img"]').val(),
            'img_src_url'   : $form.find('input[name="_post_img_url"]').val(),
            'wall_id'       : $form.find('input[name="_wall_id"]').val(),
            'wall_user_name': $form.find('input[name="_wall_user_name"]').val(),
            'wall_user_url' : $form.find('input[name="_wall_user_url"]').val(),
            'user_id'       : user_id,
            'post_id'       : temporary_id,
            'post_url'      : '',
            'photo'         : ( $form.find('input[name="_post_img"]').val().trim().length > 0 ),
            'video'         : '',
            'video_content' : '',
            'oembed'        : '',
        };

        wall.prepend( widget_template( template_data ) );
    }

    function generateRandomString() {
        return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    }

    $(document).ready(function () {

        /**
         * Overrides the wall post submit function in
         * wp-content/plugins/um-social-activity/assets/js/um-activity.js line 407
         */
        $('.ondashboardpage').on('submit', '.um-activity-publish', function (e) {
            console.log("post submitted");
            e.stopPropagation();
            e.preventDefault();

            var form = $(this);
            var $btn = form.find('.um-activity-post');

            //focus on textarea if empty
            if ( form.find('textarea').val().trim().length === 0 && form.find('input[name="_post_img"]').val().trim().length === 0) {
                form.find('textarea').focus();
                return false;
            }

            um_disable_post_submit( form );

            var formdata = form.serializeArray();

            if (form.find('input[name="_post_id"]') . val() === '0') {
                var temp_id = generateRandomString()
                wall_temporary_post(temp_id, form)
            }

            var $new_post = form.parents('.um').find('.um-activity-wall #postid-' + temp_id)
            $.ajax({
                // url: wp.ajax.settings.url,
                url: 'wp-admin/admin-ajax.php',
                type: 'post',
                dataType: 'json',
                data: formdata,
                success: function( data ) {

                    var widget_template;
                    var template_data;

                    if ( form.find('input[name="_post_id"]').val() === '0' ) {
                        console.log("ed success");
                        var wall = form.parents('.um').find('.um-activity-wall');

                        widget_template = wp.template( 'um-activity-widget' );
                        template_data = {
                            'content'       : data.content,
                            'img_src'       : data.photo_gsc_url,
                            'img_src_url'   : data.photo_gsc_url,
                            'wall_id'       : data.wall_id,
                            'wall_user_name': data.wall_user_name,
                            'wall_user_url' : data.wall_user_url,
                            'user_id'       : data.user_id,
                            'post_id'       : data.postid,
                            'post_url'      : data.permalink,
                            'photo'         : ( form.find('input[name="_post_img"]').val().trim().length > 0 ),
                            'video'         : data.video || data.has_text_video,
                            'video_content' : data.video,
                            'oembed'        : data.has_oembed
                        };

                        // wall.prepend( widget_template( template_data ) );
                        $new_post.replaceWith( widget_template( template_data ) );
                        wall.find( '.unready' ).removeClass( 'unready um-activity-new-clone' ).fadeIn();

                        form.find('textarea').val('').height('auto');
                        um_clean_photo_fields( form );
                        um_post_placeholder( form.find( 'textarea' ) );

                        UM_wall_autocomplete_start();
                    } else {
                        form.parents('.um-activity-widget').removeClass( 'editing' );

                        widget_template = wp.template( 'um-activity-post' );
                        template_data = {
                            'content'       : data.content,
                            'img_src'       : data.photo_gsc_url,
                            'img_src_url'   : data.photo_gsc_url,
                            'wall_id'       : formdata._wall_id,
                            'wall_user_name': data.wall_user_name,
                            'wall_user_url' : data.wall_user_url,
                            'user_id'       : data.user_id,
                            'post_id'       : data.postid,
                            'post_url'      : data.permalink,
                            'photo'         : ( form.find('input[name="_post_img"]').val().trim().length > 0 ),
                            'video'         : data.video || data.has_text_video,
                            'video_content' : data.video,
                            'oembed'        : data.has_oembed
                        };

                        form.parents('.um-activity-body').html( widget_template( template_data ) );
                    }
                }
            });
        })
    });
    $('.opennotification').on('click', '.um-notification', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var $this = $(this);
        if (typeof $this.data('notification_uri') !== 'undefined') {
            window.location.href = $this.data('notification_uri')
        }
    });

})(jQuery)
</script>
