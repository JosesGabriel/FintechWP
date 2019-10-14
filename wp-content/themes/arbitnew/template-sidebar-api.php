<?php
/*
* Template Name: Sidebar API
* Template page for SideBar API
*/
#require("wp-config.php");
require_once ('guzzle-class.php');
require_once ('data-api.php');


header('Content-Type: application/json');
date_default_timezone_set("Asia/Manila");
$action = $_GET['daction'];


switch($action){
  case 'whotomingle':
      get_whotomingle();
      break;
  case 'trendingstocks':
      get_trendingstocks();
      break;
  case 'sidebar-bulletin':
      get_bulletins();
      break;
  case 'get_user_metas':
      get_user_metas();
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
      mysqli_close($conn);
      echo json_encode($newuserlist);
}



function get_trendingstocks(){
      global $wpdb;
      $date = date('Y-m-d', time());

      $guzzle = new GuzzleRequest();
      $dataUrl = GetDataApiUrl();
      $authorization = GetDataApiAuthorization();
      // $request = $guzzle->request("GET", "{$dataUrl}/api/v1/stocks/list", [
      $request = $guzzle->request("GET", "{$dataUrl}/api/v1/stocks/history/latest?exchange=PSE", [
        "headers" => [
            "Content-type" => "application/json",
            "Authorization" => "Bearer {$authorization}",
            ]
       ]);
      $gerdqoute = json_decode($request->content);
      $adminuser = 504; // store on the chart page
      if ($gerdqoute) {
        $listofstocks = [];
        foreach ($gerdqoute->data as $dlskey => $dlsvalue) {
          $indls = [];
          // $indls['stock'] = $dlskey;
          $indls['stock'] = $dlsvalue->symbol;
          // $dstocknamme = $dlskey;
          $dstocknamme = $dlsvalue->symbol;
          $dstocks = $dlsvalue->description;
          $indls['stnamename'] = $dstocks;
          $indls['last'] =  $dlsvalue->last;
          $indls['change'] =  $dlsvalue->change;
          $dsprest = $wpdb->get_results( "SELECT * FROM arby_posts WHERE post_content LIKE '%$".strtolower($dstocknamme)."%' AND DATE(post_date) >= DATE_ADD(CURDATE(), INTERVAL -3 DAY)");
          $todayreps = 0; // today
          $countpstock = 0; // 3 days back
          $isbull = 0;
          foreach ($dsprest as $rsffkey => $rsffvalue) {
            $dcontent = $rsffvalue->post_content;
            if (strpos(strtolower($dcontent), '$'.strtolower($dstocknamme)) !== false) {
              if(date("Y-m-d", strtotime($rsffvalue->post_date)) == $date){
                $todayreps++;
              } else {
                $countpstock++;
              }
            }
          }
          $dpullbull = get_post_meta( $adminuser, '_sentiment_'.$dstocknamme.'_bull', true );
          $dpullbull = $dpullbull == '' ? 0 : $dpullbull;
          // 3 days back
          $threedays = ceil($countpstock * 0.2);
          $bulls = ceil($dpullbull * 0.3);
          $tags = ceil($todayreps * 0.6);
          $finalcount = $bulls + $threedays + $tags;
          $stocksscount = $countpstock + $dpullbull + $todayreps;
          $indls['following'] = $finalcount;
          if($finalcount > 0){
            array_push($listofstocks, $indls);
          }
        }
        usort($listofstocks, 'date_compare');
        $drevdds = array_reverse($listofstocks);
        $maxitems = 20;
        $finaltopstocks = [];
        foreach ($drevdds as $fnskey => $fnsvalue) {
          if ($fnskey + 1 > $maxitems) {
            break;
          }
          array_push($finaltopstocks, $fnsvalue);

        }
        echo json_encode($finaltopstocks);
        // echo json_encode($gerdqoute);
        die;
      } else {
        echo "no stock selected";
      }
}

function get_bulletins(){
  ob_start();
  dynamic_sidebar( 'Bulletin Sidebar' );
  $content = ob_get_contents();
  ob_end_clean();
  echo json_encode(['data' => $content, 'status' => 200, 'success' => true]);
}

function get_user_metas(){
  global $current_user;
  $userID = $current_user->ID;
  $ismetadis = get_user_meta($userID, '_watchlist_instrumental', true);
  echo json_encode($ismetadis);
}

function date_compare($a, $b)
{
  $t1 = $a['following'];
  $t2 = $b['following'];
  return $t1 - $t2;
}


?>
