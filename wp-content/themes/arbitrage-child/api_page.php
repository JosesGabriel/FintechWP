<?php
	/*
	* Template Name: API Page
	* Template page for Watchlist Page Platform
	*/

	// get_header();

	// define('WP_USE_THEMES', false);
	global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;
	require(getcwd().'/wp-load.php');

	date_default_timezone_set("Asia/Manila");

	global $current_user;
	$user = wp_get_current_user();

	date_default_timezone_set('Asia/Manila');
	$date = date('m/d/Y', time());

	$dreturn = "";
	$adminuser = 504; // store on the chart page

	if (isset($_GET['daction']) && $_GET['daction'] == 'watchlistval') { // watchlist get all stock prices
		$curl = curl_init();	
		curl_setopt($curl, CURLOPT_URL, 'https://api2.pse.tools/api/quotes' );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$dwatchinfo = curl_exec($curl);
		curl_close($curl);

		$genstockinfo = json_decode($dwatchinfo);
		$stockinfo = $genstockinfo->data;
		echo json_encode(["dinfo" => $stockinfo]);
	} elseif(isset($_GET['daction']) && $_GET['daction'] == 'sentiment'){ // market sentiment add sentiment
		
		if ($_GET['stock'] != 'chart') { // if chart page valid stock
			
			$dsentbear = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bear', true );
			$dsentbull = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bull', true );
			$dsentilist = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_list', true );
			$dsentdate = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_lastupdated', true );
			
			if ($dsentilist && is_array( $dsentilist ) && in_array( get_current_user_id(), $dsentilist )) {
				// do nothin
				$dreturn = "Cant vote!";
			} else{
				
				$dreturn = "Go for Vote ";
				// add sentiment points
				if ($_GET['dbuttonact'] == "bbs_bull") {
					$finalcount = ($dsentbull != "" ? $dsentbull : 0) + 1;
					update_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bull', $finalcount );
				} else {
					$finalcount = ($dsentbear != "" ? $dsentbear : 0) + 1;
					update_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bear', $finalcount );
				}
				

				// add user on the sentiment
				if (is_array($dsentilist)) {
					array_push($dsentilist, get_current_user_id());
				} else {
					$dsentilist = [get_current_user_id()];
				}
				$dlistofusers = array();
				
				
				// array_push($dsentilist, $dlistofusers);
				update_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_list', $dsentilist );

				// add date
				update_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_lastupdated', $date );
				$dreturn = "Success!";
			}

			// echo json_encode(["dinfo" => "you selected".$_GET['stock']]);
			
		} else {
			// echo json_encode(["dinfo" => "error: no stock was selected"]);
			$dreturn = "error: no stock was selected";
		}
		
		$dpullbear = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bear', true );
		$dpullbull = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bull', true );

		

		$dfinbear = $dpullbear + $_GET['dbasebear'];
		$dfinbull = $dpullbull + $_GET['dbasebull'];

		$dtotalall = $dfinbear + $dfinbull;

		$dpercbear = ($dfinbear / $dtotalall) * 100;
		$dpercbull = ($dfinbull / $dtotalall) * 100;

		// $dsentilist = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_list', true );
		// print_r($dsentilist);
		echo json_encode(['dbear' => $dpercbear, 'dbull' => $dpercbull, 'action' => $dreturn]);
		
	} elseif(isset($_GET['daction']) && $_GET['daction'] == 'testpage'){
		echo "this is a test";
		  	$the_site = "https://www.marketwatch.com/story/shocks-and-surprises-could-damage-all-major-economies-warns-swiss-hedge-fund-manager-2019-04-29?mod=hp_investing";
		    $the_tag = "div"; 
		    $the_class = "images";

		    $mypage = file_get_contents($the_site);
		    preg_match_all('/<img[^>]+>/i',$mypage,$srcs);

		    // $html = file_get_contents($the_site);
		 //    $curl = curl_init($the_site); 
			// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
			// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); 
			// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); 
			// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); 
			// $response_string = curl_exec($curl); 
			// $html = str_get_html($response_string);

			

		    // foreach ($html->find('img') as $item) {
		    //     // $img_src =  $item->getAttribute('src');
		    //     // print $img_src."\n";
		    //     echo $item->src . '<br>';
		    // }

			print_r($srcs[0]);
			foreach ($srcs[0] as $key => $value) {
				echo '<img src="'.$value.'" />';
			}


	} elseif(isset($_GET['daction']) && $_GET['daction'] == 'changeto'){
		$userid = get_current_user_id();
		if (isset($_GET['toname'])) {
			$todo = $_GET['toname'];
			
			update_user_meta($userid, 'disname', $todo);
			echo json_encode('success');
		} else {
			echo json_encode('success');
		}

		// echo get_user_meta($userid, 'disname', true);


	}elseif(isset($_GET['daction']) && $_GET['daction'] == 'notify_me_email'){
		global $wpdb;
        $str = stripslashes($_GET['email']);
        // $str = mysql_real_escape_string($str);
		$checkQuery = "SELECT * FROM arby_notifyme_emails where email like '$str'";
		$addQuery = "INSERT INTO `arby_notifyme_emails` (`id`, `email`, `created_at`) VALUES (NULL, '$str', NULL)";
		$exist = $wpdb->query($addQuery);
		print_r($addQuery);
		print_r($str);
		print_r($exist + '69');

	}else { // market sentiment : check sentiment
		$dlastupdate = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_lastupdated', true );

		
		
		$diffDays = 0;
		if ($dlastupdate != "") {
			$today = new DateTime(); // This object represents current date/time
			$today->setTime( 0, 0, 0 ); // reset time part, to prevent partial comparison

			$match_date = DateTime::createFromFormat( "m/d/Y", $dlastupdate );
			$match_date->setTime( 0, 0, 0 ); // reset time part, to prevent partial comparison

			$diff = $today->diff( $match_date );
			$diffDays = (integer)$diff->format( "%R%a" ); // Extract days count in interval
		}

		

		$dsentilist = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_list', true );
		// print_r($_GET['stock']);

		if ($diffDays < 0) {
			$dlistousers = array();
			$todaysdate = date("m/d/Y");

			update_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bear', 0 );
			update_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bull', 0 );
			update_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_list', $dlistousers );
			update_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_lastupdated', $todaysdate );

			$isvote = 0;

			// echo json_encode(["dbear" => 0, 'dbull' => 0, 'isvote' => $isvote, 'islastupdate' => $todaysdate]);


		} else {

			$dsentbear = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bear', true );
			$dsentbull = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bull', true );

			if ($dsentilist && is_array( $dsentilist ) && in_array( $user->ID, $dsentilist )) {
				$isvote = 1;
			} else {
				$isvote = 0;
			}
			
		}

		
		$dsentbear = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bear', true );
		$dsentbull = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bull', true );

		$totsbear = (int) ($dsentbear == "" ? 0 : $dsentbear) + $_GET['isbear'];
		$totsbull = (int) ($dsentbull == "" ? 0 : $dsentbull) + $_GET['isbull'];

		$totalitem = $totsbear + $totsbull;

		$bearperc = ($totsbear / $totalitem) * 100;
		$bullperc = ($totsbull / $totalitem) * 100;
		
		echo json_encode(["dbear" => number_format( $bearperc, 2, '.', ',' ), 'dbull' => number_format( $bullperc, 2, '.', ',' ), 'isvote' => $isvote, 'islastupdate' => $dlastupdate]);
		
	}

	
	

	// $totsbear = (int) ($dsentbear == "" ? 0 : $dsentbear) + $_GET['isbear'];
	// $totsbull = (int) ($dsentbull == "" ? 0 : $dsentbull) + $_GET['isbull'];

	// $totalitem = $totsbear + $totsbull;

	// $bearperc = ($totsbear / $totalitem) * 100;
	// $bullperc = ($totsbull / $totalitem) * 100;

	


?>