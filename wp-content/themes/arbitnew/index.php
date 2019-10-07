
<?php
    get_header();
    if ( have_posts() ) :
        /* Start the Loop */
        while ( have_posts() ) :
            the_post();
        endwhile;
    endif;
    get_footer();
?>

