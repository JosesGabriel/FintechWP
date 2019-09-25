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
		curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($curl);
		curl_close($curl);

		$trades = json_decode($response);
		$trades = $trades->data;
		

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE&symbol=".$dinfstock);
		curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
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
			curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($curl);
			curl_close($curl);

			$trades = json_decode($response);
			$trades = $trades->data;
			

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE&symbol=".$dinfstock);
			curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
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

	if (isset($_POST['inpt_data_status']) && $_POST['inpt_data_status'] == 'Live') {
		$stockquantity = str_replace(",", "", $_POST['inpt_data_qty']);
		$butstockprice = str_replace(",", "", $_POST['inpt_data_price']);

        $tradeinfo = [];
		$tradeinfo['buymonth'] = date('F', strtotime($_POST['newdate']));
        $tradeinfo['buyday'] = date('d', strtotime($_POST['newdate']));
		$tradeinfo['buyyear'] = date('Y', strtotime($_POST['newdate']));
        $tradeinfo['stock'] = $_POST['inpt_data_stock'];
		$tradeinfo['price'] = $butstockprice;
        $tradeinfo['qty'] = $stockquantity;
        $tradeinfo['currprice'] = $_POST['inpt_data_currprice'];
        $tradeinfo['change'] = $_POST['inpt_data_change'];
        $tradeinfo['open'] = $_POST['inpt_data_open'];
        $tradeinfo['low'] = $_POST['inpt_data_low'];
        $tradeinfo['high'] = $_POST['inpt_data_high'];
        $tradeinfo['volume'] = $_POST['inpt_data_volume'];
        $tradeinfo['value'] = $_POST['inpt_data_value'];
        $tradeinfo['boardlot'] = $_POST['inpt_data_boardlot'];
        $tradeinfo['strategy'] = $_POST['inpt_data_strategy'];
        $tradeinfo['tradeplan'] = $_POST['inpt_data_tradeplan'];
        $tradeinfo['emotion'] = $_POST['inpt_data_emotion'];
        $tradeinfo['tradingnotes'] = $_POST['inpt_data_tradingnotes'];
		$tradeinfo['status'] = $_POST['inpt_data_status'];
		 
		$dlistofstocks = get_user_meta($user->ID, '_trade_list', true);
		
		echo json_encode([
			'post' => $_POST,
			'list' => $dlistofstocks,
		]);
		die();

        if ($dlistofstocks && is_array($dlistofstocks) && in_array($_POST['inpt_data_stock'], $dlistofstocks)) {
            $dstocktraded = get_user_meta($user->ID, '_trade_'.$_POST['inpt_data_stock'], true);
            if ($dstocktraded && $dstocktraded != '') {
                array_push($dstocktraded['data'], $tradeinfo);
                $dstocktraded['totalstock'] = $dstocktraded['totalstock'] + $stockquantity;

                $totalprice = 0;
                $totalquanta = 0;
                foreach ($dstocktraded['data'] as $ddatakey => $ddatavalue) {
                    $dmarkvval = $ddatavalue['price'] * $ddatavalue['qty'];
                    $dfees = getjurfees($dmarkvval, 'buy');
                    $totalprice += $dmarkvval + $dfees;
                    $totalquanta += $ddatavalue['qty'];
                }
                $dstocktraded['aveprice'] = ($totalprice / $totalquanta);

                update_user_meta($user->ID, '_trade_'.$tradeinfo['stock'], $dstocktraded);
            }
        } else {
            $finaldata = [];
            $finaldata['data'] = [];
            array_push($finaldata['data'], $tradeinfo);
            $finaldata['totalstock'] = $stockquantity;
            $dmarkvval = $tradeinfo['price'] * $tradeinfo['qty'];
            $dfees = getjurfees($dmarkvval, 'buy');
            $finaldata['aveprice'] = ($dmarkvval + $dfees) / $tradeinfo['qty'];
            update_user_meta($user->ID, '_trade_'.$tradeinfo['stock'], $finaldata);

            if (!$dlistofstocks) {
                $djournstocks = array($tradeinfo['stock']);
            } else {
                $djournstocks = $dlistofstocks;
                array_push($djournstocks, $tradeinfo['stock']);
            }
            update_user_meta($user->ID, '_trade_list', $djournstocks);
        }
        $dtotalpurchse = $butstockprice * $stockquantity;
        echo $dtotalpurchse;

        $stockcost = ($butstockprice * $stockquantity);
        $purchasefee = getjurfees($stockcost, 'buy');

        $wpdb->insert('arby_ledger', array(
                'userid' => $user->ID,
                'date' => date('Y-m-d'),
                'trantype' => 'purchase',
                'tranamount' => $stockcost + $purchasefee, // ... and so on
            ));
	}

	else if (isset($_GET['daction']) && $_GET['daction'] == 'watchlistval') { // watchlist get all stock prices
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

    }elseif(isset($_GET['daction']) && $_GET['daction'] == 'email_pass_reset_manual'){
		global $wpdb;
        $emailstr = stripslashes($_GET['email']);
        
        $user = get_user_by( 'email', $emailstr );

        if(empty($user)){
            echo "email is not registered";
        } else {
            $static_pwd = "123123123";
            $passhash = wp_hash_password( $static_pwd );
            $updatepass = "UPDATE arby_users SET user_pass = '$passhash' WHERE id = ".$user->data->ID;
            $wpdb->query($updatepass);
            echo "Email: ".$emailstr." | Password:".$static_pwd;
        }

    }elseif(isset($_GET['daction']) && $_GET['daction'] == 'email_pass_reset'){
		global $wpdb;
		$homeurlgen = get_home_url();
		$emailstr = stripslashes($_GET['email']);
		$user = get_user_by( 'email', $emailstr );

		$data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
		$passgen = substr(str_shuffle($data), 50);
	  
		$passhash = wp_hash_password( $passgen );
		$updatepass = "UPDATE arby_users SET user_pass = '$passhash' WHERE id = ".$user->data->ID;
		$wpdb->query($updatepass);

		$to = $emailstr;
		$subject = 'Password Reset Confirmation';
		$message = '
		<div class="container" style="width: 100%; font-family: "Roboto, sans-serif; color: #142c46;">
			<div class="em-head" style="padding: 23px 0px 23px 31px; background-color: #142c46; background-image: url("'.$homeurlgen.'/email-templates/email-template/lines.png"); background-position: 5vh 34%; background-size: 103%;"><img class="arbi-logo" style="width: 24%;" src="'.$homeurlgen.'/email-templates/email-template/logo.png" /></div>
			<div class="site-name" style="text-align: right; font-size: 15px; float: right; margin: 20px 30px 0px 0px;color: #142c46;">Arbitrage <a class="trade-btn" style="color: #142c46; cursor: pointer; padding: 3px 9px; border-radius: 20px; border: 3px solid #142c46;">Trade now </a></div>
			<div class="em-container" style="-webkit-box-shadow: 0px 2px 8px -2px rgba(0,0,0,0.53); -moz-box-shadow: 0px 2px 8px -2px rgba(0,0,0,0.53); box-shadow: 0px 2px 8px -2px rgba(0,0,0,0.53);">
			<div class="em-content-handler">
				<div class="em-content-center" style="margin: 0 39px; padding-bottom: 45px; padding-top: 67px;">
					<div class="em-content-topic" style="text-align: left; font-size: 25px; font-weight: 500; margin-top: 0px; margin-bottom: 53px; line-height: 33px;color: #142c46;">We received a request to reset the password for your account. Your new password is indicated below.</div>
					<a class="login-prime-btn" style="border-bottom: 3px solid #142c46; padding: 10px 0; color: #142c46; font-size: 18px; border-radius: 0; text-decoration: none !important; font-weight: 500;">'. $passgen .'</a>
					<div class="em-content-body" style="text-align: left; margin-top: 47px; font-size: 15px; line-height: 20px; font-weight: 500;color: #142c46;">If you didnt make this request, ignore this email or <a>report it to us.</a></div>
					<div class="greet-container" style="font-weight: 500;color: #142c46;">
						<div class="em-greet sss" style="margin-top: 52px; font-size: 15px;color: #142c46;">Thank you!</div>
						<div class="em-greet-name" style="font-size: 15px;color: #142c46;">The <a href="'.$homeurlgen.'">Arbitrage</a> Team</div>
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

			echo json_encode(['status' => 500, 'success' => false]);
			die();
		}
		// return to user success
		echo json_encode(['status' => 200, 'success' => true]);
		die();

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
		$counter = 0;

		$dsprest = $wpdb->get_results( "select * from arby_users where id not in (select distinct user_id1 from arby_um_friends where user_id2 = ".$userID." and status = 1) order by rand() limit 5");
		foreach ($dsprest as $key => $value) {
			$userdetails = [];
			$userdetails['currentuser'] = $userID;
			$userdetails['id'] = $value->ID;
			$userdetails['displayname'] = $value->display_name;
			$userdetails['user_nicename'] = $value->user_nicename;
			$userdetails['profpic'] = esc_url( get_avatar_url( $value->ID ) );
			array_push($newuserlist, $userdetails);
		}

		echo json_encode($newuserlist);

	}elseif(isset($_GET['daction']) && $_GET['daction'] == 'trendingstocks'){
		global $wpdb;

		$date = date('Y-m-d', time());

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/stocks/list');
		// curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
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
	} elseif(isset($_GET['daction']) && $_GET['daction'] == 'topplayers'){
		$secret = get_user_meta( $current_user->ID, 'user_secret', true );
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://game.arbitrage.ph/api/getranking' );
		curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$dranks = curl_exec($curl);
		curl_close($curl);
		$dranks = json_decode($dranks, true);
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://game.arbitrage.ph/api/getmyrank/'.$secret );
		curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$myrank = curl_exec($curl);
		curl_close($curl);
		$myrank = json_decode($myrank, true);

		array_push($dranks, $myrank);

		echo json_encode($dranks);

	} elseif(isset($_GET['daction']) && $_GET['daction'] == 'checkifhavestock'){
		$duserid = $current_user->ID;
		$return = [];
		$dsprest = $wpdb->get_results('select * from arby_usermeta where user_id = "'.$duserid.'" and meta_key = "_trade_list"');
		print_r('select * from arby_usermeta where user_id = "'.$duserid.'" and meta_key = "_trade_list"');
		if(strpos($dsprest[0]->meta_value, $_GET['symbol']) !== false){
			// echo "has stocks";
			$getstockdetails = $wpdb->get_results('select * from arby_usermeta where user_id = "'.$duserid.'" and meta_key = "_trade_'.$_GET['symbol'].'"');
			$dstockinfo = unserialize($getstockdetails[0]->meta_value);


			$return['status'] = "yes_stock";
			$return['data']['symbol'] = $_GET['symbol'];
			$return['data']['volume'] = $dstockinfo['totalstock'];
			$return['data']['averageprice'] = $dstockinfo['aveprice'];
			$return['data']['tradelog'] = $getstockdetails[0]->meta_value;
			


		} else {
			// echo "no stocks";
			$return['status'] = "no_stock";
		}

		echo json_encode($return);


	}elseif(isset($_GET['daction']) && $_GET['daction'] == 'sidebar-bulletin'){

		ob_start();
		dynamic_sidebar( 'et_pb_widget_area_1' );
		$content = ob_get_contents();
		ob_end_clean();

		echo json_encode(['data' => $content, 'status' => 200, 'success' => true]);
		die();

	} elseif (isset($_GET['daction']) && $_GET['daction'] == 'user-posts-count' && isset($_GET['user-id'])) {

		$profile_id = $_GET['user-id'];

		if (!is_numeric($profile_id)) {
			echo json_encode([
				'status' => 417,
				'success' => false,
			]);
			die();
		}

		$posts_count = $wpdb->get_var($wpdb->prepare(
			"SELECT COUNT(id) 
			FROM $wpdb->posts
			WHERE post_type = 'um_activity' 
			AND post_author = %s
			AND post_status = 'publish'",
			$profile_id
		));

		echo json_encode([
			'status' => 200,
			'success' => true,
			'data' => compact('posts_count'),
		]);
		die();

	} elseif (isset($_GET['daction']) && $_GET['daction'] == 'user-peers-count' && isset($_GET['user-id'])) {

		$profile_id = $_GET['user-id'];

		if (!is_numeric($profile_id)) {
			echo json_encode([
				'status' => 417,
				'success' => false,
			]);
			die();
		}

		$peers_count = UM()->Friends_API()->api()->count_friends( $profile_id );

		echo json_encode([
			'status' => 200,
			'success' => true,
			'data' => compact('peers_count'),
		]);
		die();

	} elseif (isset($_GET['daction']) && $_GET['daction'] == 'user-social-wall' && isset($_GET['user-id'])) {
		
		$profile_id = $_GET['user-id'];

		if (!is_numeric($profile_id)) {
			echo json_encode([
				'status' => 417,
				'success' => false,
			]);
			die();
		}

		ob_start();
		echo do_shortcode('[ultimatemember_wall user_id="'.$profile_id.'" user_wall="true" ]');
		$contents = ob_get_contents();
		ob_end_clean();

		echo json_encode([
			'status' => 200,
			'success' => true,
			'data' => compact('contents'),
		]);
		die();

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
			
			$bearperc = 0;
			$bullperc = 0;

			if ($totalitem != 0) {
				$bearperc = ($totsbear + $dtradd->bear) != 0 ? (($totsbear + $dtradd->bear) / $totalitem) * 100 : 0;
				$bullperc = ($totsbull + $dtradd->bull) != 0 ? (($totsbull + $dtradd->bull) / $totalitem) * 100 : 0;
			}
			
			echo json_encode(["dbear" => number_format( $bearperc, 2, '.', ',' ), 'dbull' => number_format( $bullperc, 2, '.', ',' ), 'isvote' => $isvote, 'islastupdate' => $dlastupdate]);
		}

		
		
	}

	
	

	// $totsbear = (int) ($dsentbear == "" ? 0 : $dsentbear) + $_GET['isbear'];
	// $totsbull = (int) ($dsentbull == "" ? 0 : $dsentbull) + $_GET['isbull'];

	// $totalitem = $totsbear + $totsbull;

	// $bearperc = ($totsbear / $totalitem) * 100;
	// $bullperc = ($totsbull / $totalitem) * 100;

	


?>