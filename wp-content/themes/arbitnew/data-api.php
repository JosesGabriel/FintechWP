<?php 
/*
	* Template Name: Data API Page
*/

$currentUser = wp_get_current_user();
$data = json_encode([
	"is_user_login" => is_user_logged_in(),
	"user_id" => $currentUser->ID,
]);

return new WP_REST_Response($data, 200);
?>