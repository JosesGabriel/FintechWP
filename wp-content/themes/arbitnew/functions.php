<?php

// wp-json end points
#include 'functions-api.php';
include 'functions-api-gateway.php';
include 'functions-accounts-api.php';
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

function registermoreusers() {
  global $wpdb;

  $user = get_user_by( 'email', $_POST['username-10'] );
    $userlogin = $user->user_login;
    $pass = $_POST['user_password-10'];

    // $userlogin = 'arphie';
    // $pass = 'admin123';

    $info = json_encode([
      'type' => "m.login.password",
      'identifier' => [
        'type' => 'm.id.user',
        'user' => $userlogin
      ],
      'password' => $pass
    ]);

  $guzzle = new GuzzleRequest();
    $dataUrl = GetDataApiUrl();
    $authorization = GetDataApiAuthorization();
    $request = $guzzle->request("POST", "https://im.arbitrage.ph/_matrix/client/r0/login", [
        "headers" => [
            "Content-type" => "application/json"
        ],
        "body" => $info
    ]);

    $gerdqoute = json_decode($request->content);
    if(isset($gerdqoute->errcode)){
      $regpeople = json_encode([
        'username' => $userlogin,
        'password' => $pass,
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
          "body" => $regpeople
      ]);
    } 
}
add_action('wp_login', 'registermoreusers');

?>
