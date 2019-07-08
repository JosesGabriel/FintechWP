<?php /* Template Name: Sentiments */ ?>
<?php get_header(); ?>
<style type="text/css">
html, body, a, p, div {
    font-family: "Roboto", Arial !important;
}
header, footer {
	display:none;
}
div#page-container {
    padding: 0 !important;
    background-color: #2b3d4f;
}
.um-activity-confirm,
#wpadminbar {display:none !important;}
.lb-style-custom .lb-like {
	background-color:#25ae5f !important;
	padding: 2px 4px 2px 7px;
	margin-right:-2px !important;
	border: none !important;
    border-radius: 20px 0 0 20px;
}
.lb-style-custom .lb-dislike {
	background-color:#e64c3c !important;
	padding: 2px 7px;
	border: none !important;
    border-radius: 0 20px 20px 0;
}
.lb-like img {
	width:18px !important;
}
.lb-dislike img {
	width:14px !important;
}
.lb-like-label, .lb-dislike-label {
    padding: 0 2px 0 4px !important;
}
span.likebtn-label.lb-dislike-label,
span.likebtn-label.lb-like-label {
    display: none;
}
.lb-style-custom .lb-count {padding-left: 7px;}
</style>
<center><div style="color: #fff;font-weight: 400;font-size: 12px;">Register Your Sentiment for <?php the_title( '<span>', '</span>' ); ?></div>
<?php
while ( have_posts() ) : the_post();
	
	the_content();

endwhile;
?>
</center>
<?php get_footer();