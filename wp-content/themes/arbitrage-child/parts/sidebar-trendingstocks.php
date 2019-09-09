<script type="text/javascript">
jQuery(function(){

  function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  };
  var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
  var dcount = 0;
  jQuery('.top-stocks .to-content-part ul .even span, .top-stocks .to-content-part ul .odd span').each(function(index,el){
    if (dcount == '10') {dcount = 0; }
    jQuery(el).css('border-color',colors[dcount]);
    dcount++;
  });
});


// jQuery(document).ready(function(){
//   jQuery(".see-more-btn").click(function(){
//     jQuery(".hide-show").toggle(function(){
//   });
// });
// });
jQuery(document).ready(function(){
jQuery(".stocks-hidden-content").click(function () {
    jQuery(".trend-content-hidden").toggle('slow');
        if(jQuery(".stocks-hidden-content").hasClass('isopen')){
            jQuery(".stocks-hidden-content").html('<i class="fas fa-sort-down" id="fa-up" style="bottom: 0px;top: -2px;position: relative;font-size: 16px;margin-right: 4px;vertical-align: initial;"></i><strong>Show more</strong>').removeClass('isopen').slideDown( "slow" );
            jQuery(".trend-content-hidden").slideUp( "slow" );
        }else {
            jQuery(".stocks-hidden-content").html('<i class="fas fa-sort-up" id="fa-up" style="bottom: 0;top: 4px;position: relative;font-size: 16px;margin-right: 4px;vertical-align: initial;"></i><strong>Hide</strong>').addClass('isopen');
            jQuery(".trend-content-hidden").slideDown( "slow" );
          }
    });
});


