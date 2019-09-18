<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/watchlist_style.css?<?php echo time(); ?>">

<script>
    jQuery(document).ready( function() {

        $.ajax({
              type:'GET',
              url:'https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE',
              dataType: 'json',
              //data: "stockss="+JSON.stringify(data),
              success: function(response) {

                  // var myJSON = JSON.stringify(response);
                    var stocks = [];
                    var stocks2 = [];
                    var i = 0;
                    var d = new Date();
                    var curr_date = d.getDate();
                    var curr_month = d.getMonth() + 1; //Months are zero based
                    var curr_year = d.getFullYear();
                    var dt = curr_year + "-" + curr_month + "-" + curr_date;
                    var cur_d;
                    var cur_m;
                    var cur_y;

                   // console.log(dt);
                    jQuery.each(response.data, function(i, val) {
                        stocks[i] = [];
                        stocks[i][0] = val.symbol;
                        stocks[i][1] = val.changepercentage;
                        stocks[i][2] = val.description;
                        var ltime = val.lastupdatetime;
                        var ltime2 = ltime.split('T');
                        stocks[i][3] = new Date(ltime2[0]);                        
                        i++;
                    });

                    stocks.sort(function(a, b){
                        return b[3] - a[3];
                    });

                    var sdate = new Date(stocks[0][3]);
                    var new_day = sdate.getDate();
                    var new_mo = sdate.getMonth() + 1;
                    var new_yr = sdate.getFullYear();
                
                    var n = 0;

                    do {
                        cur_d = stocks[n][3].getDate();
                        cur_m = stocks[n][3].getMonth() + 1;
                        cur_y = stocks[n][3].getFullYear();
                        stocks2[n] = [];
                        stocks2[n][0] = stocks[n][0];
                        stocks2[n][1] = stocks[n][1]; 
                        stocks2[n][2] = stocks[n][2];  
                        stocks2[n][3] = stocks[n][3]; 
                        //console.log(stocks[n][3]);
                        n++;
                    }while(new_day == cur_d && new_mo == cur_m && new_yr == cur_y);

                    stocks2.sort(function(a, b){
                        return b[1] - a[1];
                    });

                    for (var i = 0; i < 10; i++) {
                        console.log(stocks2[i][0] + ' - ' + stocks2[i][1].toFixed(2) + ' - ' + stocks2[i][3]);
                    }


                },
                error: function(response) {
                    
                }
            });
     });

</script>

<?php 
             
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE");
        curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.199.140.243']);
        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

       // $myArray = $_COOKIE['myArray'];
        //$myArray1 = json_decode($myArray);
        //$stockss = $myArray1->data;
        //print_r($stockss);
        //$myArray1 = json_decode($myArray);

        // foreach($stockss as $stkey => $stockval){

              //  echo $stockval->symbol;

         //   }


        if ($response !== false) {
            $response = json_decode($response);
            $stockinfo = $response->data;
        }
        $i = 0;
        $y = 0;
        
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime( '-1 days' ) );

        foreach($stockinfo as $stkey => $stvals){
          
           $new_date = date('Y-m-d', strtotime($stvals->lastupdatetime));
                    $stock[$i][0] = $stvals->symbol;
                    $stock[$i][1] = $stvals->changepercentage;
                    $stock[$i][2] = $stvals->description;
                    $stock[$i][3] =  $new_date; 
                    $i++;     
            }

            usort($stock, function($a, $b) {
                return $b[3] <=> $a[3];
            });
                 $sdate = $stock[0][3];
            do {

                    $stocky[$y][0] = $stock[$y][0];
                    $stocky[$y][1] = $stock[$y][1];
                    $stocky[$y][2] = $stock[$y][2];
                    $stocky[$y][3] = $stock[$y][3];
                    $y++;
            }while ($sdate == $stock[$y][3]);
            
             usort($stocky, function($a, $b) {
                return $b[1] <=> $a[1];
            });

?>
    
    <div class="top-stocks">
            <div class="to-top-title gainers-title"><strong>Top Gainers </strong></div>

           <!-- <div><?php //print_r($myArray->symbol); ?></div>-->

            <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
            <div class="to-content-part gainers">

                     <ul>
                               <?php for($j=0; $j < 5; $j++) {

                                     if($stocky[$j][1] != null){
                                            ?> 

                                        <li class="odd">
                                            <span><?php echo $stocky[$j][0]; ?></span>

                                            <a href="#"><?php echo $stocky[$j][2]; ?><br><p style="color: #53b987 !important;"><?php echo number_format($stocky[$j][1], 2, '.', ','); ?>%</p></a>

                                        </li>

                                <?php }  ?>
                                       
                                    <?php
                                       
                                    }
                                 ?>
                    </ul>                          
                       
            </div>          

</div>
<div class="top-stocks">

    <div class="to-top-title losers-title"><strong>Top Losers</strong></div>
            <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
            <div class="to-content-part losers">

            <?php 

                usort($stocky, function($a, $b) {
                        return $a[1] <=> $b[1];
                    });
            ?>

                     <ul>
                              <?php for($j=0; $j < 5; $j++) {
 
                                 if($stocky[$j][1] != null){
                                        ?> 
                                    <li class="odd">
                                        <span><?php echo $stocky[$j][0]; ?></span>
                                        <a href="#"><?php echo $stocky[$j][2]; ?><br><p style="color: #eb4d5c !important;"><?php echo number_format($stocky[$j][1], 2, '.', ','); ?>%</p></a>
                                    </li>
                                <?php } ?>
                                 
                                    <?php
                                     
                                    }
                                ?>
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

