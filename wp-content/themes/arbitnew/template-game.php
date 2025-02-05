<?php
    /* Template Name: Trading Game */
    require("game/header-files.php");
    require("parts/global-header.php");
?>

    <?php get_template_part('parts/global', 'css'); ?>
    <?php get_template_part('parts/sidebar', 'calc'); ?>
    <?php get_template_part('parts/sidebar', 'varcalc'); ?>
    <?php get_template_part('parts/sidebar', 'avarageprice'); ?>
    <?php $secretid = get_user_meta($userID, 'user_secret', true); ?>
    
    <?php if ($secretid): ?>
        <div style="height:100%; width:100%; padding:46px 0 0 0">
            <object data="https://game.arbitrage.ph/game/playgame/<?php echo urlencode($secretid) ?>/<?php echo urlencode($user->display_name) ?>" style="width: 100%; height:100%" frameborder="0" />
        </div>
    <?php endif; ?>

<?php
    require("game/footer-files.php");
?>