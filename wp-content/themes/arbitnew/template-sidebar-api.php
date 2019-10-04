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
  case 'trendingstocks':
      get_trendingstocks();
      break;
  case 'sidebar-bulletin':
      get_bulletins();
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
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, 'https://arbitrage.ph/wp-json/data-api/v1/stocks/list');
      curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $gerdqoute = curl_exec($curl);
      curl_close($curl);
      $gerdqoute = json_decode($gerdqoute);
      $adminuser = 504; // store on the chart page
      if ($gerdqoute) {
        $listofstocks = [];
        foreach ($gerdqoute->data as $dlskey => $dlsvalue) {
          $indls = [];
          $indls['stock'] = $dlskey;
          $dstocknamme = $dlskey;
          $dstocks = $dlsvalue->description;
          $indls['stnamename'] = $dstocks;
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
        $maxitems = 10;
        $finaltopstocks = [];
        foreach ($drevdds as $fnskey => $fnsvalue) {
          if ($fnskey + 1 > $maxitems) {
            break;
          }
          array_push($finaltopstocks, $fnsvalue);

        }
        echo json_encode($finaltopstocks);
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




 ?>
