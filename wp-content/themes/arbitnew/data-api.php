<?php 
/*
	* Template Name: Data API Page
*/

function GetCurrentUser(){
	$currentUser = wp_get_current_user();
	return json_encode([
		"is_user_login" => is_user_logged_in(),
		"user_id" => $currentUser->ID,
	]);
}

?>