jQuery(document).ready(function(e) {
    // jQuery(".um-activity-new-post .um-activity-body .um-activity-textarea").append('<img class="arb_newpostimg" src="<?php 
    // echo esc_url( get_avatar_url( $user->ID ) ); ?>" alt="<?php echo ucfirst(um_user('first_name')); ?>">')
    jQuery("#et-main-area").click(function(e){
        jQuery(".dropdown_tools, .dropdown_user").hide('slow');	
    });
});