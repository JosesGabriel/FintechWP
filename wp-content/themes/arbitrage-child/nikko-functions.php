<?php 
function wpb_search_filter( $query ) {
	if ( $query->is_search && !is_admin() )
		$query->set( 'cat','-5, -11' );
		return $query;
}
add_filter( 'pre_get_posts', 'wpb_search_filter' )
?>
