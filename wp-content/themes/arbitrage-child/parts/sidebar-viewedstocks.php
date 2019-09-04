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
</script>

<div class="top-stocks">
    <div class="to-top-title"><strong>Most Watched Stocks</strong></div>
    <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
    <div class="to-content-part">


        <?php 

       
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://data-api.arbitrage.ph/api/v1/stocks/list");
        curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.25.248.104']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response !== false) {
            $response = json_decode($response);
            $stockinfo = $response->data;
        }

       //print_r($response);

        $num = 0;
        $counter = 1;
        $stockcount = 0;
        //$stock_watched = array();
       
        $users = get_users( array( 'fields' => array( 'ID' ) ) );


        foreach($stockinfo as $stkey => $stvals){
        
            foreach($users as $user_id){
           
                $havemeta = get_user_meta($user_id->ID, '_watchlist_instrumental', true);

                if($havemeta){
                    
                            foreach ($havemeta as $key => $value) {        
                                

                                        if ($stvals->symbol == $value['stockname']) {
                                            $stock_watched[$stockcount][0] = $stvals->symbol;
                                            $stock_watched[$stockcount][1] = $counter;
                                            $stock_watched[$stockcount][2] = $stvals->description;
                                            $counter++;   
                                            //$stockcount++;  
                                        }

                                 }

                         }       

                     }

                $stockcount++;
                $counter = 1;
             }
    
             usort($stock_watched, function($a, $b) {
                return $b[1] <=> $a[1];
            });

             

             ?>
             <ul>
             <?php

             for($i = 0; $i < 10; $i++){

                 if($stock_watched[$i][0] != null && $stock_watched[$i][0] != ""){

                       
                                    ?>
                                            <li class="odd">
                                                <span><?php echo $stock_watched[$i][0]; ?></span>
                                                <a href="#"><?php echo $stock_watched[$i][2]; ?><br><p><?php echo $stock_watched[$i][1]; ?> Following</p></a>
                                            </li>

                                    <?php

                           
                        }

                     if($i == 4){
                        echo "<div class='hide-show watched-hidden-content'>";
                    }
                   
                }

           

                    echo "</div>";
            
            ?>  

            </ul>

                       
               
    </div>
    <!-- <div class="to-bottom-seemore" style="display: inline-flex;">
        <i class="fas fa-sort-down" style="
        font-size: 16px;
        margin-right: 3px;
        vertical-align: initial;
    "></i>
        <div class="see-more-btn button-toggle-content">
            <strong>See more</strong>
        </div>
    </div> -->
    <div class="to-bottom-seemore" style="display: inline-flex;color: #cecece;font-size: 13px;">
        <div class="see-more-btn button-toggle-content">
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
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
// $(document).ready(function(){
// 	$('.button-toggle-content').on('click', function(){
// 		$('.watched-hidden-content').toggle();
// 	});
// });
$(document).ready(function(){
    $(".button-toggle-content").click(function () {
        $(".watched-hidden-content").toggle('slow');
        if($(".button-toggle-content").hasClass('isopen')){
            $(".button-toggle-content").html('<i class="fas fa-sort-down" id="fa-up" style="bottom: 0px;top: -2px;position: relative;font-size: 16px;margin-right: 4px;vertical-align: initial;"></i><strong>Show more</strong>').removeClass('isopen').slideDown( "slow" );
            $(".watched-hidden-content").slideUp( "slow" );
        }else {
            $(".button-toggle-content").html('<i class="fas fa-sort-up" id="fa-up" style="bottom: 0;top: 4px;position: relative;font-size: 16px;margin-right: 4px;vertical-align: initial;"></i><strong>Hide</strong>').addClass('isopen');
            $(".watched-hidden-content").slideDown( "slow" );
        }
    });
});
</script>

<style type="text/css">
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
        color: #fff;
        font-weight: 500;
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
   .top-stocks {
    background-color: #142b46;
}
    .top-stocks .to-top-title {
        padding-top: 10px !important;
        padding-left: 15px !important;
        padding-bottom: 0 !important;
    }
    .to-bottom-seemore {
        padding: 0px 0px 8px 16px;
        font-size: 12px !important;
        font-weight: 300 !important;
        cursor: pointer;
        color: #d8d8d8 !important;
    }
    .see-more-btn, .see-more-btn a {
        color: #d8d8d8 !important;
    }
    .hide-show {
        display: none;
    }
    .right-dashboard-part {
        float: left;
        width: 27%;
        padding: 21px 0px !important;
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
    }
    .gravatar .avatar .avatar-80 .um-avatar .um-avatar-default {
        top: 17px !important;
        bottom: 8px !important;
        position: relative !important;
    }

	.to-content-part {
	    background: #142c46;
	    padding:4px;
	}

	hr.style14.style13 {
    display: none;
}



</style>
