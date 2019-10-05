
<script type="text/javascript">

jQuery(function(){
  

  var vstocks = [];
  var i=0;

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

 $.ajax({
    url: "/wp-json/data-api/v1/stocks/history/latest?exchange=PSE",
    type: 'GET',
    dataType: 'json', // added data type
    success: function(res) {
    
       jQuery.each(res.data, function(i, val) {

       <?php


       ?>

        });
    },
    error: function (xhr, ajaxOptions, thrownError) {
        
    }
});

   

});



</script>

<?php 

$stocks = $_GET['stocks'];

?>

<div class="top-stocks">
    <div class="to-top-title"><strong>Most Watched Stocks</strong></div>
    <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
    <div class="to-content-part">

        <?php 
       
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "/wp-json/data-api/v1/stocks/history/latest?exchange=PSE");
        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($stocks !== false) {
                $response = json_decode($stocks);
                $stockinfo = $response->data;
            }

        $num = 0;
        $counter = 1;
        $stockcount = 0;
        //$stock_watched = array();      
        $users = get_users( array( 'fields' => array( 'ID' ) ) );

        foreach($stocks as $stkey => $stvals){
        
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

