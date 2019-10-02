<?php
  /*
  * Template Name: Minichart Section
  * Template page for Dashboard Social Platform
  */

// get_header();
global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
get_header( 'dashboard' );

  $topargs = array(
      'role'          =>  '',
      // 'meta_key'      =>  'account_status',
      // 'meta_value'    =>  'approved'
  );

  $users = get_users($topargs);
  $newuserlist = array();
  foreach ($users as $key => $value) {
    $userdetails['id'] = $value->ID;
    $userdetails['displayname'] = (!empty($value->data->display_name) ? $value->data->display_name : $value->data->user_login);
    $userdetails['followers'] = UM()->Followers_API()->api()->count_followers( $value->ID );
    $userdetails['user_nicename'] = $value->data->user_nicename;

    array_push($newuserlist, $userdetails);
  }

  usort($newuserlist, function($a, $b) {
      return $a['followers'] <=> $b['followers'];
  });
  $toptraiders = array_reverse($newuserlist);


?>

<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,600i" rel="stylesheet">
<style type="text/css">
    .btn-tradelog {
        border-radius: 0px;
        margin: 10px 0px;
        background: #273647;
        border: 1px solid #273647;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
    }

    .side-header .right-image .onto-user-name {
        margin-bottom: 5px;
        font-family: 'Montserrat', sans-serif;
        text-transform: capitalize !important;
    }

    .watch-list{
      margin-top: 15px;
    }
</style>



