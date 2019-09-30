<?php
	/*
	* Template Name: Tradelogs Page
	* Template page for Tradelogs Page 	
	*/
// get_header();
global $current_user;
$user = wp_get_current_user();
get_header( 'dashboard' );
include_once(get_theme_file_path().'/arphie-function.php');
include_once(get_theme_file_path().'/ab-functions.php');
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,600i" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>


<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>


<link rel="stylesheet" type="text/css" href="/wp-content/themes/divi-child/tradelogs.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
      	//current allocation
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Cash',  60000],
          ['$ISM',  20000],
          ['$IRC',  20000],
          ['$HLMC', 10000]
        ]);
        var options = {
          // title: 'My Daily Activities',
          colors: ['#f9926e', '#d26987', '#ab4b97', '#643f96'],
          legend: {
          	position: 'none'
          },
          backgroundColor: {
          	stroke: 'none'
          },
          pieHole: 0.4,
          backgroundColor:{
          	fill: '#35485f',
          	stroke: 'none'
          },
          pieSliceBorderColor:"transparent",
          pieSliceText: 'none',
        };
        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
        //trade statistics
        var statsdata = google.visualization.arrayToDataTable([
          ['Task', 'Trade Statistics'],
          ['Win',     80],
          ['Loss',      20]
        ]);
        var statsoption = {
          // title: 'My Daily Activities',
          colors: ['green', 'red'],
          legend: {
          	position: 'bottom'
          },
          pieHole: 0.4,
          backgroundColor: {
          	fill: '#35485f',
          	stroke: 'none'
          },
          pieSliceBorderColor:"transparent",
        };
        var statchart = new google.visualization.PieChart(document.getElementById('statsdonut'));
        statchart.draw(statsdata, statsoption);
      }
    </script>
<div id="main-content" class="oncommonsidebar">
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
										<div class="onto-user-name"><?php echo um_user('full_name'); ?></div>
										<div class="onto-user-meta-details">View Portfolio</div>
									</div>
								</div>
								<div class="side-content">
									<div class="side-content-inner">
										<ul>
											<li class="two"><a href="/chart/">Interactive Chart</a></li>
											<li class="three"><a href="/journal/">Trading Journal</a></li>
											<li class="five"><a href="#">Watcher & Alerts</a></li>
											<li class="four"><a href="#">Stock Screener</a></li>
											<li class="one"><a href="#">Calculator</a></li>
											<!-- <li class="six"><a href="#">Paper Trade</a></li> -->
											<!-- <li class="seven"><a href="#">Chat</a></li> -->
											<!-- <li class="eight"><a href="#">Groups</a></li> -->
											<!-- <li class="nine"><a href="#">Traders</a></li> -->
										</ul>
										<div class="side-content-enter-trade text-center">
											<a class="btn btn-lg btn-primary btn-tradelog" href="/enter-trade/">Enter Trade</a>
										</div>
									</div>
									<div class="box-portlet-footer"></div>	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="post-content">
						<div>
							<div class="row">
								<div class="col-md-12">
						            <div class="panel panel-primary">
						               <div class="panel-heading">
						                    <span class="">
						                        <!-- Tabs -->
						                        <ul class="nav panel-tabs">
						                            <li class="active"><a href="#tab1" data-toggle="tab" class="active show">Dashboard</a></li>
						                            <li class=""><a href="#tab2" data-toggle="tab" class="">Tradelogs</a></li>
						                            <li class=""><a href="#tab3" data-toggle="tab" class="">Ledger</a></li>
						                            <li class=""><a href="#tab4" data-toggle="tab" class="">Calendar</a></li>
						                        </ul>
						                    </span>
						                </div>
						                <div class="panel-body">
						                    <div class="tab-content">
						                        <div class="tab-pane show active" id="tab1">
						                        	<div class="row">
                                                    
                                                    <div class="monthly">
														<div class="box-portlet">
															<div class="box-portlet-header">
																Live Portfolio
															</div>
															<div class="box-portlet-content">
																
