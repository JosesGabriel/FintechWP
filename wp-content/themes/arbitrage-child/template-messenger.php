<?php /* Template Name: Vyndue Messenger */ ?>
<?php
    global $current_user;
    $user = wp_get_current_user();
    $userID = $current_user->ID;
    get_header("dashboard");
?>
<style>
html, body, #page-container {
    height: 100%;
}
body {overflow: hidden;}
.header-dashboard-inner {
    max-width: 100% !important;
    width: 100% !important;
	padding: 8px 10px 0 !important;
}
.et_fixed_nav #main-header, .et_fixed_nav #top-header {
    position: relative !important;
}
.paddzero {
    padding-top: 0 !important;
}
</style>
<?php get_template_part('parts/global', 'css'); ?>
<?php get_template_part('parts/sidebar', 'calc'); ?>
<?php get_template_part('parts/sidebar', 'varcalc'); ?>
<?php get_template_part('parts/sidebar', 'avarageprice'); ?>
<div class="paddzero" style="height:100%; width:100%; padding:46px 0 0 0">
    <iframe id="vyndue-iframe" src="https://vyndue.com/userview/logout" style="width: 100%; height:100%" frameborder="0"></iframe>
</div>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<script src="https://kit.fontawesome.com/250c8f69db.js"></script>
<script>

    function sendMessageToVyndueIframe(key, data) {
        var vyndue = document.getElementById('vyndue-iframe').contentWindow;
        vyndue.postMessage({
            key: key,
            data: data,
        }, '*');
    }

    jQuery(document).ready(function () {
        $(window).on("message", function(e) {

            var messageEvent = e.originalEvent;

            // not authorized
            if (messageEvent.origin != 'https://vyndue.com') {
                return;
            }
            
            var messageKey = messageEvent.data.key;

            // we then separate events by the data key

            if (messageKey == 'ready') {
                // get URL params 
                const urlparams = new URLSearchParams(window.location.search)
                sendMessageToVyndueIframe('query', urlparams.toString());
            }
            
        });
    });
</script>
<?php get_footer(); ?>