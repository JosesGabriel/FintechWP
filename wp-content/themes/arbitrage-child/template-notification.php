<?php
	/*
	* Template Name: Notification Page
	* Template page for Search Page
	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
get_header( 'dashboard' );

date_default_timezone_set('Asia/Manila');

?>
<div class="notif_page_cont">
    <div class="inner-placeholder">
		<div class="inner-main-content">

            <div class="center-dashboard-part">
                <div class="inner-center-dashboard">
                    <div class="notif-cont">
                        <?php echo do_shortcode('[ultimatemember_notifications]'); ?>
                    </div>
                </div>
            </div>
            <div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">

					<?php get_template_part('parts/sidebar', 'traders'); ?>
					
					<?php get_template_part('parts/sidebar', 'footer'); ?>

				</div>
			</div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('.notif_page_cont .um-notifications-none').show();
        $('.notif_page_cont .um-notifications-none').appendTo('.notif_page_cont .um-notification-ajax');
        // $('.um-notification-ajax .um-notifications-none').remove();
        var hassclass = $('.notif_page_cont .um-notification-ajax div').hasClass('read, unread');
        if( hassclass ) {
            $('.notif_page_cont .um-notifications-none').hide();
        }
    });
</script>

<?php
get_footer();
?>