</script>
<?php
    global $wpdb;

    $date = date('Y-m-d', time());
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/stocks/list');
    curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.25.248.104']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $gerdqoute = curl_exec($curl);
    curl_close($curl);

    
    
    
    $gerdqoute = json_decode($gerdqoute);
    $adminuser = 504; // store on the chart page

    $listofstocks = []; 

    if ($gerdqoute) {
        foreach ($gerdqoute->data as $dlskey => $dlsvalue) {
            $indls = [];
            $indls['stock'] = $dlskey;
            $dstocknamme = $dlskey;

            // $dstocks = $stocksdesc->$dstocknamme->description;
            $dstocks = $dlsvalue->description;
            $indls['stnamename'] = strtolower($dstocks);
            $dpullbear = get_post_meta( 504, '_sentiment_'.$dlskey.'_bear', true );
            $dpullbull = get_post_meta( 504, '_sentiment_'.$dlskey.'_bull', true );
            $indls['spnf'] = ($dpullbear != "" ? $dpullbear : 0) .'+'. ($dpullbull != "" ? $dpullbull : 0);
            // $indls['following'] = ($dpullbear != "" ? $dpullbear : 0) + ($dpullbull != "" ? $dpullbull : 0);
    
            // trending on posts
    
            // $dsprest = $wpdb->get_results( "SELECT * FROM arby_posts WHERE post_content LIKE '%".strtolower($dstocknamme)."%'");
            $dsprest = $wpdb->get_results( "SELECT * FROM arby_posts WHERE post_content LIKE '%$".strtolower($dstocknamme)."%' AND DATE(post_date) >= DATE_ADD(CURDATE(), INTERVAL -3 DAY)");
            // echo "SELECT * FROM arby_posts WHERE post_content LIKE '%$".strtolower($dstocknamme)."%' AND post_date > ".$date;

            $countpstock = 0;
            $isbull = 0;
            foreach ($dsprest as $rsffkey => $rsffvalue) {
                $dcontent = $rsffvalue->post_content;
                if (strpos(strtolower($dcontent), '$'.strtolower($dstocknamme)) !== false) {
                    $countpstock++;
                }
                // echo $rsffvalue->ID." - ";
                $bull_people = get_post_meta($rsffvalue->ID, '_bullish', true);
                $bull_people = $bull_people == '' ? 0 : $bull_people;
                $isbull += $bull_people;
            }

            $dpresent = $wpdb->get_results( "SELECT * FROM arby_posts WHERE post_content LIKE '%$".strtolower($dstocknamme)."%' AND DATE(post_date) >= CURDATE()");
            $todayreps = 0;
            foreach ($dpresent as $rsffkey => $rsffvalue) {
                $dcontent = $rsffvalue->post_content;
                if (strpos(strtolower($dcontent), '$'.strtolower($dstocknamme)) !== false) {
                    $todayreps++;
                }
            }

            $dsentdate = get_post_meta( $adminuser, '_sentiment_'.$dstocknamme.'_lastupdated', true );
            // $dpullbear = get_post_meta( $adminuser, '_sentiment_'.$dstocknamme.'_bear', true );
            $dpullbull = get_post_meta( $adminuser, '_sentiment_'.$dstocknamme.'_bull', true );
            $dpullbull = $dpullbull == '' ? 0 : $dpullbull;
            // 3 days back
            $threedays = ceil($countpstock * 0.2);
            $bulls = ceil($dpullbull * 0.3);
            $tags = ceil($todayreps * 0.6);
            $finalcount = $bulls + $threedays + $tags;

            // echo $dstocknamme.": ".$threedays." - ".$bulls." - ".$tags." | ";
    
            $indls['following'] = $finalcount;

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
        <ul>
            <?php
                $countss = 1;
                // $numinarrat = count($lfstkey);
                $numinarrat = count($finaltopstocks);
            ?>
            <?php foreach ($finaltopstocks as $lfstkey => $lfstvalue) { ?>

                <?php echo ($countss == 6 ? '<div class="hide-show trend-content-hidden">' : ''); ?>
                <li class="even <?php echo $countss; ?>">
                    <span><?php echo $lfstvalue['stock']; ?></span>
                    <a href="#"><?php echo ucwords($lfstvalue['stnamename']); ?> <br>
                    <p><?php
                         echo $lfstvalue['following'];
                         
                         if(strlen($lfstvalue['following']) == 1){
                            print_r($lfstvalue['following']);

                         }
                        ?> Hits</p></a>
                </li>
                <?php echo ($countss == $numinarrat ? '</div>' : ''); ?>
                 <?php $countss++; ?>
            <?php } ?>

            <!-- <li class="odd">
                <span>MRC</span>
                <a href="#">MRC Allied, Inc. <br><p>31 Following</p></a>
            </li>
            <li class="even">
                <span>ABA</span>
                <a href="#">AbaCore Capital Holdings, Inc.<br><p>322 Following</p></a>
            </li>
            <li class="odd">
                <span>FOOD</span>
                <a href="#">Alliance Select Food  Int’l Inc.<br><p>323 Following</p></a>
            </li>
            <li class="even">
                <span>STI</span>
                <a href="#">STI Education System, Inc.<br><p>325 Following</p></a>
            </li>
            <div class="hide-show">
                <li class="odd">
                    <span>FOOD</span>
                    <a href="#">Alliance Select Food  Int’l Inc.<br><p>326 Following</p></a>
                </li>
                <li class="even">
                    <span>STI</span>
                    <a href="#">Alliance Select Food  Int’l Inc.<br><p>323 Following</p></a>
                </li>
                <li class="odd">
                    <span>FOOD</span>
                    <a href="#">Alliance Select Food  Int’l Inc.<br><p>123 Following</p></a>
                </li>
                <li class="even">
                    <span>STI</span>
                    <a href="#">Alliance Select Food  Int’l Inc.<br><p>332 Following</p></a>
                </li>
            </div> -->
        </ul>
    </div>

    <div class="to-bottom-seemore" style="display: inline-flex;color: #cecece;font-size: 13px;">

<?php if($numinarrat != 0 ) { ?>

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
    
<?php } ?>

</div>
    <!-- <div class="to-bottom-title">
        <a href="#" class="to-view-more">View all trending stocks</a>
    </div> -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<style type="text/css">
    .fa-sort-down {
        color: #d8d8d8;
    }
    .fa-sort-up {
        color: #d8d8d8;
    }
    .see-more-btn strong {
        color: #d8d8d8;
    }
    .see-more-btn i {
        color: #d8d8d8;
    }
    .top-stocks .to-content-part ul .even span {
        border: 2px solid;
        height: 42px;
        width: 42px;
        line-height: 40px;
        font-size: 11px !important;
        text-align: center;
        display: block;
        border-radius: 25px;
    }
    .top-stocks .to-content-part ul .even a{
        width: 75%;
    }
    .top-stocks .to-content-part ul .odd a{
        width: 75%;
    }

    .top-stocks .to-content-part ul .even {
        display: inline-flex;
        text-overflow: ellipsis;
        width: 98%;
        padding: 7px;
        padding-left: 11px;
    }
    .top-stocks .to-content-part ul .odd {
        display: inline-flex;
        text-overflow: ellipsis;
        width: 98%;
        padding: 7px;
        padding-left: 11px;
    }
    .top-stocks .to-content-part ul .odd span {
        border: 2px solid;
        height: 42px;
        width: 42px;
        line-height: 40px;
        font-size: 11px !important;
        text-align: center;
        display: block;
        border-radius: 25px;
    }
    .watch-list-inner .to-content-part .even tr:last-child {
        border-bottom: none !important;

    }
    .watch-list-inner .to-content-part {
        padding-top: 0 !important;
    }
    .top-stocks {
        background-color: #142c46;

    }
    .top-stocks .to-top-title {
        padding-top: 10px !important;
        padding-left: 15px !important;
        padding-bottom: 0 !important;
        margin-bottom: 7px !important;
    }
    .to-bottom-seemore {
        padding: 0px 0px 8px 16px;
        font-size: 12px !important;
        font-weight: 300 !important;
    }
    .hide-show {
        display: none;
    }
    .right-dashboard-part {
        float: left;
        width: 27%;
        padding: 21px 0px !important;
    }
    .to-bottom-seemore {
        cursor: pointer;
        font-weight: 500;
    }
    .top-stock .to-content-part {
        padding-bottom: 0 !important;
    }
    .top-stocks .to-content-part ul li a {
        padding: 2px 10px !important;
    }
    .top-stocks .to-content-part ul .even a p{
        color: #999999 !important;
        margin-bottom: 0;
    }
    .top-stocks .to-content-part ul .odd a p{
        color: #999999 !important;
        margin-bottom: 0;
    }
    .top-stocks .to-content-part {
        padding-bottom: 0 !important;
      min-height: 126px;
    }
    .gravatar .avatar .avatar-80 .um-avatar .um-avatar-default {
        top: 17px !important;
        bottom: 8px !important;
        position: relative !important;
    }
</style>
