<script>
  function load_watchlist(userid){

    $.ajax({
      url: "/wp-json/watchlist-api/v1/watchlists?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
             success: function(res) {
                
                 jQuery.each(res.data, function(index, value) {
                    $('.stocknum_' + value.stockname).text((value.last).toFixed(2));
                    $('.stockperc_' + value.stockname).text((value.change).toFixed(2));
                   // console.log(value.change);

                 });


            },error: function (xhr, ajaxOptions, thrownError) {
                
            }
    });
  }


</script>


<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.3/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.6/nv.d3.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.9/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-nvd3/1.0.9/angular-nvd3.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.6/nv.d3.css"> -->
<?php

global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;

$ismetadis = get_user_meta($userID, '_watchlist_instrumental', true);

?>

<?php
// $dwatchinfo = null;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, '/wp-json/data-api/v1/stocks/history/latest?exchange=PSE');
//

curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$dwatchinfo = curl_exec($curl);
curl_close($curl);


// added false
if ($dwatchinfo !== null) :
  $genstockinfo = json_decode($dwatchinfo);
  $stockinfo = $genstockinfo->data;
  ?>
  <div class="watch-list" style="margin-top:10px;">
    <div class="watch-list-inner">

      <div class="to-top-title">Watchlist
        <div class="dplsicon"><a href="/watchlist/"> <i class="fa fa-plus-circle"></i></a></div>
      </div>
      <hr class="style14 style15">
      <div class="to-content-part">

        <div id="tableStock" class="table table-striped sidewatchlist">
          <!--Table body-->
          <div class="even" style="max-height: 302px;display: block;overflow: hidden;">


            <?php if ($ismetadis) : ?>


            <?php else : ?>
              <div class="to-content-part">
                <a href="/watchlist/">
                  <div class="dplusbutton" style="text-align: center; color: #6583a8">
                    <div class="dplsicons" style="font-size: 36px;margin-bottom: 11px;">
                      <i class="fa fa-plus-circle" style="color: #6583a8;"></i>
                    </div>
                    <div class="dplstext" style="size: 14px;">Add watchlist
                    </div>
                  </div>
                </a>
              </div>

            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="to-bottom-seemore" style="padding: 0 0 10px 16px;">
        <?php if ($value['stockname'] != null) { ?>
          <a href="/watchlist/">
            <strong class="view__all">View all</strong>
          </a>
        <?php } ?>
      </div>
    <?php endif; ?>
    </div>
  </div>