<div id="main-content" class="ondashboardpage">

  <div class="inner-placeholder">
    <div class="inner-main-content">
      <div class="left-dashboard-part">
        <div class="dashboard-sidebar-left">
          <div class="dashboard-sidebar-left-inner">
            <div class="left-user-details">
              <div class="left-user-details-inner">
                <div class="side-header">
                  <div class="left-image">
                    <div class="user-image" style="background: url('<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>') no-repeat center center;">&nbsp;</div>
                  </div>
                  <div class="right-image">
                    <!-- <div class="onto-user-name"><?php //echo $current_user->display_name; ?></div>
                    <div class="onto-user-meta-details">100 Following</div> -->

                      <div class="onto-user-name"><?php echo um_user('full_name'); ?></div>
                      <div class="onto-user-meta-details">100 Following</div>
                  </div>
                </div>
                <div class="side-content">
                  <div class="side-content-inner">
                    <ul>
                      <li class="two"><a href="/chart/">Interactive Chart</a></li>
                      <li class="three"><a href="/journal/">Trading Journal</a></li>
                      <li class="five"><a href="/watchlist/">Watcher & Alerts</a></li>
                      <!-- <li class="four"><a href="#">Stock Screener</a></li> -->                     
                      <li class="one"><a href="#">Power Tools</a></li>
                      <!-- <li class="six"><a href="#">Paper Trade</a></li> -->
                      <!-- <li class="seven"><a href="#">Chat</a></li> -->
                      <!-- <li class="eight"><a href="#">Groups</a></li> -->
                      <!-- <li class="nine"><a href="#">Traders</a></li> -->
                    </ul>
                    <!-- <div class="side-content-enter-trade text-center">
                      <a class="btn btn-lg btn-primary btn-tradelog" href="/enter-trade/">Enter Trade</a>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>

            <div class="top-traiders">
              <div class="top-traiders-inner">
                <div class="to-top-title">Recommended Traders</div>
                <div class="to-content-part">
                  <div class="content-inner-part">
                    <?php
                      $i=0;
                      foreach ($toptraiders as $key => $value) { ?>
                        <div class="trader-item">
                          <div class="traider-inner">
                            <div class="traider-image">
                              <div class="side-image" style="background: url('<?php echo esc_url( get_avatar_url( $value['id'] ) ); ?>') no-repeat center center;">&nbsp;</div>
                            </div>
                            <div class="traider-details">
                              <div class="traider-name"><a href="/user/<?php echo $value['user_nicename']; ?>"><?php echo $value['displayname']; ?></a></div>
                              <div class="traider-follower">
                                <div class="onbfdata"><?php echo $value['followers']; ?> followers </div>
                                <div class="onbfollow">
                                  <a href="#" class="um-follow-btn um-button um-alt" data-user_id1="<?php echo $value['id']; ?>" data-user_id2="<?php echo $user->ID; ?>">Follow</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    <?php 
                        $i++;
                        if($i==5) break;
                      } 
                    ?>
                  </div>
                </div>
                <!-- <div class="to-bottom-title">
                  <a href="" class="to-view-more">View all traders</a>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="center-dashboard-part">
        <div class="inner-center-dashboard">
          <div class="add-post">
            <?php //echo do_shortcode('[ultimatemember_activity form_id=dashboardwall]'); ?>
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
            the_content();
            endwhile; else: ?>
            <p>Sorry, no posts matched your criteria.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="right-dashboard-part">
        <div class="right-dashboard-part-inner">
          <div class="watch-list">
            <div class="watch-list-inner">
              <?php
                $ismetadis = get_user_meta($userID, '_watchlist_instrumental', true);
              ?>
              <div class="to-top-title">Watchlist
              <div class="dplsicon" style="display: none;"><a href="/watchlist/"> <i class="fa fa-plus-circle"></i></a></div>
              <style type="text/css">
                    .dplsicon {
                    display: inline-block !important;
                    margin-left: 11em;
                }

                .dplsicon a {
                    color: #fff
                }
              </style>
              </div>
              <div class="to-content-part">
                <?php if ($ismetadis): ?>
                  <ul>
                    <?php foreach ($ismetadis as $key => $value) { ?>
                      <?php
                        // get current price and increase/decrease percentage
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, 'http://phisix-api4.appspot.com/stocks/'.$value['stockname'].'.json');
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $dwatchinfo = curl_exec($curl);
                        curl_close($curl);

                        $dstockinfo = json_decode($dwatchinfo);
                        $dinstall = get_object_vars($dstockinfo);


                        // get stcok history
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, 'http://pseapi.com/api/Stock/'.$value['stockname'].'/');
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $dwatchhisto = curl_exec($curl);
                        curl_close($curl);

                        $ddata = json_decode($dwatchhisto);
                        $ddata = array_reverse($ddata, true);

                        $dlisttrue = [];
                        $count = 0;
                        foreach ($ddata as $xbkey => $xbvalue) {
                          array_push($dlisttrue, $xbvalue);
                          if ($count == 5) {
                            break;
                          }
                          $count++;
                        }

                        $dstockinfo = [];
                        foreach (array_reverse($dlisttrue) as $stckkey => $stckvalue) {
                          $infodata = [];

                            array_push($infodata, $stckvalue->date);
                            array_push($infodata, $stckvalue->low);
                            array_push($infodata, $stckvalue->open);
                            array_push($infodata, $stckvalue->close);
                            array_push($infodata, $stckvalue->high);

                          array_push($dstockinfo, $infodata);
                        
                        }

                      ?>

                      <li class="even">
                        <div class="to-watch-data" data-dstock="<?php echo $value['stockname']; ?>" data-dhisto='<?php echo json_encode($dstockinfo); ?>'>
                          <div class="to-stock"><a style= "color: #fff;" href="/chart/<?php echo $value['stockname']; ?>" target="_blank"><?php echo $value['stockname']; ?></a></div>
                          
                          <?php if (strpos($dinstall['stock'][0]->percent_change, '-') !== false): ?>
                            <div class="dbox">
                             <div class="innerbox">
                                <div class="chartjs">
                                  <!-- <div id="chartContainer" style="height: 370px; max-width: 90px; margin: 0px auto;"></div> -->
                                      <div id="chart_div_<?php echo $value['stockname']; ?>" style="width: 120px; height: 120px;"></div>
                                </div>
                              </div>
                            </div>  
                            <div class="dbox">

                              <div class="innerbox">
                                <div class="stocknum">&#8369;<?php echo $dinstall['stock'][0]->price->amount; ?></div>
                                <!-- <div class="stockperc "><?php //echo $dinstall['stock'][0]->percent_change; ?>%</div> -->
                              </div>
                            </div>

                            <div class="dbox boxsred">
                              <div class="innerbox">
                                <!-- <div class="stocknum">Php <?php //echo $dinstall['stock'][0]->price->amount; ?></div> -->
                                <div class="stockperc "><?php echo $dinstall['stock'][0]->percent_change; ?>%</div>
                              </div>
                            </div>
                            <!-- <div class="to-numsec bered"><?php //echo $dinstall['stock'][0]->price->amount; ?></div> -->
                            <!-- <div class="to-persec bered"><?php //echo $dinstall['stock'][0]->percent_change; ?>%</div> -->
                          <?php else: ?>

                            <div class="dbox">
                            <div class="innerbox">
                                <div class="chartjs">
                                  
                                  <div id="chart_div_<?php echo $value['stockname']; ?>" style="width: 120px; height: 120px;">
                                    
                                   </div>
                                
                                </div>
                              </div>
                            </div>  
                            <div class="dbox">

                              <div class="innerbox">
                                <div class="stocknum">&#8369;<?php echo $dinstall['stock'][0]->price->amount; ?></div>
                                <!-- <div class="stockperc ">+<?php //echo $dinstall['stock'][0]->percent_change; ?>%</div> -->
                              </div>
                            </div>
                            <div class="dbox boxsgreen">
                              <div class="innerbox">
                                <!-- <div class="stocknum">Php <?php //echo $dinstall['stock'][0]->price->amount; ?></div> -->
                                <div class="stockperc ">+<?php echo $dinstall['stock'][0]->percent_change; ?>%</div>
                              </div>
                            </div>
                            <!-- <div class="to-numsec begreen"><?php //echo $dinstall['stock'][0]->price->amount; ?></div> -->
                            <!-- <div class="to-persec begreen">+<?php //echo $dinstall['stock'][0]->percent_change; ?>%</div> -->
                          <?php endif; ?>
                        </div>
                      </li>
                    <?php } ?>
                  </ul>
                <?php else: ?>
                        <div class="to-content-part">
                            <a href="/watchlist/">
                              <div class="dplusbutton" style="text-align: center; color: #fff">
                                  <div class="dplsicons" style="font-size: 36px;margin-bottom: 11px;">
                                    <i class="fa fa-plus-circle"></i></div>
                             <div class="dplstext" style="font-size: 14px;">Add watchlist
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
                          background: #2c3d500d !important;
                          padding: 15px;
                      }

                      .side-content {
                          background: rgba(44, 62, 80, 0) !important;
                          border-radius: 0px 0px 5px 5px !important;
                          padding: 10px 0px !important;
                          border: 1px solid #263646 !important;
                      }

                      .side-content ul li {
                          background: rgba(255, 255, 255, 0) !important;
                          
                      }
                        </style>

                <?php endif; ?>
              </div>
              <!-- <div class="to-bottom-title"> -->
                <!-- <a href="/watchlist/" class="to-add-more">Add More</a> -->
              <!-- </div> -->
            </div>
          </div>

          <div class="top-stocks">
            <div class="to-top-title">Trending Stocks</div>
            <div class="to-content-part">
              <ul>
                <li class="even"><a href="#">$IRC - IRC Properties, Inc.</a></li>
                <li class="odd"><a href="#">$MRC - MRC Allied, Inc.</a></li>
                <li class="even"><a href="#">$ABA - AbaCore Capital Holdings, Inc.</a></li>
                <li class="odd"><a href="#">$FOOD - Alliance Select Food  Int’l Inc.</a></li>
                <li class="even"><a href="#">$STI - STI Education System, Inc.</a></li>
                <li class="odd"><a href="#">$FDC - Filinvest Development Corporation</a></li>
                <li class="even"><a href="#">$SCC - Semirara Mining and Power Corporation</a></li>
                <li class="odd"><a href="#">$COSCO - Cosco Capital, Inc.</a></li>
                <li class="even"><a href="#">$GERI - Global-Estate Resorts, Inc.</a></li>
                <li class="odd"><a href="#">$GMA7 - GMA Network, Inc.</a></li>
              </ul>
            </div>
            <!-- <div class="to-bottom-title">
              <a href="#" class="to-view-more">View all trending stocks</a>
            </div> -->
          </div>
          <div class="latest-news">
            <div class="to-top-title">Latest News</div>
            <div class="to-content-part">
              <div class="to-rss-inner">
                <?php dynamic_sidebar( 'et_pb_widget_area_1' ); ?>
                <br class="clear">
              </div>
            </div>
            <!-- <div class="to-bottom-title">
              powerd by Google News 
              <a href="#" class="to-view-more">View all News</a>
            </div> -->
          </div>

        </div>
        <div class="ontofooter">
          <div class="ontonowfooter">
            <ul class="footmore">
              <li><a href="#">Privacy</a></li>
              <li><a href="#">Terms</a></li>
              <li><a href="#">Business</a></li>
              <li class="nobar">
                <a href="#" class="moretoclick">More</a>
                <ul class="closehideme">
                  <li class="ontohidebase"><a href="#">About</a></li>
                  <li class="ontohidebase"><a href="#">FAQ</a></li>
                  <li class="ontohidebase"><a href="#">Companies</a></li>
                  <li class="ontohidebase"><a href="#">Contact Us</a></li>
                </ul>
              </li>
            </ul>
            <div class="copyright">Arbitrage &copy; 2019</div>
          </div>
        </div>
      </div>
      <br class="clear">
    </div>
  </div>

</div> <!-- #main-content -->

<?php

get_footer('dashboard');
