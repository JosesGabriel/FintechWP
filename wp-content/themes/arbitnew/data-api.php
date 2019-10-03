<?php 
/*
	* Template Name: Data API Page
*/

echo json_encode([
	"is_user_login" => is_user_logged_in(),
	"user_id" => wp_get_current_user()["data"],
]);

?>