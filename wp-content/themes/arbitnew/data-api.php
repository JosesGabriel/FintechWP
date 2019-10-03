<?php 
/*
	* Template Name: Data API Page
*/

header('Content-Type: application/json');

$currentUser = wp_get_current_user();
echo json_encode([
	"is_user_login" => is_user_logged_in(),
	"user_id" => $currentUser->ID,
]);

?>