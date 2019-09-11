<?php
	/*
	* Template Name: API Page
	* Template page for Watchlist Page Platform
	*/
	// get_header();

	// define('WP_USE_THEMES', false);
	header('Content-Type: application/json');
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
	function getpointtrades($stockname){
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

		
		$dlast = $dstock->open;

		$bulltrades = 0;
		$beartrades = 0;
		foreach ($trades as $key => $value) {
			if(number_format($value->executed_price, 4, ".", ",") > $dlast){
				$bulltrades++;
			} else {
				$beartrades++;
			}
		}

		return json_encode(['bear' => $beartrades, 'bull' => $bulltrades]);


	}
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

			
			$dlast = $dstock->open;

			// get prices
			$listofprices = [];
			foreach ($trades as $key => $value) {
				array_push($listofprices, number_format($value->executed_price, 2, ".", ","));
			}
			$newpricelist = array_values(array_unique($listofprices));

			$bullcounts = 0;
			$bearcounts = 0;
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

		$dtradd = json_decode(getpointtrades($_GET['stock']));

		$dfinbear = $dpullbear + $_GET['dbasebear'];
		$dfinbull = $dpullbull + $_GET['dbasebull'];

		$dtotalall = $dfinbear + $dfinbull + ($dtradd->bear + $dtradd->bull);

		$dpercbear = (($dfinbear + $dtradd->bear) / $dtotalall) * 100;
		$dpercbull = (($dfinbull + $dtradd->bull) / $dtotalall) * 100;

		// $dsentilist = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_list', true );
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

		$dtradd = json_decode(getpointtrades($_GET['stock']));

		$dfinbear = $dpullbear + $_GET['dbasebear'];
		$dfinbull = $dpullbull + $_GET['dbasebull'];

		$dtotalall = $dfinbear + $dfinbull + ($dtradd->bear + $dtradd->bull);

		$dpercbear = (($dfinbear + $dtradd->bear) / $dtotalall) * 100;
		$dpercbull = (($dfinbull + $dtradd->bull) / $dtotalall) * 100;

		// $dsentilist = get_post_meta( $adminuser, '_sentiment_'.$_GET['stock'].'_list', true );		
		echo json_encode(['dbear' => $dpercbear, 'dbull' => $dpercbull, 'action' => $dreturn, 'whatchanged' => $dtradd->bull, 'stock' => $_GET['stock'], 'gbear' => $dsentbear, 'gbull' => $dsentbull]);
		
	}  elseif(isset($_GET['daction']) && $_GET['daction'] == 'marketsentiment'){

			echo getpointtrades($_GET['stock']);

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

    }elseif(isset($_GET['daction']) && $_GET['daction'] == 'email_pass_reset'){
		global $wpdb;
		$emailstr = stripslashes($_GET['email']);
		echo $emailstr ."\n";
		// return json_encode($emailstr);

		// Search if email is existing
		$checkQuery = "SELECT * FROM arby_users WHERE user_email like '$emailstr'";

		// create random temp password
		function password_generate($chars) 
		{
		  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
		  return substr(str_shuffle($data), 0, $chars);
		}
		$passgen = password_generate(8)."\n";
		echo $passgen;
		$passhash = wp_hash_password( $passgen );

		// update users password to new temp password
		$updatepass = "UPDATE arby_users SET user_pass = '$passhash' WHERE user_email = '$emailstr'";
		$exist = $wpdb->query($updatepass);

		// send email include all created credentials
		$to = $emailstr;
		$subject = 'Password Reset Confirmation';
		$message = '
		<div class="container" style="width: 100%; font-family: "Roboto", sans-serif; color: #142c46;">
		<div class="em-head" style="padding: 23px 0px 23px 31px; background-color: #142c46; background-image: url("https://arbitrage.ph/email-templates/email-template/lines.png"); background-position: 5vh 34%; background-size: 103%;"><img class="arbi-logo" style="width: 24%;" src="https://arbitrage.ph/email-templates/email-template/logo.png" /></div>
		<div class="site-name" style="text-align: right; font-size: 15px; float: right; margin: 20px 30px 0px 0px;">{site_name} <a class="trade-btn" style="color: #142c46; cursor: pointer; padding: 3px 9px; border-radius: 20px; border: 3px solid #142c46;">Trade now </a></div>
		<div class="em-container" style="-webkit-box-shadow: 0px 2px 8px -2px rgba(0,0,0,0.53); -moz-box-shadow: 0px 2px 8px -2px rgba(0,0,0,0.53); box-shadow: 0px 2px 8px -2px rgba(0,0,0,0.53);">
			<div class="em-content-handler">
				<div class="em-content-center" style="margin: 0 39px; padding-bottom: 45px; padding-top: 67px;">
					<div class="em-content-topic" style="text-align: left; font-size: 25px; font-weight: 500; margin-top: 0px; margin-bottom: 53px; line-height: 33px;">We received a request to reset the password for your account. Your new password is indicated below.</div>
					<a class="login-prime-btn" style="border-bottom: 3px solid #142c46; padding: 10px 0; color: #142c46; font-size: 18px; border-radius: 0; text-decoration: none !important; font-weight: 500;" href="{login_url}">'. $passgen .'</a>
					<div class="em-content-body" style="text-align: left; margin-top: 47px; font-size: 15px; line-height: 20px; font-weight: 500;">If you didnt make this request, ignore this email or <a>report it to us.</a></div>
					<div class="greet-container" style="font-weight: 500;">
						<div class="em-greet sss" style="margin-top: 52px; font-size: 15px;">Thank you!</div>
						<div class="em-greet-name" style="font-size: 15px;">The <a href="{site_url}">{site_name}</a> Team</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		';
		
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'To: <'.$emailstr.'>' . "\r\n";
		$headers .= 'From: Arbitrage Team <no-reply@arbitrage.ph>';
		
		$success = mail($to, $subject, $message, $headers);
		if (!$success) {
			$errorMessage = error_get_last();
		}
		// return to user success
		return;

    }elseif(isset($_GET['daction']) && $_GET['daction'] == 'send_batch_verification'){

        die('test test');

	}elseif(isset($_GET['daction']) && $_GET['daction'] == 'whotomingle'){

        // global $current_user;
		// $user = wp_get_current_user();
		$userID = $current_user->ID;
		$topargs = array(
			'role'          =>  '',
		);
		$users = get_users($topargs);
		$newuserlist = array();
		foreach ($users as $key => $value) {

			if (!UM()->Friends_API()->api()->is_friend($value->ID, $userID) && $value->ID != $userID) {
				
				if ( $pending = UM()->Friends_API()->api()->is_friend_pending( $value->ID, $userID) ) {
					// if ($pending == $userID) {
					// 	echo $value->data->user_login." respond to request -<br />";
					// } else {
					// 	echo $value->data->user_login." request sent -<br />";
					// }
				} else {
					$userdetails['id'] = $value->ID;
					$userdetails['displayname'] = (!empty($value->data->display_name) ? $value->data->display_name : $value->data->user_login);
					$userdetails['followers'] = UM()->Followers_API()->api()->count_followers( $value->ID );
					$userdetails['user_nicename'] = $value->data->user_nicename;
					array_push($newuserlist, $userdetails);
				}
			}
		}

		usort($newuserlist, function($a, $b) {
			return $a['followers'] <=> $b['followers'];
		});
		$toptraiders = array_reverse($newuserlist);
		$toptraiders = array_slice($toptraiders, 0, 3);
		echo json_encode($toptraiders);

	}elseif(isset($_GET['daction']) && $_GET['daction'] == 'trendingstocks'){
		global $wpdb;

		$date = date('Y-m-d', time());

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/stocks/list');
		// curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.25.248.104']);
		curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
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

			function date_compare($a, $b)
			{
				$t1 = $a['following'];
				$t2 = $b['following'];
				return $t1 - $t2;
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

		if(isset($_GET['toverify'])){
			global $wpdb;

			$user = get_user_by( 'email', $_GET['toverify'] );

			if(empty($user)){
				echo "email is not registered";
			} else {
				$results = $wpdb->get_results("select * from arby_usermeta where user_id = '".$user->data->ID."' and meta_key = 'check_user_share'");
				if(empty($results)){
					$sqltoadd = "insert into arby_usermeta (user_id, meta_key, meta_value) values ('".$user->data->ID."','check_user_share','verified')";
					$wpdb->query($sqltoadd);
					echo "user ".$_GET['toverify']." with ID [".$user->data->ID."] is verified";
				} else {
					echo $_GET['toverify']." is already verified";
				}
			}
		
		} else {
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


			$dtradd = json_decode(getpointtrades($_GET['stock']));
			
			$totalitem = $totsbear + $totsbull + ($dtradd->bear + $dtradd->bull);

			$bearperc = (($totsbear + $dtradd->bear) / $totalitem) * 100;
			$bullperc = (($totsbull + $dtradd->bull) / $totalitem) * 100;
			
			echo json_encode(["dbear" => number_format( $bearperc, 2, '.', ',' ), 'dbull' => number_format( $bullperc, 2, '.', ',' ), 'isvote' => $isvote, 'islastupdate' => $dlastupdate]);
		}

		
		
	}

	
	

	// $totsbear = (int) ($dsentbear == "" ? 0 : $dsentbear) + $_GET['isbear'];
	// $totsbull = (int) ($dsentbull == "" ? 0 : $dsentbull) + $_GET['isbull'];

	// $totalitem = $totsbear + $totsbull;

	// $bearperc = ($totsbear / $totalitem) * 100;
	// $bullperc = ($totsbull / $totalitem) * 100;

	


?>