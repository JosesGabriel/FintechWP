<?php /* Template Name: Trading Game */ ?>
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
</style>
<?php get_template_part('parts/global', 'css'); ?>
<?php get_template_part('parts/sidebar', 'calc'); ?>
<?php get_template_part('parts/sidebar', 'varcalc'); ?>
<?php get_template_part('parts/sidebar', 'avarageprice'); ?>
<?php $secretid = get_user_meta($userID, 'user_secret', true); ?>
<?php if ($secretid): ?>
    <div style="height:100%; width:100%; padding:46px 0 0 0">
        <object data="https://game.arbitrage.ph/game/playgame/<?php echo $secretid; ?>/<?php echo $user->display_name ?>" style="width: 100%; height:100%" frameborder="0" />
    </div>
<?php endif; ?>

<?php get_footer(); ?>