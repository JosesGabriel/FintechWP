<?php
	/*
	* Template Name: API Page
	* Template page for Watchlist Page Platform
	*/

	// get_header();

	// define('WP_USE_THEMES', false);
	// header('Content-Type: application/json');
	global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;
	require(getcwd().'/wp-load.php');

	date_default_timezone_set("Asia/Manila");

	global $current_user;
	$user = wp_get_current_user();

	date_default_timezone_set('Asia/Manila');
	$date = date('m/d/Y', time());


	// echo "user id: ".get_current_user_id();

	$dreturn = "";
	$adminuser = 504; // store on the chart page

	function gettrades($stockname){
		$dinfstock = strtoupper($stockname);

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://data-api.arbitrage.ph/api/v1/stocks/trades/latest?symbol=".$dinfstock."&exchange=PSE");
			curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.25.248.104']);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($curl);
			curl_close($curl);

			$trades = json_decode($response);
			$trades = $trades->data;
			

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE&symbol=".$dinfstock);
			curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.25.248.104']);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$getstocks = curl_exec($curl);
			curl_close($curl);

			$dstock = json_decode($getstocks);
			$dstock = $dstock->data;

			
			

			// get prices
			$listofprices = [];
			foreach ($trades as $key => $value) {
				array_push($listofprices, number_format($value->executed_price, 2, ".", ","));
			}
			$newpricelist = array_values(array_unique($listofprices));

			// get volumes
			$pricevols = [];
			foreach ($newpricelist as $pricekey => $pricevalue) {
				$intprice = [];
				$intprice['price'] = $pricevalue;
				// $intprice['volumes'] = [];
				$intprice['totalvolumes'] = 0;
				foreach ($trades as $gvkey => $gvvalue) {
					if($pricevalue == number_format($gvvalue->executed_price, 2, ".", ",")){
						// array_push($intprice['volumes'], round($gvvalue->executed_volume));
						$intprice['totalvolumes'] += round($gvvalue->executed_volume);
					}
				}
				array_push($pricevols, $intprice);
			}



			// sort as per bull / bear

			$dlast = $dstock->open;
			
			// echo  "Open: ".$dlast." | ";
		
			$isbullbear = [];
			$isbullbear['bear'] = [];
			$isbullbear['bull'] = [];
			foreach ($pricevols as $bbkey => $bbvalue) {
				$bbvalue['price'] = str_replace(",", "", $bbvalue['price']);
				if($bbvalue['price'] >= $dlast){
					array_push($isbullbear['bull'], $bbvalue);
				} else {
					array_push($isbullbear['bear'], $bbvalue);
				}
			}

			usort($isbullbear['bear'], function($a, $b) {
				return $a['price'] <=> $b['price'];
			});

			usort($isbullbear['bull'], function($a, $b) {
				return $b['price'] <=> $a['price'];
			});

			// print_r($isbullbear);

			$weight = [.90, .80, .70, .60, .50, .40, .30]; // the rest is 20%

			// compute bear/bull

			$totalbear = 0;
			foreach ($isbullbear['bear'] as $bearkey => $bearvalue) {
				// echo $bearvalue['totalvolumes']." - ".(isset($weight[$bearkey]) ? $weight[$bearkey] : 20)." / ".$bearvalue['totalvolumes'] * (isset($weight[$bearkey]) ? $weight[$bearkey] : .20)." | ";
				$totalbear += $bearvalue['totalvolumes'] * (isset($weight[$bearkey]) ? $weight[$bearkey] : 20);
			}

			$totalbull = 0;
			foreach ($isbullbear['bull'] as $bullkey => $bullvalue) {
				// echo $bullvalue['totalvolumes']." - ".(isset($weight[$bullkey]) ? $weight[$bullkey] : 20)." / ".$bullvalue['totalvolumes'] * (isset($weight[$bullkey]) ? $weight[$bullkey] : .20)." | ";
				$totalbull += $bullvalue['totalvolumes'] * (isset($weight[$bullkey]) ? $weight[$bullkey] : 20);
			}

			// get percentage

			$totalperc = $totalbear + $totalbull;

			$percbull = number_format(($totalbull / $totalperc) * 100, 2, ".", ",");
			$percbear = number_format(($totalbear / $totalperc) * 100, 2, ".", ",");

			// echo "Bull: ".$percbull . " ~ Bear : ". $percbear; 

			return json_encode(['bull' => $totalbull, 'bear' => $totalbear]);
	}

	if (isset($_GET['daction']) && $_GET['daction'] == 'watchlistval') { // watchlist get all stock prices
		$curl = curl_init();	
		#curl_setopt($curl, CURLOPT_URL, 'https://api2.pse.tools/api/quotes' );
		curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE' );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$dwatchinfo = curl_exec($curl);
		curl_close($curl);

		$genstockinfo = json_decode($dwatchinfo);
		$stockinfo = $genstockinfo->data;
		echo json_encode(["dinfo" => $stockinfo]);
	} elseif(isset($_GET['daction']) && $_GET['daction'] == 'sentimentbear'){ // market sentiment add sentiment
		
		
		if ($_GET['stock'] != 'chart') { // if chart page valid stock
			
			$dsentbear = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bear', true );
			$dsentbull = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bull', true );
			$dsentilist = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_list', true );
			$dsentdate = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_lastupdated', true );

			// echo $_GET['dbuttonact'];
			// exit;
			
			if ($dsentilist && is_array( $dsentilist ) && in_array( get_current_user_id(), $dsentilist )) {
				// do nothin
				$dreturn = "Cant vote!";
			} else{
				
				$dreturn = "Go for Vote ";
				// add sentiment points
				$whatchanged = "";
				// if (strtolower(strip_tags($_GET['dbuttonact'])) == "bbs_bull") {
				// 	$finalcount = ($dsentbull != "" ? $dsentbull : 0) + 1;
				// 	$dsentbull = ($dsentbull != "" ? $dsentbull : 0) + 1;
				// 	update_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bull', $finalcount );
				// 	$whatchanged = "bull";
				// } else {
					$finalcount = ($dsentbear != "" ? $dsentbear : 0) + 1;
					$dsentbear = ($dsentbear != "" ? $dsentbear : 0) + 1;
					update_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bear', $finalcount );
					$whatchanged = "bear";
				// }
				

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
		echo json_encode(['dbear' => $dpercbear, 'dbull' => $dpercbull, 'action' => $dreturn, 'whatchanged' => $whatchanged, 'stock' => $_GET['stock'], 'gbear' => $dsentbear, 'gbull' => $dsentbull]);
		
	} elseif(isset($_GET['daction']) && $_GET['daction'] == 'sentimentbull'){ // market sentiment add sentiment
		
		
		if ($_GET['stock'] != 'chart') { // if chart page valid stock
			
			$dsentbear = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bear', true );
			$dsentbull = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bull', true );
			$dsentilist = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_list', true );
			$dsentdate = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_lastupdated', true );

			// echo $_GET['dbuttonact'];
			// exit;
			
			if ($dsentilist && is_array( $dsentilist ) && in_array( get_current_user_id(), $dsentilist )) {
				// do nothin
				$dreturn = "Cant vote!";
			} else{
				
				$dreturn = "Go for Vote ";
				// add sentiment points
				$whatchanged = "";
				// if (strtolower(strip_tags($_GET['dbuttonact'])) == "bbs_bull") {
					$finalcount = ($dsentbull != "" ? $dsentbull : 0) + 1;
					$dsentbull = ($dsentbull != "" ? $dsentbull : 0) + 1;
					update_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bull', $finalcount );
					$whatchanged = "bull";
				// } else {
				// 	$finalcount = ($dsentbear != "" ? $dsentbear : 0) + 1;
				// 	$dsentbear = ($dsentbear != "" ? $dsentbear : 0) + 1;
				// 	update_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_bear', $finalcount );
				// 	$whatchanged = "bear";
				// }
				

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

		$dtradd = json_decode(gettrades($_GET['stock']));

		$dfinbear = $dpullbear + $_GET['dbasebear'];
		$dfinbull = $dpullbull + $_GET['dbasebull'];

		$dtotalall = $dfinbear + $dfinbull;

		$dpercbear = ($dfinbear / $dtotalall) * 100;
		$dpercbull = ($dfinbull / $dtotalall) * 100;

		// $dsentilist = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_list', true );
		// print_r($dsentilist);

		

		echo json_encode(['dbear' => $dpercbear, 'dbull' => $dpercbull, 'action' => $dreturn, 'whatchanged' => $dtradd, 'stock' => $_GET['stock'], 'gbear' => $dsentbear, 'gbull' => $dsentbull]);
		
	}  elseif(isset($_GET['daction']) && $_GET['daction'] == 'marketsentiment'){

			echo gettrades($_GET['stock']);

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
        $str = stripslashes($_POST['email']);
        // $str = mysql_real_escape_string($str);
		$checkQuery = "SELECT * FROM arby_notifyme_emails where email like '$str'";
		$addQuery = "INSERT INTO `arby_notifyme_emails` (`id`, `email`, `created_at`) VALUES (NULL, '$str', NULL)";
		$exist = $wpdb->query($addQuery);

	}elseif(isset($_GET['daction']) && $_GET['daction'] == 'userwatchlist'){
		global $wpdb;
		$users = get_users( array( 'fields' => array( 'ID' ) ) );
		$listofwatchlist = [];
		foreach($users as $user_id){
			$user_info = get_userdata($user_id->ID);
			$invito = [];
			$invito['userid'] = $user_id->ID;
			$invito['stocks'] = get_user_meta($user_id->ID, '_watchlist_instrumental', true);
			$invito['email'] = $user_info->user_email;
			array_push($listofwatchlist, $invito);
		}

		echo json_encode($listofwatchlist);
	} else { // market sentiment : check sentiment
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