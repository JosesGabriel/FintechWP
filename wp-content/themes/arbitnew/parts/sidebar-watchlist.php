<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.3/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.6/nv.d3.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.9/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-nvd3/1.0.9/angular-nvd3.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.6/nv.d3.css">
<?php

global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;

$ismetadis = get_user_meta($userID, '_watchlist_instrumental', true);

?>
<script>
  if (typeof angular !== 'undefined') {
    var app = angular.module('arbitrage_wl', ['nvd3']);

    <?php
    if ($ismetadis) {
      foreach ($ismetadis as $key => $value) {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, '/wp-json/data-api/v1/charts/history?symbol=' . $value['stockname'] . '&exchange=PSE&resolution=1D&from=' . date('Y-m-d', strtotime("-20 days")) . '&to=' . date('Y-m-d'));

        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $dhistofronold = curl_exec($curl);
        curl_close($curl);


        $dhistoforchart = json_decode($dhistofronold);
        $dhistoforchart = $dhistoforchart->data;

        $dhistoflist = "";
        $counter = 0;

        if (isset($dhistoforchart->o) && is_array($dhistoforchart->o)) {
          for ($i = 0; $i < (count($dhistoforchart->o)); $i++) {
            // if ($i > 3) {
            $dhistoflist = '{"date": ' . ($i + 1) . ', "open": ' . $dhistoforchart->o[$i] . ', "high": ' . $dhistoforchart->h[$i] . ', "low": ' . $dhistoforchart->l[$i] . ', "close": ' . $dhistoforchart->c[$i] . '},' . $dhistoflist;
            $counter++;
            // }
          }
        }

        ?>

        app.controller('minichartarb<?php echo strtolower($value['stockname']); ?>', function($scope) {
          $scope.options = {
            chart: {
              type: 'candlestickBarChart',
              height: 50,
              width: 120,
              margin: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
              },
              interactiveLayer: {
                tooltip: {
                  enabled: false
                }
              },
              x: function(d) {
                return d['date'];
              },
              y: function(d) {
                return d['close'];
              },
              duration: 100,
              zoom: {
                enabled: true,
                scaleExtent: [1, 10],
                useFixedDomain: false,
                useNiceScale: false,
                horizontalOff: false,
                verticalOff: true,
                unzoomEventType: 'dblclick.zoom'
              }
            }
          };

          $scope.data = [{
            values: [<?php echo $dhistoflist; ?>]
          }];
        });
    <?php }
    } ?>
  }
</script>

<script type="text/javascript">
  jQuery(function() {

    var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
    var dcount = 0;
    jQuery('.to-watch-data .to-stock a span').each(function(index, el) {
      if (dcount == '10') {
        dcount = 0;
      }
      jQuery(el).css('border-color', colors[dcount]);
      dcount++;
    });
  });
</script>
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

        <div id="tableStock" class="table table-striped">
          <!--Table body-->
          <div class="even" style="max-height: 302px;display: block;overflow: hidden;">


            <?php if ($ismetadis) : ?>
              <?php foreach ($ismetadis as $key => $value) { ?>

                <?php

                      $dstock = $value['stockname'];
                      $dprice = 0;
                      $dchange = 0;
                      foreach ($stockinfo as $stkey => $stvals) {
                        if ($stvals->symbol == $dstock) {
                          $dprice = number_format($stvals->last, 2, '.', ',');
                          $dchange = number_format($stvals->changepercentage, 2, '.', ',');
                        }
                      }

                      $dyellow = '0.00';

                      ?>

                <?php if ($value['stockname'] != null) {  
                  ?>



                  <div class="to-watch-data" data-dstock="<?php echo $value['stockname']; ?>">

                          <div class="to-left-watch" style="position: relative;float: left;display: table-cell;vertical-align: middle;top: 3px;">
                            <div class="to-stock" style="display: inline-block;position: relative;bottom: 11px;padding: 0 5px;">
                              <a style="color: #fff;" href="/chart/<?php echo $value['stockname']; ?>" target="_blank">
                                <span style="height: 40px;width: 40px;line-height: 40px;font-size: 11px !important;text-align: center;display: block;border-radius: 25px;border:2px solid;height: 43px;width: 43px;"><?php echo $value['stockname']; ?></span>
                              </a>
                            </div>


                            <div class="minichartt" style="display: inline-block !important;top: 8px;position: relative;">
                              <a href="/chart/<?php echo $value['stockname']; ?>" target="_blank" class="stocklnk"></a>
                              <div ng-controller="minichartarb<?php echo strtolower($value['stockname']); ?>">
                                <!--<nvd3 options="options" data="data" class="with-3d-shadow with-transitions"></nvd3>-->
                                <div class="floatingdiv" id="chartdiv<?php echo $value['stockname']; ?>"></div>
                              </div>
                            </div>
                          </div>


                          <?php if (strpos($dchange, '-') !== false) : ?>
                            <div class="dbox-cont" style="float:right;display: inline-block !important;position: relative;top: 23px;padding: 0px 7px 1px 0px;text-align: right;">
                              <div class="stocknum_<?php echo $value['stockname']; ?>" style="font-family: 'Lato', sans-serif;text-align: right;margin-bottom: 2px;font-size: 17px;"><?php echo $dprice; ?></div>
                              <div class="dbox red">
                                <div class="stockperc_<?php echo $value['stockname']; ?>" style="color: #e64c3c;"><?php echo $dchange; ?>%</div>
                              </div>
                            </div>
                          <?php elseif ($dchange === $dyellow) : ?>
                            <div class="dbox-cont" style="float:right;display: inline-block !important;position: relative;top: 23px;padding: 0px 7px 1px 0px;text-align: right;">
                              <div class="stocknum_<?php echo $value['stockname']; ?>" style="font-family: 'Lato', sans-serif;text-align: right;margin-bottom: 2px;font-size: 17px;"><?php echo $dprice; ?></div>
                              <div class="dbox green" style="text-align:right;">
                                <div class="stockperc_<?php echo $value['stockname']; ?>" style="color: #FFC107;"><?php echo $dchange; ?>%</div>
                              </div>
                            </div>
                          <?php elseif (strpos($dchange, '-') !== true) : ?>
                            <div class="dbox-cont" style="float:right;display: inline-block !important;position: relative;top: 23px;padding: 0px 7px 1px 0px;text-align: right;">
                              <div class="stocknum_<?php echo $value['stockname']; ?>" style="font-family: 'Lato', sans-serif;text-align: right;margin-bottom: 2px;font-size: 17px;"><?php echo $dprice; ?></div>
                              <div class="dbox green" style="text-align:right;">
                                <div class="stockperc_<?php echo $value['stockname']; ?>" style="color: #25ae5f"><?php echo $dchange; ?>%</div>
                              </div>
                            </div>

                          <?php endif; ?>
                  </div>


              <?php }
                  } ?>


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
<?php include_once "watchlist/footer-files.php";?>