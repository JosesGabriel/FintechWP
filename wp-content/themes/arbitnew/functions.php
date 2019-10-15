<?php

// wp-json end points
#include 'functions-api.php';
include 'functions-journalapi.php';
include 'functions-charts-api.php';
include 'functions-data-api.php';
include 'functions-arbitrage-api.php';
include 'functions-watchlist-api.php';
include 'functions-virtual-api.php';
#include 'functions-accounts-api.php';
#include 'functions-social-api.php';
include 'functions-socket.php';
include 'functions-um.php';
// include 'functions-hooks.php';


function InitWidgets(){
  register_sidebar(array(
    'name' => 'Bulletin Sidebar',
    'id' => 'bulletin_sidebar'
  ));
}

add_action('widgets_init','InitWidgets');


add_action('user_register', 'adduseronriot', 10, 1);
function adduseronriot($user_id)
{
    global $wpdb;

    $info = json_encode([
      'username' => $_POST['nickname-9'],
      'password' => $_POST['user_password-9'],
      'bind_email' => false,
      'auth' => ['type' => 'm.login.dummy'],
    ]);

    $guzzle = new GuzzleRequest();
    $dataUrl = GetDataApiUrl();
    $authorization = GetDataApiAuthorization();
    $request = $guzzle->request("POST", "https://im.arbitrage.ph/_matrix/client/r0/register?kind=user", [
        "headers" => [
            "Content-type" => "application/json"
        ],
        "body" => $info
    ]);
}

?>
