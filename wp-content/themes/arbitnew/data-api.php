<?php 
/*
	* Template Name: Data API Page
*/

return new WP_REST_Response(is_user_logged_in());
?>