<table class="tradelogtable" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr style="border-bottom: 1px solid #4f6379">
              <td><strong>No</strong></td>
              <td><strong>Stock</strong></td>
              <td><strong>Strategy</strong></td>
              <td><strong>Trade Plan</strong></td>
              <td><strong>Emotion</strong></td>
              <td><strong>Position</strong></td>
              <td><strong>Buy Date</strong></td>
              <td><strong>Buy Price</strong></td>
              <td><strong>Average Price</strong></td>
              <td style="text-align: right;"><strong>Sell Trade</strong></td>
              <td style="text-align: right;"><strong>Notes</strong></td>
            </tr>
            
                <?php
                $author_query = array(
								'posts_per_page' => '-1',
								'author' => $curuserid,
								'meta_key' => 'data_status',
								'meta_value'  => 'Live'
				 				);
                $author_posts = new WP_Query($author_query);
                
				$numbrng = 0;
                while($author_posts->have_posts()) : $author_posts->the_post(); $numbrng++; ?>
                <tr>
                    <td><?php echo $numbrng; ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_stock', true); ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_strategy', true); ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_tradeplan', true); ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_emotion', true); ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_qty', true); ?></td>
					<td>
                      <?php echo get_post_meta(get_the_ID(), 'data_buymonth', true); ?> 
                      <?php echo get_post_meta(get_the_ID(), 'data_buyday', true); ?>, 
                      <?php echo get_post_meta(get_the_ID(), 'data_buyyear', true); ?>
                    </td>
                    <td><?php if (get_post_meta(get_the_ID(), 'data_price', true)){ 
                          echo "₱ " . number_format(get_post_meta(get_the_ID(), 'data_price', true), 2, ".", ",");
                          }else{ echo "₱ 0.00"; }?></td>
                    <td><?php echo "₱ 0.00"; ?></td>
                    <td style="text-align: right;">
                    	<a href="#selltrade<?php echo "_".$numbrng ; ?>" class="smlbtn fancybox-inline">SELL</a>
                    	<div class="hideformodal">
                        	<div class="tradingnotescont" id="tradingnotes<?php echo "_".$numbrng ; ?>">
                            	<div class="entr_ttle_bar">
                                    <img src="/wp-content/uploads/2018/12/logo.png" alt="Arbitrage"> <strong>Trading Notes</strong>
                                </div>
                            	<div style="padding:10px 0 0 0"><?php echo get_post_meta(get_the_ID(), 'data_tradingnotes', true); ?></div>
                            </div>
                        </div>
                    </td>
                    <td style="text-align: right;"><a href="#tradingnotes<?php echo "_".$numbrng ; ?>" class="smlbtn blue fancybox-inline">
						<i class="fa fa-sticky-note-o" aria-hidden="true"></i></a>
                    </td>
                </tr>
                <?php /*?><tr class="sysoutput"> <!-- For development purposes only -->
                	<td colspan="10">
                      <span style="color:#fff;">System Details-></span>
                      <span><strong>Status</strong>: <?php echo get_post_meta(get_the_ID(), 'data_status', true); ?></span>
                      <span><strong>Price</strong>: <?php if (get_post_meta(get_the_ID(), 'data_price', true)){ 
                          echo "₱ " . number_format(get_post_meta(get_the_ID(), 'data_price', true), 2, ".", ",");
                          }else{ echo "₱ 0.00"; }?></span>
                      <span><strong>Current Price</strong>: <?php if (get_post_meta(get_the_ID(), 'data_currprice', true)){ 
                          echo "₱ " . number_format(get_post_meta(get_the_ID(), 'data_currprice', true), 2, ".", ",");
                          }else{ echo "₱ 0.00"; }?></span>
                      <span><strong>Change</strong>: <?php echo get_post_meta(get_the_ID(), 'data_change', true); ?></span>
                      <span><strong>Open</strong>: <?php echo get_post_meta(get_the_ID(), 'data_open', true); ?></span>
                      <span><strong>Low</strong>: <?php echo get_post_meta(get_the_ID(), 'data_low', true); ?></span>
                      <span><strong>High</strong>: <?php echo get_post_meta(get_the_ID(), 'data_high', true); ?></span>
                      <span><strong>Volume</strong>: <?php echo get_post_meta(get_the_ID(), 'data_volume', true); ?></span>
                      <span><strong>Value</strong>: <?php echo get_post_meta(get_the_ID(), 'data_value', true); ?></span>
                      <span><strong>Board Lot</strong>: <?php echo get_post_meta(get_the_ID(), 'data_boardlot', true); ?></span>
                    </td>
                </tr><?php */?>
                <div class="hideformodal">
                
                    <div class="selltrade" id="selltrade<?php echo "_".$numbrng ; ?>">
                    
                        <div class="entr_ttle_bar">
                            <strong>Sell Trade</strong> <span class="datestamp_header"><?php date_default_timezone_set('Asia/Manila'); echo date("F j, Y g:i a"); ?></span>
                        </div>
                        
                        <form action="/enter-trade" method="post">
                        
                        <div class="entr_wrapper_top">
                        
                                <div class="entr_col">
                                    <div class="groupinput fctnlhdn">
                                        <label>Sell Date</label>
                                        <select name="inpt_data_sellmonth" style="width:90px;">
                                            <option value="<?php echo date("F"); ?>" selected><?php echo date("F"); ?></option>
                                            <option value="">- - -</option>
                                            <option value="January">January</option>
                                            <option value="Febuary">Febuary</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                        <input type="text" name="inpt_data_sellday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("j"); ?>">
                                        <input type="text" name="inpt_data_sellyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("Y"); ?>">
                                        </div>
                                    
                                    <div class="groupinput midd lockedd"><label>Stock</label><input type="text" name="inpt_data_stock" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_stock', true); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                                    
                                    <div class="groupinput midd lockedd"><label>Buy Price</label><input type="text" name="inpt_data_price"
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_price', true); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                                    
                                    <div class="groupinput midd"><label>Sell Price</label><input type="text" name="inpt_data_sellprice"></div>
                                    
                                    <div class="groupinput midd"><label>Qty.</label><input type="text" name="inpt_data_qty"
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_qty', true); ?>"></div>
                                </div>
                                
                                <div class="entr_col">
                                    <div class="groupinput midd"><label>Curr. Price</label><input type="text" name="inpt_data_currprice" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_currprice', true); ?>"></div>
                                    
                                    <div class="groupinput midd"><label>Change</label><input type="text" name="inpt_data_change" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_change', true); ?>"></div>
                                    
                                    <div class="groupinput midd"><label>Open</label><input type="text" name="inpt_data_open" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_open', true); ?>"></div>
                                    
                                    <div class="groupinput midd"><label>Low</label><input type="text" name="inpt_data_low" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_low', true); ?>"></div>
                                    
                                    <div class="groupinput midd"><label>High</label><input type="text" name="inpt_data_high" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_high', true); ?>"></div>
                                </div>
                                
                                <div class="entr_col">
                                    <div class="groupinput midd"><label>Volume</label><input type="text" name="inpt_data_volume" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_volume', true); ?>"></div>
                                    
                                    <div class="groupinput midd"><label>Value</label><input type="text" name="inpt_data_value" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_value', true); ?>"></div>
                                    
                                    <div class="groupinput midd"><label>Board Lot</label><input type="text" name="inpt_data_boardlot" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_boardlot', true); ?>"></div>
                                </div>
                                
                                <div class="entr_clear"></div>
                            
                        </div>
                        <div class="entr_wrapper_mid">
                            
                            <div class="entr_col fctnlhdn">
                                <div class="groupinput selectonly">
                                    <select name="inpt_data_strategy" class="rnd">
                                        <option value="<?php echo get_post_meta(get_the_ID(), 'data_strategy', true); ?>" selected>
										Strategy: <?php echo get_post_meta(get_the_ID(), 'data_strategy', true); ?></option>
                                        <option value="">- - -</option>
                                        <option value="Bottom Picking">Bottom Picking</option>
                                        <option value="Breakout Play">Breakout Play</option>
                                        <option value="Trend Following">Trend Following</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="entr_col fctnlhdn">
                                <div class="groupinput selectonly">
                                    <select name="inpt_data_tradeplan" class="rnd">
                                        <option value="<?php echo get_post_meta(get_the_ID(), 'data_tradeplan', true); ?>" selected>
										Trade Plan: <?php echo get_post_meta(get_the_ID(), 'data_tradeplan', true); ?></option>
                                        <option value="">- - -</option>
                                        <option value="Day Trade">Day Trade</option>
                                        <option value="Swing Trade">Swing Trade</option>
                                        <option value="Investment">Investment</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="entr_col fctnlhdn">
                                <div class="groupinput selectonly">
                                    <select name="inpt_data_emotion" class="rnd">
                                        <option value="<?php echo get_post_meta(get_the_ID(), 'data_emotion', true); ?>" selected>
										Emotion: <?php echo get_post_meta(get_the_ID(), 'data_emotion', true); ?></option>
                                        <option value="Nuetral">Neutral</option>
                                        <option value="Greedy">Greedy</option>
                                        <option value="Fearful">Fearful</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="groupinput fctnlhdn">
                                <textarea class="darktheme" name="inpt_data_tradingnotes"><?php echo get_post_meta(get_the_ID(), 'data_tradingnotes', true); ?></textarea>
                            </div>
                            
                            <div>
                                <input type="hidden" value="Log" name="inpt_data_status">
                                <input type="hidden" value="<?php echo get_the_ID(); ?>" name="inpt_data_postid">
                                <input type="submit" class="confirmtrd red" value="Sell Trade">
                            </div>
                            
                         </div>
                                 
                        </form>
                    </div> 
                
                </div>
                
                <?php endwhile; ?>
            
            
          </tbody>
        </table>
                                                                
															</div>
															<div class="box-portlet-footer"></div>
														</div>
													</div>
													<br class="clear">
                                                    
														<div class="col-md-7">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Portfolio Snapshot
																</div>
																<div class="box-portlet-content">
																	<div class="row">
																		<div class="col-md-6">
																			<div class="inner-portlet">
																				<div class="inner-portlet-title">Traiding Results</div>
																				<div class="inner-portlet-content">
																						<div class="row intosection">
																							<div class="col-md-7">Beginning Balance</div>
																							<div class="col-md-5 post-right-text">100,000.00</div>
																						</div>
																						<div class="row intosection">
																							<div class="col-md-7">Year to Date P/L</div>
																							<div class="col-md-5 post-right-text">10,000.00</div>
																						</div>
																						<div class="row intosection">
																							<div class="col-md-7">posrtfolio YTD %</div>
																							<div class="col-md-5 post-right-text">10.00%</div>
																						</div>
																				</div>
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="inner-portlet">
																				<div class="inner-portlet-title">Fund Transfers</div>
																				<div class="inner-portlet-content">
																						<div class="row intosection">
																							<div class="col-md-7">Total Deposits</div>
																							<div class="col-md-5 post-right-text">50,000.00</div>
																						</div>
																						<div class="row intosection">
																							<div class="col-md-7">Total Withdrawals</div>
																							<div class="col-md-5 post-right-text">10,000.00</div>
																						</div>
																						<div class="row intosection">
																							<div class="col-md-7">Total Equity</div>
																							<div class="col-md-5 post-right-text">150,000.00</div>
																						</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<br class="clear">
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
														<div class="col-md-5">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Current Allocation
																</div>
																<div class="box-portlet-content">
																	<div class="row">
																		<div class="col-md-6">
																			<ul class="alloc-data">
																				<li>
																					<div class="data-color"><span class="color-cash">&nbsp;</span></div>
																					<div class="data-name">Cash</div>
																					<div class="data-price">60,000.00</div>
																				</li>
																				<li>
																					<div class="data-color"><span class="color-ism">&nbsp;</span></div>
																					<div class="data-name">$ISM</div>
																					<div class="data-price">20,000.00</div>
																				</li>
																				<li>
																					<div class="data-color"><span class="color-irc">&nbsp;</span></div>
																					<div class="data-name">$IRC</div>
																					<div class="data-price">20,000.00</div>
																				</li>
																				<li>
																					<div class="data-color"><span class="color-hlcm">&nbsp;</span></div>
																					<div class="data-name">$HLMC</div>
																					<div class="data-price">10,000.00</div>
																				</li>
																			</ul>
																		</div>
																		<div class="col-md-6">
																			<div class="charthere">
																				<div id="donutchart" style="width: 150px; height: 130px;"></div>
																			</div>
																		</div>
																		<br class="clear">
																	</div>
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
													</div>
													<br class="clear">
													<div class="monthly">
														<div class="box-portlet">
															<div class="box-portlet-header">
																Monthly Performance
															</div>
															<div class="box-portlet-content">
																Latest 12 Months activit here
															</div>
															<div class="box-portlet-footer"></div>
														</div>
													</div>
													<br class="clear">
													<div class="row">
														<div class="col-md-4">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Trade Statistics
																</div>
																<div class="box-portlet-content">
																	<div class="row">
																		<div class="col-md-12">
																			<ul class="onstats">
																				<li>
																					<div class="textleft">Total Trades</div>
																					<div class="textright">100</div>
																				</li>
																				<li>
																					<div class="textleft">Wins</div>
																					<div class="textright">80</div>
																				</li>
																				<li>
																					<div class="textleft">Loss</div>
																					<div class="textright">20</div>
																				</li>
																				<li>
																					<div class="textleft">Win Rate</div>
																					<div class="textright">80.00%</div>
																				</li>
																			</ul>
																		</div>
																		<div class="col-md-12">
																			<div class="charthere">
																				<div id="statsdonut" style="width: 260px; height: 200px;"></div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
														<div class="col-md-8">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Strategy Statistics
																</div>
																<div class="box-portlet-content">
																	<div class="stats-info">
																		<div class="dstatstrade">
																			<ul>
																				<li class="headerpart">
																					<div>Emotions</div>
																					<div class="center">Trades</div>
																					<div class="center">Wins</div>
																					<div class="center">Loses</div>
																					<div class="center">Win Rate</div>
																				</li>
																				<li>
																					<div>Neutral</div>
																					<div class="center">11</div>
																					<div class="center">6</div>
																					<div class="center">5</div>
																					<div class="center">54.00%</div>
																				</li>
																				<li>
																					<div>Greedy</div>
																					<div class="center">40</div>
																					<div class="center">18</div>
																					<div class="center">22</div>
																					<div class="center">45.00%</div>
																				</li>
																				<li>
																					<div>Fearful</div>
																					<div class="center">10</div>
																					<div class="center">6</div>
																					<div class="center">4</div>
																					<div class="center">60.00%</div>
																				</li>
																				<li>
																					<div>Bored</div>
																					<div class="center">4</div>
																					<div class="center">2</div>
																					<div class="center">2</div>
																					<div class="center">50.00%</div>
																				</li>
																				<li>
																					<div>Excited</div>
																					<div class="center">55</div>
																					<div class="center">41</div>
																					<div class="center">14</div>
																					<div class="center">74.00%</div>
																				</li>
																				<li>
																					<div>Hopeful</div>
																					<div class="center">40</div>
																					<div class="center">37</div>
																					<div class="center">3</div>
																					<div class="center">92.00%</div>
																				</li>
																			</ul>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-6 border-right alocate-charts">
																			<h2>Trades | Wins | Losses</h2>
																			<div class="dcontent">
																				the chart here
																			</div>
																		</div>
																		<div class="col-md-6 alocate-charts">
																			<h2>Win Allocations</h2>
																			<div class="dcontent">
																				the chart here
																			</div>
																		</div>
																		<br class="clear">
																	</div>
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
														<br class="clear">
													</div>
													<br class="clear">
													<div class="expence-report">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Expence Report
																</div>
																<div class="box-portlet-content">
																	expence charts
																</div>
																<div class="box-portlet-footer"></div>
															</div>
													</div>
													<br class="clear">
													<div class="row">
														<div class="col-md-6">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Daily Buy Volume (last 30 traiding days)
																</div>
																<div class="box-portlet-content">
																	this is the content
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Daily Buy Value (last 30 traiding days)
																</div>
																<div class="box-portlet-content">
																	this is the content
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
													</div>
													<br class="clear">
													<div class="d-adds">
														adds here
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Performance by Day of the Week
																</div>
																<div class="box-portlet-content">
																	this is the content
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="box-portlet">
																<div class="box-portlet-header">
																	Gross P&L (last 30 traiding days)
																</div>
																<div class="box-portlet-content">
																	this is the content
																</div>
																<div class="box-portlet-footer"></div>
															</div>
														</div>
													</div>														
						                        </div>
						                        <div class="tab-pane" id="tab2">
						                        	<!--Table-->
													<table id="tablePreview" class="table table-striped table-sm">
													<!--Table head-->
													  <thead>
													    <tr>
													      <th>No.</th>
													      <th>Stock</th>
													      <th>Strategy</th>
													      <th>Trade Plan</th>
													      <th>Emotion</th>
													      <th>Qty.</th>
													      <th>Buy Date</th>
													      <th>Ave Price</th>
													      <th>Sell Date</th>
													      <th>Performance</th>
													      <th>Outcome</th>
													      <th>P&L</th>
													    </tr>
													  </thead>
													  <!--Table head-->
													  <!--Table body-->
													  <tbody>
													    <tr>
													      <th scope="row">1</th>
													      <td>IRC</td>
													      <td>Bottom Picking</td>
													      <td>Swing Trade</td>
													      <td>Neutral</td>
													      <td>4,000</td>
													      <td>January 3, 2019</td>
													      <td>₱2.44</td>
													      <td>January 3, 2019</td>
													      <td>8.11%</td>
													      <td>Gain</td>
													      <td>₱720.00</td>
													    </tr>
													  </tbody>
													  <!--Table body-->
													</table>
													<!--Table-->
													<br class="clear">
													<div class="totalpl">
														 <p>Total P/L to date: <span class="totalplscore">₱720.00</span></p>
													</div>
						                        </div>
						                        <div class="tab-pane" id="tab3">
						                        	  <!--Table-->
														<table id="tablePreview" class="table table-striped table-sm">
														  <!--Table head-->
														  <thead>
														    <tr>
														      <th>Monthly Perfomance</th>
														      <th>Starting Balance</th>
														      <th>Perfomance</th>
														      <th>Profit/Loss</th>
														      <th>Withdrawals</th>
														      <th>Deposits</th>
														      <th>Ending Balance</th>
														    </tr>
														  </thead>
														  <!--Table head-->
														  <!--Table body-->
														  <tbody>
														    <tr>
														      <th scope="row">January</th>
														      <td>₱100,000.00</td>
														      <td>15.20%</td>
														      <td>₱15,199.00</td>
														      <td>₱20,000.00</td>
														      <td>0.00</td>
														      <td>₱19,199.00</td>
														    </tr>
														  </tbody>
														  <tfoot>
														    <tr>
														      <td>Total</td>
														      <td>&nbsp;</td>
														       <td>&nbsp;</td>
														       <td>₱15,199.00</td>
														       <td>₱20,000.00</td>
														      <td>₱10,000.00<td>
														    </tr>
														  </tfoot>
														  <!--Table body-->
														</table>
														<!--Table-->
													<br class="clear">
													<!-- <div class="totalpl">
														 <p>Total P/L to date: <span class="totalplscore">₱720.00</span></p>
													</div> -->
						                        </div>
						                        <div class="tab-pane" id="tab4">Content 4</div>
						                    </div>
						                </div>
						            </div>
						        </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>
</div> <!-- #main-content -->
<div class="script">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

</div>
<?php
get_footer('dashboard');