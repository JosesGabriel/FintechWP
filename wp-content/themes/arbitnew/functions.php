<?php

// wp-json end points
#include 'functions-api.php';
include 'functions-journalapi.php';
include 'functions-charts-api.php';
include 'functions-data-api.php';
include 'functions-arbitrage-api.php';
include 'functions-watchlist-api.php';
#include 'functions-accounts-api.php';
#include 'functions-social-api.php';
include 'functions-socket.php';
include 'functions-um.php';


function InitWidgets(){
  register_sidebar(array(
    'name' => 'Bulletin Sidebar',
    'id' => 'bulletin_sidebar'
  ));
}

add_action('widgets_init','InitWidgets');

?>
