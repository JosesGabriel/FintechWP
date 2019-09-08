
<?php
	

add_action('wp_ajax_my_custom_action','custom_fn_callback');
add_action('wp_ajax_nopriv_my_custom_action', 'custom_fn_callback');

function custom_fn_callback() {
	$current_user = wp_get_current_user();
	$ismetadis = get_user_meta(get_current_user_id(), '_watchlist_instrumental', true);

  	$dlistoftada = [];
  	$newtickerme = [];

  	if ($ismetadis) {
  		foreach ($ismetadis as $value) {
			$dlisrofalert = [];
			$dlisrofalert['stock'] = $value['stockname'];
			$dlisrofalert['alerts'] = [];

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, 'http://phisix-api4.appspot.com/stocks/'.$value['stockname'].'.json');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$dwatchinfo = curl_exec($curl);
			curl_close($curl);

			$dstockinfo = json_decode($dwatchinfo);

			$emailmessage = "";

			foreach ($dstockinfo->stock as $stockvalue) {
				$dlisrofalert['current_price'] = $stockvalue->price->amount;
				if (isset($value['dconnumber_entry_price'])) {
					if ($value['dconnumber_entry_price'] == $stockvalue->price->amount) {
						array_push($dlisrofalert['alerts'], 'entry_price');
						$emailmessage += $value['stockname']." has reached ". $value['dconnumber_entry_price'] .". Buy Now! \r\n";
					}
				}
				
				if (isset($value['dconnumber_take_profit_point'])) {
					if ($value['dconnumber_take_profit_point'] < $stockvalue->price->amount) {
						array_push($dlisrofalert['alerts'], 'take_profit_point');
						$emailmessage += $value['stockname']." has reached ". $value['dconnumber_entry_price'] .". Sell now and be Rewarded! \r\n";
					}
				}

				if (isset($value['dconnumber_stop_loss_point'])) {
					if ($value['dconnumber_stop_loss_point'] > $stockvalue->price->amount) {
					// if ('15' > $stockvalue->price->amount) {
						array_push($dlisrofalert['alerts'], 'stop_loss_point');
						$emailmessage += $value['stockname']." has reached ". $value['dconnumber_entry_price'] .". Sell now to stop your loss! \r\n";
					}
				}
			}

			
			// this is a test`
			// if (!empty($dlisrofalert['alerts'])) {
				if ($value['isticked'] >= strtotime('-10 minutes')) {
					$value['isticked'] = time();
					array_push($dlistoftada, $dlisrofalert);
					array_push($newtickerme, $value);
					if ($emailmessage != "") {
						$headers = 'From: Arbitrage Alerts' . "\r\n";
						wp_mail( $current_user->user_email, 'Arbitrage | Watchlist Alert', $emailmessage, $headers );
					}
					
					// update_user_meta(get_current_user_id(), '_watchlist_instrumental', $havemeta);
				} else {
					array_push($newtickerme, $value);
				}
				
			// }
		}
		
		update_user_meta(get_current_user_id(), '_watchlist_instrumental', $newtickerme);

  	}


	echo json_encode($dlistoftada);
    wp_die();
}


add_action('wp_ajax_post_sentiment','sentiment_callback');
add_action('wp_ajax_nopriv_post_sentiment', 'sentiment_callback');

function sentiment_callback() {
	date_default_timezone_set('Asia/Manila');
	$date = date('m/d/Y', time());

	$dreturn = "";
	if ($_POST['stock'] != 'chart') {
		// $dreturn = $_POST['dbuttonact'] . " is the action";


		// save userid of user who voted as per ticked
		// save vote casted as per stock
		// no voting shall be casted after narket 


		$dsentbear = get_post_meta( 504, '_sentiment_'.$_POST['stock'].'_bear', true );
		$dsentbull = get_post_meta( 504, '_sentiment_'.$_POST['stock'].'_bull', true );
		$dsentilist = get_post_meta( 504, '_sentiment_'.$_POST['stock'].'_list', true );
		$dsentdate = get_post_meta( 504, '_sentiment_'.$_POST['stock'].'_lastupdated', true );
		// if (isset($dsentcount)) {
			if ($dsentilist && is_array( $dsentilist ) && in_array( get_current_user_id(), $dsentilist )) {
				// do nothin
				$dreturn = "Cant vote!";
			} else{
				$dreturn = "Go for Vote ";
				// add sentiment points
				if ($_POST['dbuttonact'] == "bbs_bull") {
					$finalcount = $dsentbull + 1;
					update_post_meta( 504, '_sentiment_'.$_POST['stock'].'_bull', $finalcount, true );
				} else {
					$finalcount = $dsentbear + 1;
					update_post_meta( 504, '_sentiment_'.$_POST['stock'].'_bear', $finalcount, true );
				}

				// add user on the sentiment
				$dlistofusers = array();
				array_push($dlistofusers, $_POST['userid']);
				update_post_meta( 504, '_sentiment_'.$_POST['stock'].'_list', $dlistofusers, true );

				// add date
				update_post_meta( 504, '_sentiment_'.$_POST['stock'].'_lastupdated', $date, true );
			}
		// } else {
		// 	$dreturn = "Cant vote!";
		// }

		// update_user_meta(get_current_user_id(), '_watchlist_instrumental', $newtickerme);


	} else {
		$dreturn = "No Stock Selected";
	}
	
	$dpullbear = get_post_meta( 504, '_sentiment_'.$_POST['stock'].'_bear', true );
	$dpullbull = get_post_meta( 504, '_sentiment_'.$_POST['stock'].'_bull', true );

	$dfinbear = $dpullbear + $_POST['dbasebear'];
	$dfinbull = $dpullbull + $_POST['dbasebull'];

	$dtotalall = $dfinbear + $dfinbull;

	$dpercbear = ($dfinbear / $dtotalall) * 100;
	$dpercbull = ($dfinbull / $dtotalall) * 100;

	echo json_encode(['dbear' => $dpercbear, 'dbull' => $dpercbull, 'action' => $dreturn]);
    wp_die();
}


