<?php
    // global $wpdb;

    // $date = date('Y-m-d', time());

    // $curl = curl_init();
    // curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/stocks/list');
    // // curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:34.92.99.210']);
    // curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:34.92.99.210']);
	// 	curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // $gerdqoute = curl_exec($curl);
    // curl_close($curl);
    
    // $gerdqoute = json_decode($gerdqoute);
    // $adminuser = 504; // store on the chart page

    // $listofstocks = []; 

    // if ($gerdqoute) {
    //     foreach ($gerdqoute->data as $dlskey => $dlsvalue) {
    //         $indls = [];
    //         $indls['stock'] = $dlskey;
    //         $dstocknamme = $dlskey;

    //         $dstocks = $dlsvalue->description;
    //         $indls['stnamename'] = $dstocks;
    //         $dpullbear = get_post_meta( $adminuser, '_sentiment_'.$dlskey.'_bear', true );
    //         $dpullbull = get_post_meta( $adminuser, '_sentiment_'.$dlskey.'_bull', true );
    //         $indls['spnf'] = ($dpullbear != "" ? $dpullbear : 0) .'+'. ($dpullbull != "" ? $dpullbull : 0);
            
    //         $dsprest = $wpdb->get_results( "SELECT * FROM arby_posts WHERE post_content LIKE '%$".strtolower($dstocknamme)."%' AND DATE(post_date) >= DATE_ADD(CURDATE(), INTERVAL -3 DAY)");

    //         $todayreps = 0; // today
    //         $countpstock = 0; // 3 days back
    //         $isbull = 0;
    //         foreach ($dsprest as $rsffkey => $rsffvalue) {
    //             $dcontent = $rsffvalue->post_content;
    //             if (strpos(strtolower($dcontent), '$'.strtolower($dstocknamme)) !== false) {
    //                 if(date("Y-m-d", strtotime($rsffvalue->post_date)) == $date){
    //                     $todayreps++;
    //                 } else {
    //                     $countpstock++;
    //                 }
                    
    //             }
    //             // echo $rsffvalue->ID." - ";
    //             // $bull_people = get_post_meta($rsffvalue->ID, '_bullish', true);
    //             // $bull_people = $bull_people == '' ? 0 : $bull_people;
    //             // $isbull += $bull_people;
    //         }


    //         //get rodat
    //         // $dpresent = $wpdb->get_results( "SELECT * FROM arby_posts WHERE post_content LIKE '%$".strtolower($dstocknamme)."%' AND DATE(post_date) >= CURDATE()");
    //         // $todayreps = 0;
    //         // foreach ($dpresent as $rsffkey => $rsffvalue) {
    //         //     $dcontent = $rsffvalue->post_content;
    //         //     if (strpos(strtolower($dcontent), '$'.strtolower($dstocknamme)) !== false) {
    //         //         $todayreps++;
    //         //     }
    //         // }

    //         // $dsentdate = get_post_meta( $adminuser, '_sentiment_'.$dstocknamme.'_lastupdated', true );
    //         // $dpullbear = get_post_meta( $adminuser, '_sentiment_'.$dstocknamme.'_bear', true );
    //         $dpullbull = get_post_meta( $adminuser, '_sentiment_'.$dstocknamme.'_bull', true );
    //         $dpullbull = $dpullbull == '' ? 0 : $dpullbull;
    //         // 3 days back
    //         $threedays = ceil($countpstock * 0.2);
    //         $bulls = ceil($dpullbull * 0.3);
    //         $tags = ceil($todayreps * 0.6);
    //         $finalcount = $bulls + $threedays + $tags;
    //         $stocksscount = $countpstock + $dpullbull + $todayreps;

    //         // echo $dstocknamme.": ".$threedays." - ".$bulls." - ".$tags." | ";
    
    //         $indls['following'] = $finalcount;
    //         if($finalcount > 0){
    //             array_push($listofstocks, $indls);
    //         }
            
    //     }
    // }

    // function date_compare($a, $b)
    // {
    //     $t1 = $a['following'];
    //     $t2 = $b['following'];
    //     return $t1 - $t2;
    // }
    // usort($listofstocks, 'date_compare');
    // $drevdds = array_reverse($listofstocks);

    // $maxitems = 10;
    // $finaltopstocks = [];
    // foreach ($drevdds as $fnskey => $fnsvalue) {
    //     if ($fnskey + 1 > $maxitems) {
    //         break;
    //     }
    //     array_push($finaltopstocks, $fnsvalue);

    // }



    // echo $countpstock;
?>
<style type="text/css">
    pre {
        background: #fff;
    }
</style>
<div class="top-stocks" style="margin-bottom: 15px;">
    <div class="to-top-title" style="padding-top:2px"><strong>Trending Stocks</strong></div>
    <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
    <div class="to-content-part">
      <!-- <span class="nocont"><i class="fas fa-kiwi-bird" style="font-size: 30px;"></i><br>Waiting for API</span> -->
        <div id="preloader" class="trendingpreloader">
            <div id="status">&nbsp;</div>
            <div id="status_txt"></div>
        </div>
        <ul class="trendingme">
            <div class="hide-show trend-content-hidden"></div>
        </ul>
    </div>

    <div class="to-bottom-seemore" style="display: inline-flex;color: #cecece;font-size: 13px;">

<?php //if($numinarrat != 0 ) { ?>

    <div class="see-more-btn stocks-hidden-content" id="show_hide">
        <i class="fas fa-sort-down" id="fa-up" style="
            font-size: 13px;
            margin-right: 3px;
            vertical-align: initial;
            bottom: 0px;
            top: -2px;
            position: relative;
        "></i>
        <strong>See more</strong>
    </div>
    
<?php //} ?>

</div>
    <!-- <div class="to-bottom-title">
        <a href="#" class="to-view-more">View all trending stocks</a>
    </div> -->
</div>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
