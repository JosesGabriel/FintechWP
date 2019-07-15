<?php

global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;

$ismetadis = get_user_meta($userID, '_watchlist_instrumental', true);

function working_days_ago($days) {
	$count = 0;
	$day = strtotime('-2 day');
	while ($count < $days || date('N', $day) > 5) {
	   $count++;
	   $day = strtotime('-1 day', $day);
	}
	return date('Y-m-d', $day);
}

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

?>
<script>
if (typeof angular !== 'undefined') {
	var app = angular.module('arbitrage_wl', ['nvd3']);

	<?php
	if ($ismetadis) {
	foreach ($ismetadis as $key => $value) {
		// get stcok history
		// $curl = curl_init();
		// curl_setopt($curl, CURLOPT_URL, 'https://chart.pse.tools/api/history2?symbol='.$value['stockname'].'&firstDataRequest=true&from='.working_days_ago('9') );
		// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		// $dhistofronold = curl_exec($curl);
		// curl_close($curl);

		// $dhistoforchart = json_decode($dhistofronold);

		// $dhistoflist = "";
		// for ($i=0; $i < (count($dhistoforchart->o)); $i++) {
		// 	$dhistoflist .= '{"date": '.($i + 1).', "open": '.$dhistoforchart->o[$i].', "high": '.$dhistoforchart->h[$i].', "low": '.$dhistoforchart->l[$i].', "close": '.$dhistoforchart->c[$i].'},';
		// }

    // get stcok history
      // $curl = curl_init();
      // curl_setopt($curl, CURLOPT_URL, 'https://chart.pse.tools/api/history2?symbol='.$value['stockname'].'&firstDataRequest=true&from='.working_days_ago('20') );
      // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      // $dhistofronold = curl_exec($curl);
      // curl_close($curl);

      $dhistoforchart = json_decode($dhistofronold);

      $dhistoflist = "";
      $counter = 0;
      for ($i=0; $i < (count($dhistoforchart->o)); $i++) {
        if ($i > 3) {
          $dhistoflist .= '{"date": '.($i + 1).', "open": '.$dhistoforchart->o[$i].', "high": '.$dhistoforchart->h[$i].', "low": '.$dhistoforchart->l[$i].', "close": '.$dhistoforchart->c[$i].'},';
        $counter++;
        }

      }

      $currentTime = (new DateTime())->modify('+1 day');
      $startTime = new DateTime('15:30');
      $endTime = (new DateTime('09:00'))->modify('+1 day');



      if ($currentTime >= $startTime && $currentTime <= $endTime) {
          // $curl = curl_init();
          // curl_setopt($curl, CURLOPT_URL, 'https://chart.pse.tools/api/intraday/?symbol='.$value['stockname'].'&firstDataRequest=true&from='.date('Y-m-d') );
          // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          // $dintrabase = curl_exec($curl);
          // curl_close($curl);

        $dintraforchart = json_decode($dintrabase);
          if (isset($dintraforchart->o)) {
            $open = end($dintraforchart->o);
            $high = end($dintraforchart->h);
            $low = end($dintraforchart->l);

            $dhistoflist .= '{"date": '.($counter + 1).', "open": '.$open.', "high": '.$high.', "low": '.$low.', "close": 0},';
          }
      }
	?>
	// console.log("<?php echo working_days_ago('9'); ?>");

	app.controller('minichartarb<?php echo strtolower($value['stockname']); ?>', function($scope) {
		$scope.options = {
				chart: {
					type: 'candlestickBarChart',
					height: 50,
					width: 120,
					margin : {
						top: 0,
						right: 0,
						bottom: 0,
						left: 0
					},
					interactiveLayer: {
						tooltip: { enabled: false }
					},
					x: function(d){ return d['date']; },
					y: function(d){ return d['close']; },
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

		$scope.data = [{values: [<?php echo $dhistoflist; ?>]}];
	});
	 <?php }
   } ?>
}
</script>

<script type="text/javascript">

jQuery(function(){

  function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  };
  var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
  var dcount = 0;
  jQuery('.to-watch-data .to-stock a span').each(function(index,el){
    if (dcount == '10') {dcount = 0; }
    jQuery(el).css('border-color',colors[dcount]);
    dcount++;
  });
});

</script>
<style type="text/css">
  .to-watch-data {
    border-bottom: #1e3554 solid 1px;
    /*display: table-cell;
    vertical-align: middle;*/
    min-height: 76px;/*
    background: #123;*/
  }
  .to-watch-data.to-stock {
    display: inline-block !important;
  }
  .to-watch-data.minichartt {

  }
  .to-watch-data.dbox-cont {
    display: inline-block !important;
  }
  .to-watch-data:last-child {
    border-bottom: none;
}
  .table-striped tbody tr:nth-of-type(odd) {
    background-color: #142c46 !important;
  }
</style>
<?php
  $dwatchinfo = null;
  // $curl = curl_init();
  //
  // curl_setopt($curl, CURLOPT_URL, 'https://api2.pse.tools/api/quotes' );
  // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  // $dwatchinfo = curl_exec($curl);
  // curl_close($curl);

  // added false
  if ($dwatchinfo !== null):
  $genstockinfo = json_decode($dwatchinfo);
  $stockinfo = $genstockinfo->data;
?>
<div class="watch-list">
    <div class="watch-list-inner">

        <div class="to-top-title">Watchlist
            <div class="dplsicon" style="display: none;"><a href="/watchlist/"> <i class="fa fa-plus-circle"></i></a></div>
        </div>
        <hr class="style14 style15" style="width: 90% !important;margin-bottom: 0px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
        <div class="to-content-part">

            <div id="tableStock" class="table table-striped">
                   <!--Table body-->
                  <div class="even" style="max-height: 302px;display: block;overflow: hidden;">


                  <?php if ($ismetadis): ?>
                    <?php foreach ($ismetadis as $key => $value) { ?>

                        <?php

                          $dstock = $value['stockname'];
                          $dprice = number_format( $stockinfo->$dstock->last, 2, '.', ',' );
                          $dchange = number_format( $stockinfo->$dstock->change, 2, '.', ',' );
                          $dyellow = '0.00';

                        ?>


                      <div class="to-watch-data" data-dstock="<?php echo $value['stockname']; ?>">

                        <div class="to-left-watch" style="position: relative;float: left;display: table-cell;vertical-align: middle;top: 3px;">
                          <div class="to-stock" style="display: inline-block;position: relative;bottom: 11px;padding: 0 5px;">
                            <a style= "color: #fff;" href="https://arbitrage.ph/chart/<?php echo $value['stockname']; ?>" target="_blank">
                              <span style="height: 40px;width: 40px;line-height: 40px;font-size: 11px !important;text-align: center;display: block;border-radius: 25px;border:2px solid;height: 43px;width: 43px;"><?php echo $value['stockname']; ?></span>
                            </a>
                          </div>
                          <div class="minichartt" style="display: inline-block !important;top: 8px;position: relative;">
                            <a href="https://arbitrage.ph/chart/<?php echo $value['stockname']; ?>" target="_blank" class="stocklnk"></a>
                            <div ng-controller="minichartarb<?php echo strtolower($value['stockname']); ?>">
                                <nvd3 options="options" data="data" class="with-3d-shadow with-transitions"></nvd3>
                            </div>
                          </div>
                        </div>


                        <?php if (strpos($dchange, '-') !== false): ?>
                          <div class="dbox-cont" style="float:right;display: inline-block !important;position: relative;top: 23px;padding: 0px 7px 1px 0px;text-align: right;">
                              <div class="stocknum" style="font-family: 'Lato', sans-serif;text-align: right;margin-bottom: 2px;font-size: 17px;"><?php echo $dprice; ?></div>
                              <div class="dbox red">
                                <div class="stockperc" style="color: #e64c3c;"><?php echo $dchange; ?>%</div>
                              </div>
                          </div>
                        <?php elseif($dchange === $dyellow): ?>
                          <div class="dbox-cont" style="float:right;display: inline-block !important;position: relative;top: 23px;padding: 0px 7px 1px 0px;text-align: right;">
                              <div class="stocknum" style="font-family: 'Lato', sans-serif;text-align: right;margin-bottom: 2px;font-size: 17px;"><?php echo $dprice; ?></div>
                              <div class="dbox green" style="text-align:right;">
                                <div class="stockperc" style="color: #FFC107;"><?php echo $dchange; ?>%</div>
                              </div>
                          </div>
                        <?php elseif(strpos($dchange, '-') !== true): ?>
                          <div class="dbox-cont" style="float:right;display: inline-block !important;position: relative;top: 23px;padding: 0px 7px 1px 0px;text-align: right;">
                              <div class="stocknum" style="font-family: 'Lato', sans-serif;text-align: right;margin-bottom: 2px;font-size: 17px;"><?php echo $dprice; ?></div>
                              <div class="dbox green" style="text-align:right;">
                                <div class="stockperc" style="color: #25ae5f"><?php echo $dchange; ?>%</div>
                              </div>
                          </div>

                        <?php endif; ?>
                      </div>


                        <?php } ?>

<!-- <div class="minichartt" style="    display: inline-block !important;top: 5px;position: relative; ">
                            <a href="https://arbitrage.ph/chart/<?php echo $value['stockname']; ?>" target="_blank" class="stocklnk"></a>
                            <div ng-controller="minichartarb<?php echo strtolower($value['stockname']); ?>">
                                <nvd3 options="options" data="data" class="with-3d-shadow with-transitions"></nvd3>
                            </div>
                          </div> -->

                  <?php else: ?>
                  <div class="to-content-part">
                      <a href="https://arbitrage.ph/watchlist/">
                        <div class="dplusbutton" style="text-align: center; color: #6583a8">
                            <div class="dplsicons" style="font-size: 36px;margin-bottom: 11px;">
                              <i class="fa fa-plus-circle" style="color: #6583a8;"></i>
                            </div>
                            <div class="dplstext" style="size: 14px;">Add watchlist
                            </div>
                         </div>
                    </a>
                  </div>

                          <style type="text/css">

                            .dplsicon {
                            display: none !important;

                        }

                            .side-header {
                            border-bottom: none  !important;
                          }

                        .dplusbutton {
                            color: #fff;
                        }

                        .top-traiders .to-content-part {
                            background: #0d1f33 !important;
                            padding: 15px;
                        }

                        .side-content {
                            background: rgba(44, 62, 80, 0) !important;
                            border-radius: 0px 0px 5px 5px !important;
                            padding: 3px 0px 0px 0px !important;
                        }

                        .side-content ul li {
                            background: rgba(255, 255, 255, 0) !important;
                        }
                        .watch-list {
                        	background: #142c46 !important;
    						          margin-top: 11px !important;
                        }
                        .adsbygoogle {
                          background: #142c46;
                          display: block !important;
                          margin-top: 15px;
                          border-radius: 5px;
                          overflow: hidden;
                           padding-bottom: 8px;
                          /* padding: 10px 15px 15px 15px; */
                        }
                        .adsbygoogle .to-top-title {
                          padding-top: 6px;
                            padding-left: 13px;
                            padding-right: 13px;
                            padding-bottom: 0;
                            margin-bottom: 5px;
                        }
                        .see-more-btn a:hover {
                          text-decoration: none !important;
                        }
                          </style>
                        

                  <?php endif; ?>
        </div>
        
        <div class="see-more-btn" style="padding: 0 0 10px 16px;">

          <?php if($value['stockname'] != null) { ?>
              <a href="https://arbitrage.ph/watchlist/">
              <strong style="font-size:13px;font-weight: 400;">View all</strong>
              </a>
          <?php } ?>
        </div>
        
    </div>
</div>
          <?php endif; ?>
</div>
