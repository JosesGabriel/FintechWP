<?php
/*
* Template Name: Sidebar API
* Template page for SideBar API
*/
#require("wp-config.php");

header('Content-Type: application/json');
date_default_timezone_set("Asia/Manila");



$action = $_GET['daction'];

switch($action){
  case 'whotomingle':
      get_whotomingle();
  break;
  default:
  echo 'no action';
}

function get_whotomingle(){
    global $wpdb, $current_user;
    $userID = $current_user->ID;
    $newuserlist = array();

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $res = $conn->query("select * from arby_users where id not in (select distinct user_id1 from arby_um_friends where user_id2 = ".$userID." and status = 1) order by rand() limit 5");


    while($row = $res->fetch_assoc()){
      #print_r($row);
          $userdetails = [];
          $userdetails['currentuser'] = $userID;
          $userdetails['id'] = $row['ID'];
          $userdetails['displayname'] = $row['display_name'];
          $userdetails['user_nicename'] = $row['user_nicename'];
          $userdetails['profpic'] = esc_url( get_avatar_url( $row['ID'] ) );
          array_push($newuserlist, $userdetails);
    }
echo json_encode($newuserlist);

    /*foreach($rows as $key => $value){
      $userdetails = [];
      $userdetails['currentuser'] = $userID;
      $userdetails['id'] = $value->ID;
      $userdetails['displayname'] = $value->display_name;
      $userdetails['user_nicename'] = $value->user_nicename;
      $userdetails['profpic'] = esc_url( get_avatar_url( $value->ID ) );
      array_push($newuserlist, $userdetails);
    }
    echo json_encode($newuserlist);
*/
}

 ?>
