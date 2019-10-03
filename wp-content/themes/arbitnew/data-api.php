<?php 
/*
	* Template Name: Data API Page
*/

echo json_encode([
	"isLoggedIn" => is_user_logged_in(),
	"data" => wp_get_current_user(),
]);

?>