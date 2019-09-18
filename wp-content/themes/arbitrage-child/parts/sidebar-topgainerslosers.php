<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/watchlist_style.css?<?php echo time(); ?>">

<script>
    jQuery(document).ready( function() {

        $.ajax({
              type:'GET',
              url:'https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE',
              dataType: 'json',
              success: function(response) {
                    //jQuery.each(response.data, function(i, val) {
                        var stock = response.data;
                       // console.log(stock);
                     //});
                },
                error: function(response) {
                    console.log(response);
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

        $myArray = json_decode($_GET['stock']);

        print_r($myArray);


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

