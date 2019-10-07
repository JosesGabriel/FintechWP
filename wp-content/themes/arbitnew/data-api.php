<?php 
/*
	* Template Name: Data API Page
*/

function GetDataApiAuthorization(){
	return "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjbGllbnRfbmFtZSI6IjRSQjErUjQ5MyJ9.SZzdF4-L3TwqaGxfb8sR-xeBWWHmGyM4SCuBc1ffWUs";
}

function GetDataApiUrl(){
	return "https://data-api.arbitrage.ph";
}

function GetCurrentUser(){
	$currentUser = wp_get_current_user();
	return json_encode([
		"is_user_login" => is_user_logged_in(),
		"user_id" => $currentUser->ID,
	]);
}
?>