// add_shortcode('testme', 'recent_posts_function');
// function recent_posts_function() {
//   //  $ismetadis = get_user_meta(get_current_user_id(), '_watchlist_instrumental', true);

//   // 	$dlistoftada = [];
//   // 	$newtickerme = [];

//   // 	if ($ismetadis) {
//   // 		foreach ($ismetadis as $value) {
// 		// 	$dlisrofalert = [];
// 		// 	$dlisrofalert['stock'] = $value['stockname'];
// 		// 	$dlisrofalert['alerts'] = [];

// 		// 	$curl = curl_init();
// 		// 	curl_setopt($curl, CURLOPT_URL, 'http://phisix-api4.appspot.com/stocks/'.$value['stockname'].'.json');
// 		// 	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// 		// 	$dwatchinfo = curl_exec($curl);
// 		// 	curl_close($curl);

// 		// 	$dstockinfo = json_decode($dwatchinfo);

// 		// 	foreach ($dstockinfo->stock as $stockvalue) {
// 		// 		$dlisrofalert['current_price'] = $stockvalue->price->amount;
// 		// 		if (isset($value['dconnumber_entry_price'])) {
// 		// 			if ($value['dconnumber_entry_price'] == $stockvalue->price->amount) {
// 		// 				array_push($dlisrofalert['alerts'], 'entry_price');
// 		// 			}
// 		// 		}
				
// 		// 		if (isset($value['dconnumber_take_profit_point'])) {
// 		// 			if ($value['dconnumber_take_profit_point'] < $stockvalue->price->amount) {
// 		// 				array_push($dlisrofalert['alerts'], 'take_profit_point');
// 		// 			}
// 		// 		}

// 		// 		if (isset($value['dconnumber_stop_loss_point'])) {
// 		// 			if ($value['dconnumber_stop_loss_point'] > $stockvalue->price->amount) {
// 		// 			// if ('15' > $stockvalue->price->amount) {
// 		// 				array_push($dlisrofalert['alerts'], 'stop_loss_point');
// 		// 			}
// 		// 		}
// 		// 	}

			

// 		// 	// if (!empty($dlisrofalert['alerts'])) {
// 		// 		if ($value['isticked'] >= strtotime('-10 minutes')) {
// 		// 			$value['isticked'] = time();
// 		// 			array_push($dlistoftada, $dlisrofalert);
// 		// 			array_push($newtickerme, $value);
// 		// 			// update_user_meta(get_current_user_id(), '_watchlist_instrumental', $havemeta);
// 		// 		} else {
// 		// 			array_push($newtickerme, $value);
// 		// 		}
				
// 		// 	// }
// 		// }
// 		// update_user_meta(get_current_user_id(), '_watchlist_instrumental', $newtickerme);

//   // 	}
	

//   // 	// update_user_meta(get_current_user_id(), '_watchlist_instrumental', $newtickerme);
//   //  	print_r($ismetadis);
//   //  	print_r($newtickerme);

// }


add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>
    <?php if ($user->roles[0] == "subscriber"): ?>
    	<h3><?php _e("Promo Codes", "blank"); ?></h3>
    	<table class="form-table">
		    <tr>
		        <th><label for="refforuser"><?php _e("Reference Code"); ?></label></th>
		        <td>
		            <input type="text" name="refforuser" id="refforuser" value="<?php echo esc_attr( get_user_meta( $user->ID, 'refforuser', true ) ); ?>" class="regular-text" /><br />
		            <span class="description"><?php _e("Please enter your code to avail promos."); ?></span>
		        </td>
		    </tr>
	    </table>
	<?php else: ?>
		<h3><?php _e("Promo Codes", "blank"); ?></h3>
    	<table class="form-table">
		    <tr>
		        <th><label for="refformentor"><?php _e("My Reference Code"); ?></label></th>
		        <td>
		            <input type="text" name="refformentor" id="refformentor" value="<?php echo esc_attr( get_user_meta(  $user->ID, 'refformentor', true ) ); ?>" class="regular-text" disabled/><br />
		            <span class="description"><?php _e("Give this code to the user"); ?></span>
		        </td>
		    </tr>
	    </table>
    <?php endif; ?>
    
<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'refforuser', $_POST['refforuser'] );
}

?>