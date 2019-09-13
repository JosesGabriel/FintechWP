<?php 

              
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE");
        //curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
        curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response !== false) {
            $response = json_decode($response);
            $stockinfo = $response->data;
        }
        $i = 0;

        $today = date('Y-m-d');

        foreach($stockinfo as $stkey => $stvals){

           
            $new_date = date('Y-m-d', strtotime($stvals->lastupdatetime));

                //if($today == $new_date){

                    $stock[$i][0] = $stvals->symbol;
                    $stock[$i][1] = $stvals->changepercentage;
                    $stock[$i][2] = $stvals->description;
                    $stock[$i][3] =  $new_date; //$stvals->lastupdatetime;
                    $i++;            
                //}
        }

        usort($stock, function($a, $b) {
            return new DateTime($a[3]) <=> new DateTime($b[3]);
        });


            // usort($stock, function($a, $b) {
             //   return $b[1] <=> $a[1];
           // });

?>
    
    <div class="top-stocks">
    <div class="to-top-title gainers-title"><strong>Top Gainers </strong></div>
    <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
    <div class="to-content-part gainers">

             <ul>
                       <?php for($j=0; $j < 5; $j++) {?> 
                            <li class="odd">
                                <span><?php echo $stock[$j][0]; ?></span>

                                <a href="#"><?php echo $stock[$j][2]; ?><br><p style="color: #53b987 !important;"><?php echo number_format($stock[$j][1], 2, '.', ','); ?>%</p> <p><?php echo $stock[$j][3]; ?></p></a>

                            </li>
                        <?php } ?>
            </ul>
                      
               
    </div>
    <div class="to-top-title losers-title"><strong>Top Losers</strong></div>
    <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
    <div class="to-content-part losers">

    <?php 
        usort($stock, function($a, $b) {
                return $a[1] <=> $b[1];
            });
    ?>

             <ul>
                       <?php for($j=0; $j < 5; $j++) {?> 
                            <li class="odd">
                                <span><?php echo $stock[$j][0]; ?></span>
                                <a href="#"><?php echo $stock[$j][2]; ?><br><p style="color: #eb4d5c !important;"><?php echo number_format($stock[$j][1], 2, '.', ','); ?>%</p></a>
                            </li>
                        <?php } ?>
            </ul>

    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>

$(document).ready(function(){
    $(".gainers-title").click(function () {
        
        if($('.gainers').css('display') == 'none'){
            $('.gainers').slideDown();
        }else {
             $('.gainers').slideUp();
        }
    });

    $(".losers-title").click(function () {
        
        if($('.losers').css('display') == 'none'){
            $('.losers').slideDown();
        }else {
             $('.losers').slideUp();
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

    .gainers-title:hover, .losers-title:hover {
        cursor: pointer;
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
