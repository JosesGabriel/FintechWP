
<script type="text/javascript">

  function lateststocks(symbol){

         jQuery.ajax({
            url: "/wp-json/data-api/v1/stocks/list",
            type: 'GET',
            success: function(res) {

                  jQuery.each(res.data, function(index, value) {
                      if(symbol == value.symbol){
                        $('.description a').text(value.description);
                      }
                  });
            },
            error: function (xhr, ajaxOptions, thrownError) {

            }
        });

    }

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
 


});

</script>

<div class="top-stocks">
    <div class="to-top-title"><strong>Most Watched Stocks</strong></div>
    <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
    <div class="to-content-part">

<?php 

global $wpdb;     

$count = 0;
$counter = 0;
$stock_watched[0][0] = '';
$stock_watched[0][1] = 1;

$watchlist = $wpdb->get_results('select meta_value from arby_usermeta where meta_key = "_watchlist_instrumental" ');
    
  foreach ($watchlist as $mkey => $mvalue) { 

    $metadata = unserialize($mvalue->meta_value); 
    $count_watchlist = 1; 

      foreach ($metadata as $key => $value) {      
          $x = 0;

          if($counter == 0) {          
                $stock_watched[$count][0] = $value['stockname'];
                $count++;                  
          }else{

              for ($i=0; $i < $count ; $i++) { 
                    if($stock_watched[$i][0] == $value['stockname']){ 
                          if($stock_watched[$i][1] != '' ? $stock_watched[$i][1]++ : $stock_watched[$i][1] =  $count_watchlist );
                          $x = 1; 
                    }
              }
              
              if($x == 0){
                  $stock_watched[$count][0] = $value['stockname'];
                  $count++;
              }
              
          }
     
      }

      $counter++;
  }
   
 usort($stock_watched, function($a, $b) {
    return $b[1] <=> $a[1];
 });

 ?>
     <ul>
     <?php

     for($i = 0; $i < 10; $i++){

         if($stock_watched[$i][0] != null && $stock_watched[$i][0] != ""){
            $stockname = $stock_watched[$i][0];
              ?>
                      <li class="odd">
                          <span><?php echo $stock_watched[$i][0]; ?></span>
                          <a href="#" class="description"><?php echo "<script> lateststocks('$stockname');</script>"; ?><br><p><?php echo $stock_watched[$i][1]; ?> Following</p></a>
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

