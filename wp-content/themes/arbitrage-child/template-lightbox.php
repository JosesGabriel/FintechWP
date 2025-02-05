<?php
	/*
	* Template Name: Lightbox Page
	*/ 

?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php the_title(); ?></title>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,900&display=swap" rel="stylesheet">
<style>
	html, body {
		background: #0d1f33 !important;
		color: #d8d8d8;
		font-size: 13px;
		line-height: 150%;
		font-family: 'Roboto', sans-serif;
	}
	a {
		color: #fff;
		text-decoration: none;
	}
	a:hover {
		color: #fff;
		text-decoration: underline;
	}
	h4 {
		font-size: 16px;
		color: #fff;
	}
</style>
</head>

<body>
	<div style="padding: 0 15px">

		 <!-- Start the Loop. -->
		 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<!-- Test if the current post is in category 3. -->
			<!-- If it is, the div box is given the CSS class "post-cat-three". -->
			<!-- Otherwise, the div box is given the CSS class "post". -->

			<?php if ( in_category( '3' ) ) : ?>
				<div class="post-cat-three">
			<?php else : ?>
				<div class="post">
			<?php endif; ?>


			<!-- Display the Title as a link to the Post's permalink. -->

			<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>


			<!-- Display the date (November 16th, 2009 format) and a link to other posts by this posts author. -->

			<small><?php the_time('F jS, Y'); ?> by <?php the_author_posts_link(); ?></small>


			<!-- Display the Post's content in a div box. -->

			<div class="entry">
				<?php the_content(); ?>
			</div>


			<!-- Display a comma separated list of the Post's Categories. -->
			</div> <!-- closes the first div box -->


			<!-- Stop The Loop (but note the "else:" - see next line). -->

		 <?php endwhile; else : ?>


			<!-- The very first "if" tested to see if there were any Posts to -->
			<!-- display.  This "else" part tells what do if there weren't any. -->
			<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>


			<!-- REALLY stop The Loop. -->
		 <?php endif; ?>
		
	</div>
</body>
</html>
