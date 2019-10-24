jQuery(document).ready(function(e) {
    // jQuery(".um-activity-new-post .um-activity-body .um-activity-textarea").append('<img class="arb_newpostimg" src="<?php 
    // echo esc_url( get_avatar_url( $user->ID ) ); ?>" alt="<?php echo ucfirst(um_user('first_name')); ?>">')
    jQuery("#et-main-area").click(function(e){
        jQuery(".dropdown_tools, .dropdown_user").hide('slow');	
    });

    $(".ms-ctn .ms-sel-ctn").append("<i class='fas fa-search'></i>");



    
    
});

jQuery(document).ready(function(){
    jQuery('.um-icon-android-close').addClass('fas fa-times');
    jQuery('.um-icon-android-close').removeClass('um-icon-android-close');
});

jQuery(document).ready(function(e) {
    jQuery(".inner-seatch input[type='text']").val("Search");
    jQuery(".inner-seatch input[type='text']").click(function(s){
        s.preventDefault();
        jQuery(".inner-seatch input[type='text']").val("");
        jQuery(".searchbar").animate({
            width: "75%"
        },500);
        jQuery("i.fa.fa-search").animate({
            right: "8px",
        },500);
    });

    jQuery(".inner-seatch input[type='text']").blur(function(){
        jQuery(".searchbar").animate({
            width: "180px"
        },500);
        jQuery("i.fa.fa-search").animate({
            right: "88%"
        },500, function(){
            jQuery(".inner-seatch input[type='text']").val("Search");
        });
    });

});

jQuery("ul.main-drop .main-user-name").click(function(e){
    event.stopPropagation();
    var isopen = jQuery("ul.main-drop > ul").hasClass("dropopen");

    if (isopen) {
        jQuery("ul.main-drop > ul").hide().removeClass("dropopen");
    } else {
        jQuery("ul.main-drops > ul").hide().removeClass("dropopen");
        jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hide().removeClass("dropopen");
        jQuery("ul.main-drop > ul").show().addClass("dropopen");
    }

});

jQuery("ul.main-drops .main-user-name").click(function(e){
    event.stopPropagation();
    var isopen = jQuery("ul.main-drops > ul").hasClass("dropopen");

    if (isopen) {
        jQuery("ul.main-drops > ul").hide().removeClass("dropopen");

    } else {
        jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hide().removeClass("dropopen");
        jQuery("ul.main-drop > ul").hide().removeClass("dropopen");
        jQuery("ul.main-drops > ul").show().addClass("dropopen");
    }

});

jQuery(".ontomitif").click(function(e){
    event.stopPropagation();
    var isopen = jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hasClass("dropopen");
    if (isopen) {
        jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hide().removeClass("dropopen");
    } else {
        jQuery("ul.main-drop > ul").hide().removeClass("dropopen");
        jQuery("ul.main-drops > ul").hide().removeClass("dropopen");
        jQuery(".opennotification .notifinnerbase").empty();
        jQuery(".um-notification-live-feed").clone().appendTo(".opennotification .notifinnerbase");
        jQuery(".opennotification .notifinnerbase .um-notification-live-feed").show().addClass("dropopen");
        jQuery('.um-notification').on('click', function() {
            var notification_uri = jQuery(".um-notification").attr("data-notification_uri");
            console.log(notification_uri)
            if ( notification_uri ) {

                window.location = notification_uri;
            }
        });
        jQuery('.um-notification-hide, .um-notification-hide a, .um-notification-hide i, .um-notification-hide i:before').on('click', function() {
            event.preventDefault();
        });

        jQuery(".um-notification span.b2 .um-faicon-thumbs-up").append('<img src="/assets/svg/ico_bullish_no_ring_notification.svg">');
        jQuery(".um-notification span.b2 .um-faicon-thumbs-up").removeClass();
        jQuery(".um-notification span.b2 .um-faicon-thumbs-up").empty();

        jQuery(".um-notification span.b2 .um-faicon-thumbs-down").append('<img src="/assets/svg/ico_bearish_no_ring_notification.svg">');
        jQuery(".um-notification span.b2 .um-faicon-thumbs-down").removeClass();
        jQuery(".um-notification span.b2 .um-faicon-thumbs-down").empty();
}
    //
    // var dnotifs =
    // $(".notifinnerbase").append('');

});


jQuery(document).on("click", function () {
    jQuery("ul.main-drop > ul").hide().removeClass("dropopen");
    jQuery("ul.main-drops > ul").hide().removeClass("dropopen");
    jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hide().removeClass("dropopen");
});

jQuery(document).ready(function(){
    jQuery(".seven.calc-menu-buysell, ul.main-drops > ul li:first-child").on("click", function () {
        event.stopPropagation();
        var openthis = jQuery("#showplease").hasClass("dropthiss");
        if ( openthis ) {
            jQuery("#toghandle").hide().removeClass("dropthiss");
        } else {
            jQuery("#toghandle").show().addClass("dropthiss");
        }
    });
    jQuery(".seven.calc-menu-var, ul.main-drops > ul li:nth-child(2)").on("click", function () {
        event.stopPropagation();
        jQuery("#toghandlings").show().addClass("dropthiss");

    });
    jQuery(".seven.calc-menu-avprice, ul.main-drops > ul li:nth-child(3)").on("click", function () {
        event.stopPropagation();
        jQuery("#toghandlingers").show().addClass("dropthiss");
    });
    jQuery(".toclassclose").on('click', function(){
        jQuery("#toghandle").hide().removeClass("dropthiss");
    });
    jQuery(".toclassclosess").on('click', function(){
        jQuery("#toghandlings").hide().removeClass("dropthiss");
    });
    jQuery(".toclasscloserss").on('click', function(){
        jQuery("#toghandlingers").hide().removeClass("dropthiss");
    });
});
$(window).bind("resize", function () {
    viewHeight = $(window).height();
    viewWidth = $(window).width();
    if (viewWidth < 500) {
        $("#vyndue--link").attr('href', '');
    }

}).trigger("resize");

jQuery("body").on('DOMSubtreeModified', ".um-notification-live-count.counter", function(event) {
    
    var counter = parseInt($(event.target));
    jQuery(".um-notification-live-count.counter").empty();
    // $(".um-notification-live-count.countx_max").empty();
    if (counter >= 9){
        jQuery('.um-notification-live-count.countx_max').html("9+");
    }
    // var counter = count = $(".um-notification-live-count.counter").empty();
    // var numbercount = '10';
    // var count = counter;
});
