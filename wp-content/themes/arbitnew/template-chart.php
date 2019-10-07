<?php
	/*
	* Template Name: Chart Page
    * Template page for Trading Chart
    * Ralph was here - Enter Buy Order
	*/
	global $current_user;
	$user = wp_get_current_user();
	if ( is_user_logged_in() ) {
		// user is now logged in
	} else {
		wp_redirect( '/login', 301 );
		exit;
	}

	$user_id = $user->ID;
	require "interactivechart/header.php";
?>
	<div id="preloader">
		<div id="status">&nbsp;</div>
		<div id="status_txt"></div>
	</div>
    <?php get_template_part('parts/sidebar', 'calc'); ?>

	<?php get_template_part('parts/sidebar', 'varcalc'); ?>

	<?php get_template_part('parts/sidebar', 'avarageprice'); ?>

	<?php
		$userid = get_current_user_id();
		$dledger = $wpdb->get_results( "SELECT * FROM arby_ledger where userid = ".$userid);
	?>

	<div>
		<div class="chart_logo_arbitrage"><a href="/" target="_blank"><img src="/wp-content/themes/arbitnew/images/arblogo_svg1.svg" style="width: 33px;"></a></div>

		<div class="arb_top_ticker">
			<div ng-controller="ticker" class="sd_border_btm arb_custom_ticker_wrapper">
				<ul 
					ng-if="enable"
					id="container" class="list-inline marqueethis arb_custom_ticker">
					<li ng-repeat="transaction in ticker" ng-class="::{'text-green': 0 < transaction.change, 'text-red': transaction.change < 0, 'text-grey': transaction.change == 0}">
						<i class="fas " ng-class="{'fa-arrow-up': transaction.change > 0, 'fa-arrow-down': transaction.change < 0, 'normpadd': transaction.change == 0}" style="font-size: 14px;"></i>
						<a href="/chart/{{::transaction.symbol}}" target="_blank"><strong class="text-white" style="font-size:14px">{{::transaction.symbol}}</strong></a><br>
						<strong style="font-black: bold !important;">{{::transaction.price}}</strong>
						&nbsp;(<strong style="font-weight: bold !important;">{{::transaction.shares}}</strong>)
					</li>
				</ul>

				<div class="ticker-enabler">
					<button 
						ng-click="enable = !enable"
						class="btn btn-xs btn-link"><i class="fa" ng-class="{'fa-eye-slash': enable, 'fa-eye': !enable}"></i></button>
					<button 
						ng-click="tickerBeep = !tickerBeep"
						class="btn btn-xs btn-link"><i class="fa" ng-class="{'fa-volume-up': tickerBeep, 'fa-volume-off': !tickerBeep}"></i></button>
				</div>
			</div>
		</div>

		<div class="arb_right_icons_trans">
			<?php /*?> Top Icons <?php */?>
			<ul class="main-drops-chart">
				<a href="#" class="arb-side-icon">
					<img src="/svg/menu.svg" style="width: 17px;display: inline-block;vertical-align: top;margin-top: 6px;">
				</a>
				<ul id="droppouts" style="box-shadow: 0px 2px 4px 1px rgba(7, 13, 19, 0.52);display: none;">
						<li><a href="#">Buy/Sell Calculator</a></li>
						<li><a href="#">VAR Calculator</a></li>
						<li><a href="#">Average Price Calculator</a></li>
				</ul>
			</ul>
			<a href="/notifications/" class="arb-side-icon"><img src="/svg/bell.svg" style="width: 19px;display: inline-block;vertical-align: top;margin-top: 5px;"></a>
			<a href="https://vyndue.com/userview/im" class="arb-side-icon"><img src="/svg/vyndue-newlogo-white.svg" style="width: 19px;display: inline-block;vertical-align: top;margin-top: 4px;"></a>
			<a href="/user/" class="arb-side-icon"><?php
				if ( $user ) : ?>
					<img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>" class="arb_proficon" />
				<?php else: ?>
					<i class="fas fa-user-tie"></i>
				<?php endif; ?></a>
			<div style="clear:both"></div>
		</div>
	</div>

	<div id="page-container" class="fade page-content-full-height page-without-sidebar" ng-controller="template">
		<div id="content" class="content content-full-width" style="top: 40px; padding: 0;">
			<div class="vertical-box">
				<div class="vertical-box-row">
					<div class="vertical-box-cell">
						<div class="vertical-box-inner-cell">
							<div style="height:100%" data-height="100%" ng-controller="chart">
								<div class="vertical-box">
									<div class="vertical-box-column mobilefull" style="position: relative; height: 100%;">
										<div class="vertical-box" style="height: 100%;">
											<div class="vertical-box-row" style="height: 100%;">
												<div class="vertical-box-cell" style="height: 100%;">
													<div class="vertical-box-inner-cell" ng-controller="tradingview" style="height: 100%;">
														<div id="tv_chart_container"></div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="vertical-box-column width-250 mobileinithide" id="right-sidebar" ng-show="settings.right">
										<div class="showsidemobile">
											<i class="fa fa-outdent" aria-hidden="true"></i>
											<i class="fa fa-indent" aria-hidden="true"></i>
										</div>

										<div class="closesidebar">
											<a href="#"><img src="/svg/close_verysmall.svg"></a>
										</div>

										<div class="opensidebar">
											<a href="#"><img src="/svg/open_verysmall.svg"></a>
										</div>

										<div class="vertical-box">
											<div class="vertical-box-row ">
												<div class="vertical-box-cell">
													<div class="vertical-box-inner-cell">
														<div class="vertical-box">
															<div class="vertical-box-column">
																<div class="vertical-box">
																	<div class="vertical-box-row" style="height: 165px; overflow:hidden; display: block;">
																		<div id="stock-details" style="display:block" ng-show="stock">
																			<div class="arb_buysell" id="draggable_buysell">
																				<button class="buysell-grip-btn">
																					<i class="fa fa-grip-vertical fa-lg" style="color: white;"></i>
																				</button>
																				<div class="buttons">
																					<a class="arb_buy" data-fancybox data-src="#entertrade" href="javascript:;"><i class="fas fa-arrow-up"></i> Buy</a>
																					<a class="arb_sell" data-fancybox data-src="#buytrade" href="javascript:;" data-stocksel="{{stock_details[stock.symbol].symbol}}" disabled><i class="fas fa-arrow-down"></i> Sell</a>
																				</div>
																			</div>

																			<div class="hideformodal">
																				<div class="buytrade" style="display:none" id="buytrade">
																					<div class="innerbuy">
																						<div class="selltrade selltrade--align" id="selltrade_<?php echo $value; ?>">
																							<div class="entr_ttle_bar">
																								<strong>Sell Trade</strong>
																							</div>
																							<form action="/journal" method="post">
																								<div class="entr_wrapper_top">
																									<div class="entr_col">
																										<div class="groupinput midd lockedd"><label>Stock</label><input type="text" id="sellstockname" name="inpt_data_stock" value="{{stock.symbol}}" readonly style="text-align: left;"><i class="fa fa-lock" aria-hidden="true"></i></div>
																										<div class="groupinput midd lockedd"><label>Position</label><input type="text" id="sellvolume" name="inpt_data_price" value="" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																									</div>
																									<div class="entr_col">
																										<div class="groupinput midd lockedd"><label>Avr. Price</label><input type="text" id="sellavrprice" name="inpt_avr_price" value="" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																										<div class="groupinput midd lockedd"><label>Curr. Price</label><input type="text" id="sellcurrprice" name="inpt_data_price" value="{{stock.displayLast}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																									</div>
																									<div class="entr_col">
																										<div class="groupinput midd"><label>Sell Price</label><input step="0.01" id="sellprice" name="inpt_data_sellprice" class="no-padding" id="sell_price--input" required></div>
																										<div class="groupinput midd"><label>Qty.</label><input name="inpt_data_qty" value="<?php echo get_post_meta(get_the_ID(), 'data_qty', true); ?>" class="no-padding" id="qty_price--input" required></div>
																										<div class="groupinput midd inpt_data_price"><label>Sell Date</label><input type="date" name="selldate" class="buySell__date-picker trade_input changeselldate" required></div>
																									</div>
																									<div class="entr_clear"></div>
																								</div>
																								<div>
																									<div style="height: 36px;">
																										<input type="hidden" value="Log" name="inpt_data_status">
																										<input type="hidden" value="fromchart" name="formsource">
																										<input type="hidden" name="dtradelogs" id="tradelogs" value=''>
																										<input type="submit" id="confirmsellparts" class="confirmtrd green buy-order--submit" value="Confirm Trade" style="display:none;">
																									</div>
																								</div>
																							</form>
																						</div>
																					</div>
																				</div>
																				<div class="entertrade" style="display:none" id="entertrade">
																					<?php
																						$dbaseaccount = 0;
																						foreach ($dledger as $dbaseledgekey => $dbaseledgevalue) {
																							if ($dbaseledgevalue->trantype == "deposit" || $dbaseledgevalue->trantype == "selling") {
																								$dbaseaccount = $dbaseaccount + $dbaseledgevalue->tranamount;
																							} else {
																								$dbaseaccount = $dbaseaccount - $dbaseledgevalue->tranamount;
																							}
																						}
																					?>

																					<div class="entr_ttle_bar">
																						<strong>Enter Buy Order</strong>
																					</div>

																					<form action="/journal" method="post">
																						<div class="entr_wrapper_top">
																							<div class="entr_col">
																								<div class="groupinput fctnlhdn">
																								<label style="width:100%">Buy Date:</label>
																								<select name="inpt_data_buymonth" style="width:90px;">
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
																								<input type="text" name="inpt_data_buyday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("j"); ?>">
																								<input type="text" name="inpt_data_buyyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("Y"); ?>">
																								</div>

																								<div class="groupinput midd lockedd"><label>Stock</label>
																								<input type="text" name="inpt_data_stock" id="inpt_data_stock" style="margin-left: -3px; text-align: left;" value="{{stock_details[stock.symbol].symbol}}" readonly>
																								<i class="fa fa-lock" aria-hidden="true"></i></div>

																								<div class="groupinput midd"><label>Buy Price</label><input type="text" class="inpt_data_price number" name="inpt_data_price" required></div>
																								<div class="groupinput midd"><label>Quantity</label><input type="text" class="inpt_data_qty number" name="inpt_data_qty" required></div>
																								<div class="groupinput midd label_date">
																									<label>Enter Date</label><input type="date" class="inpt_data_boardlot_get buySell__date-picker" required="" id="journal__trade-btn--date-picker">
																								</div>
																								<div class="midd lockedd"><label style="color: white;">Available Funds</label><input type="text" class="input_buy_power" style="background-color: transparent; border: 0; color: white; padding-right: 0 !important;" name="input_buy_power" data-dbaseval="<?php echo $dbaseaccount; ?>" value="<?php echo number_format( $dbaseaccount, 2, '.', ',' ); ?>" readonly></div>
																								<div class="midd lockedd"><label style="color: white;">Total Cost</label><input type="text" class="inpt_total_cost" name="" style="background-color: transparent; border: 0; color: white; padding-right: 0 !important;"></div>
																							</div>

																							<div class="entr_col">
																								<div class="groupinput midd lockedd"><label>Curr. Price</label><input type="text" name="inpt_data_currprice" value="{{stock.displayLast}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																								<div class="groupinput midd lockedd"><label>Change</label><input type="text" name="inpt_data_change" value="{{stock.displayChange}}%" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																								<div class="groupinput midd lockedd"><label>Open</label><input type="text" name="inpt_data_open" value="{{stock.displayOpen}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																								<div class="groupinput midd lockedd"><label>Low</label><input type="text" name="inpt_data_low" value="{{stock.displayLow}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																								<div class="groupinput midd lockedd"><label>High</label><input type="text" name="inpt_data_high" value="{{stock.displayHigh}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																							</div>

																							<div class="entr_col">
																								<div class="groupinput midd lockedd"><label>Volume</label><input type="text" name="inpt_data_volume" value="{{stock.volume | abbr}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																								<div class="groupinput midd lockedd"><label>Value</label><input type="text" name="inpt_data_value" value="{{stock.displayValue}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
																								<div class="groupinput midd lockedd">
																									<label>Board Lot</label><input type="text" name="inpt_data_boardlot" id="inpt_data_boardlot" value="" readonly>
																									<i class="fa fa-lock" aria-hidden="true"></i>
																									<input type="hidden" id="inpt_data_boardlot_get" value="{{stock.displayLast}}">
																								</div>
																							</div>

																							<div class="entr_clear"></div>
																						</div>

																						<div class="derrormes" style="color: #f44336;"></div>

																						<div class="entr_wrapper_mid">
																							<div class="entr_col">
																								<div class="groupinput selectonly">
																									<select name="inpt_data_strategy" class="rnd">
																										<option value="" selected>Select Strategy</option>
																										<option value="Bottom Picking">Bottom Picking</option>
																										<option value="Breakout Play">Breakout Play</option>
																										<option value="Trend Following">Trend Following</option>
																									</select>
																								</div>
																							</div>

																							<div class="entr_col">
																								<div class="groupinput selectonly">
																									<select name="inpt_data_tradeplan" class="rnd">
																										<option value="" selected>Select Trade Plan</option>
																										<option value="Day Trade">Day Trade</option>
																										<option value="Swing Trade">Swing Trade</option>
																										<option value="Investment">Investment</option>
																									</select>
																								</div>
																							</div>

																							<div class="entr_col">
																								<div class="groupinput selectonly">
																									<select name="inpt_data_emotion" class="rnd">
																										<option value="" selected>Select Emotion</option>
																										<option value="Nuetral">Neutral</option>
																										<option value="Greedy">Greedy</option>
																										<option value="Fearful">Fearful</option>
																									</select>
																								</div>
																							</div>

																							<div class="groupinput">
																								<textarea class="darktheme" name="inpt_data_tradingnotes" onClick="this.value = ''">Trading Notes</textarea>
																							</div>

																							<div class="groupinput">
																								<img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right; margin-right: 20px;">
																								<input type="hidden" value="Live" name="inpt_data_status">
																								<input type="submit" class="confirmtrd green" style="outline: none;" value="Confirm Trade">
																							</div>
																						</div>
																					</form>
																				</div>
																			</div>

																			<div style="padding: 3px 5px 5px 40px; margin-bottom: 2px;" id="sval" class="sd_border_btm">
																				<div class="arb_stock_name"><!-- STOCK NAME -->
																					<i class="fas " ng-class="{'fa-arrow-up': stock.change > 0, 'fa-arrow-down': stock.change < 0}" style="font-size: 35px;position: absolute; left: 4px;"></i>
																					<div class="name text-uppercase text-default" style="font-size: 15px; font-weight: bold; white-space: nowrap; width: 100%; overflow: hidden;
																					text-overflow: ellipsis;">{{stock_details[stock.symbol].description}}</div>
																					<div class="figures" style="margin-top: 0; overflow: visible; white-space: nowrap;">
																						<span style="
																							font-size: 25px;
																							font-weight: bold;
																							letter-spacing: -1px;" class="text-default">{{stock.displayLast}}</span>
																						<span ng-class="{'text-green': stock.change > 0, 'text-red': stock.change < 0, 'text-yellow': stock.change == 0}" style="
																							font-size: 14px;
																							line-height: 1.42857143;">
																							<span style="font-size: 17px;font-weight: bold;margin-left: 5px;">{{stock.displayDifference}}</span>
																							<span style="font-size: 17px;font-weight: bold;margin-left: 5px;">({{stock.displayChange}}%)</span>
																						</span>
																						<small class="arb_markcap">Market Capitalization: {{stock.displayMarketCap}}</small>
																					</div>
																				</div>
																			</div>

																			<div class="border-default" style="min-height: 77px;">
																				<div style="float: left; width: 50%;">
																					<table class="table table-condensed m-b-0 ">
																						<tbody style="font-size: 10px;">
																							<tr>
																								<td style="border-top: none; font-weight: bold; padding: 5px;" class="text-uppercase">Previous</td>
																								<td style="border-top: none; font-weight: bold; padding: 5px;" class="text-default"><strong>{{stock.displayPrevious}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">Low</td>
																								<td style="font-weight: bold; padding: 5px;" class="" changediv="stock.low"><strong ng-class="{'text-green': stock.low > stock.previous, 'text-red': stock.low < stock.previous}">{{stock.displayLow}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">52WkLow</td>
																								<td style="font-weight: bold; padding: 5px;" class=""><strong ng-class="{'text-green': stock.weekYearLow > stock.last, 'text-red': stock.weekYearLow < stock.last}">{{stock.weekYearLow}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">Volume</td>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase text-default" changediv="stock.volume"><strong>{{stock.volume | abbr}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">Trades</td>
																								<td style="font-weight: bold; padding: 5px;" class="text-default" changediv="stock.trades"><strong>{{stock.trades | numeraljs: '0,0'}}</strong></td>
																							</tr>
																						</tbody>
																					</table>
																				</div>

																				<div style="float: left; width: 50%;">
																					<table class="table table-condensed m-b-0 sd_border_btm">
																						<tbody style="font-size: 10px;">
																							<tr>
																								<td style="border-top: none; font-weight: bold; padding: 5px;" class="text-uppercase">Open</td>
																								<td style="border-top: none; font-weight: bold; padding: 5px;"><strong ng-class="{'text-green': stock.open > stock.previous, 'text-red': stock.open < stock.previous}">{{stock.displayOpen}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">High</td>
																								<td style="font-weight: bold; padding: 5px;" changediv="stock.high"><strong ng-class="{'text-green': stock.high > stock.previous, 'text-red': stock.high < stock.previous}">{{stock.displayHigh}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">52WkHigh</td>
																								<td style="font-weight: bold; padding: 5px;" class=""><strong ng-class="{'text-green': stock.weekYearHigh > stock.last, 'text-red': stock.weekYearHigh < stock.last}">{{stock.weekYearHigh}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">Value</td>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase text-default" changediv="stock.value"><strong>{{stock.displayValue}}</strong></td>
																							</tr>
																							<tr>
																								<td style="font-weight: bold; padding: 5px;" class="text-uppercase">Average</td>
																								<td style="font-weight: bold; padding: 5px;" changediv="stock.average"><strong ng-class="{'text-green': stock.average > stock.previous, 'text-red': stock.average < stock.previous}">{{stock.displayAverage}}</strong></td>
																							</tr>
																						</tbody>
																					</table>
																				</div>

																				<div class="clearfix"></div>
																			</div>
																		</div>

																		<div class="arb_logo_placehldr">
																			<h2><img src="/wp-content/themes/arbitrage-child/cd/img/Asset 4.png" style="width:53%;;vertical-align:baseline"></h2>
																		</div>
																	</div>

																	<?php /*?> Bullish & Beasish <?php */
																		$link = $_SERVER['REQUEST_URI'];
																		$link_array = explode('/',$link);
																		$dxlink = array_filter($link_array);
																		$page = end($dxlink);

																		$dsentilist = get_post_meta( 504, '_sentiment_'.$page.'_list', true );
																	?>

																	<div class="regsentiment">
																		<div class=" arb_padding_5 b0 arb_bullbear  {{dshowsentiment}}" style="<?php echo ($page != "chart" ? 'display:block;' : 'display:none;'); ?>height: 80px;overflow: hidden;">
																			<div class="bullbearsents" data-bull="{{fullbidtotal}}" data-bear="{{fullasktotal}}">
																				<span class="bullbearsents_label">Register your sentiments</span>
																				<a href="#" class="bbs_bull"><img src="/svg/ico_bullish_no_ring.svg"></a>
																				<div class="dbaronchart" style="width: <?php echo ($percbid > 0 ? '70' : ''); ?>%;">
																					<div class="bbs_bull_bar" style="width: <?php echo $percbid; ?>%;">
																						<div class="bbs_bull_bar_inner"></div>
																						<span style="<?php echo ($percbid > 0 ? 'display:block;' : ''); ?>%;"><?php echo number_format($percbid,2); ?>%</span>
																					</div>
																					<div class="bbs_bear_bar" style="width: <?php echo $percask; ?>%;">
																						<div class="bbs_bear_bar_inner"></div>
																						<span style="<?php echo ($percask > 0 ? 'display:block;' : ''); ?>%;"><?php echo number_format($percask,2); ?>%</span>
																					</div>
																				</div>
																				<a href="#" class="bbs_bear"><img src="/svg/ico_bearish_no_ring.svg"></a>
																			</div>


																			<div class="arb_clear"></div>
																		</div>
																	</div>

																	<?php /*?> Market Depth & Transactions <?php */?>

																	<div class="vertical-box-row" style="height: 138px; overflow:hidden; display: block; padding: 5px 0 0 0;">
																		<ul class="nav nav-tabs" style="border-radius: 0;">
																			<li class="active">
																				<a href="#tab-marketepth" data-toggle="tab" style="padding: 5px 15px;margin-right: 0px;font-weight: bold;">
																					<small>Bids & Asks</small>
																				</a>
																			</li>
																			<li>
																				<a href="#tab-transaxtions" data-toggle="tab" style="padding: 5px 15px;margin-right: 0px;font-weight: bold;">
																					<small>Time & Trades</small>
																				</a>
																			</li>
																		</ul>

																		<div class="vertical-box-cell">
																			<div class="vertical-box-inner-cell">
																				<div class="vertical-box">
																					<div class="vertical-box-column">
																						<!--Market Depth-->
																						<div class="vertical-box tab-pane fade in active" id="tab-marketepth">
																							<table class="table table-condensed m-b-0 text-default" style="font-size: 10px; width:97%">
																								<col width="8">
																								<col width="17%">
																								<col width="16.67%">
																								<col width="16.67%">
																								<col width="16.67%">
																								<col width="16.67%">
																								<thead>
																									<tr>
																										<th class="border-default text-default text-center" style="padding: 3px 9px 3px 0 !important;">#</th>
																										<th class="border-default text-default text-left" style="padding: 3px !important;">VOL</th>
																										<th class="border-default text-default text-left" style="padding: 3px !important;">BID</th>
																										<th class="border-default text-default text-right" style="padding: 3px !important;">ASK</th>
																										<th class="border-default text-default text-right" style="padding: 3px !important;">VOL</th>
																										<th class="border-default text-default text-right" style="padding: 3px 12px 3px 3px !important;">#</th>
																									</tr>
																								</thead>
																							</table>
																							<div class="vertical-box-row">
																								<div class="vertical-box-cell">
																									<div class="vertical-box-inner-cell">
																										<div ng-show="!enableBidsAndAsks"
																											style="height: calc(100% - 35px); position: relative">
																											<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center">
																												<?php if ( ! WP_PROD_ENV): ?>
																													<button
																														class="btn btn-success btn-xs"
																														type="button"
																														ng-click="enableBidsAndAsks = true">Enable</button>
																												<?php else: ?>
																													<div>Coming soon</div>
																												<?php endif ?>
																											</div>
																										</div>
																										<div data-scrollbar="true" data-height="90%" class="" ng-show="enableBidsAndAsks">
																											<div class="table-responsive" style="display: inline-block; width: 48.5%; vertical-align: top">
																												<table class="table table-condensed m-b-0 text-default border-bottom-1 border-default" style="font-size: 10px;">
																													<col width="8.335%">
																													<col width="8.335%">
																													<col width="8.335%">
																													<tbody>
																														<tr ng-repeat="bid in bids | orderBy: '-price'">
																															<td class="text-center" change="bid.count"><span>{{bid.count > 0 ? bid.count : ''}}</span></td>
																															<td class="text-left text-uppercase" change="bid.volume"><span>{{bid.volume > 0 ? (bid.volume | abbr) : ''}}</span></td>
																															<td class="text-left" ng-class="{'text-green': bid.price > stock.previous, 'text-red': bid.price < stock.previous}" change="bid.price"><strong>{{bid.price > 0 ? (bid.price | price) : ''}}</strong></td>
																														</tr>
																													</tbody>
																												</table>
																											</div><!--
																											--><div class="table-responsive" style="display: inline-block; width: 48.5%; vertical-align: top">
																												<table class="table table-condensed m-b-0 text-default border-bottom-1 border-default" style="font-size: 10px;">
																													<col width="8.335%">
																													<col width="8.335%">
																													<col width="8.335%">
																													<tbody>
																														<tr ng-repeat="ask in asks">
																															<td class="text-right" ng-class="{'text-green': ask.price > stock.previous, 'text-red': ask.price < stock.previous}" change="ask.volume"><strong>{{ask.price > 0 ? (ask.price | price) : ''}}</strong></td>
																															<td class="text-right text-uppercase" change="ask.volume"><span>{{ask.volume > 0 ? (ask.volume | abbr) : ''}}</span></td>
																															<td class="text-right" style="padding-right: 12px !important;" change="ask.count"><span>{{ask.count > 0 ? ask.count : ''}}</span></td>
																														</tr>
																													</tbody>
																												</table>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>

																						<!-- Transactions -->
																						<div class="vertical-box tab-pane fade" id="tab-transaxtions">
																							<table class="table table-condensed m-b-0 text-default" style="font-size: 10px;">
																								<col width="20%">
																								<col width="20%">
																								<col width="20%">
																								<col width="20%">
																								<col width="20%">
																								<thead>
																									<tr>
																										<th class="border-default text-default" style="padding: 3px !important;">TIME</th>
																										<th class="border-default text-default text-right" style="padding: 3px !important;">VOLUME</th>
																										<th class="border-default text-default text-right" style="padding: 3px !important;">PRICE</th>
																										<th class="border-default text-default text-right" style="padding: 3px !important;">BUYER</th>
																										<th class="border-default text-default text-right" style="padding: 3px !important;">SELLER</th>
																									</tr>
																								</thead>
																							</table>

																							<div class="vertical-box-row">
																								<div class="vertical-box-cell">
																									<div class="vertical-box-inner-cell">
																										<div data-scrollbar="true" data-height="100%" class="">
																											<div class="table-responsive">
																												<table class="table table-condensed m-b-0 text-default border-bottom-1 border-default" style="font-size: 10px;">
																													<col width="20%">
																													<col width="20%">
																													<col width="20%">
																													<col width="20%">
																													<col width="20%">
																													<tbody>
																														<tr ng-repeat="transaction in transactions">
																														<td class="text-default text-left" nowrap="nowrap">{{::transaction.time}}</td>
																														<td style="font-weight: bold;" class="text-default text-right text-uppercase" nowrap="nowrap">{{::transaction.shares | abbr}}</td>
																														<td style="font-weight: bold;" class="text-default text-right" nowrap="nowrap"><strong ng-class="{'text-green': transaction.price > stock.previous, 'text-red': transaction.price < stock.previous}" style="font-weight: bold;">{{::transaction.price}}</strong></td>
																														<td class="text-default text-right" nowrap="nowrap">{{::transaction.buyer | trim: 4}}</td>
																														<td style="padding-right: 10px;" class="text-default text-right" nowrap="nowrap">{{::transaction.seller | trim: 4}}</td>
																														</tr>
																														<tr ng-show="transactions.length == 0"><td colspan="5" align="center"><br />No recent transactions</td></tr>
																													</tbody>
																												</table>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>

																	<?php /*?> Bid/Ask Bar <?php */?>

																	<div class="arb_padding_5 b0 bidaskbar">
																		<span class="bidaskbar_btn">Bid/Ask Bar: <span>Top Five</span> <i class="fa ng-scope fa-caret-down"></i></span>

																		<div class="bidaskbar_opt">
																			<ul>
																				<li><a href="#" data-istype="topfive" class="topfive">Top Five</a></li>
																				<li><a href="#" data-istype="fullbar" class="fullbar">Full Depth</a></li>
																			</ul>
																			<script>
																				$(document).ready(function() {
																					$( ".bidaskbar_opt .topfive" ).click(function() {
																					$( ".bidaskbar_btn span" ).html("Top Five");
																					});
																					$( ".bidaskbar_opt .fullbar" ).click(function() {
																					$( ".bidaskbar_btn span" ).html("Full Depth");
																					});
																				});
																			</script>
																		</div>

																		<div class="arb_bar topfive">
																			<div class="greybarbg">
																				<div class="arb_bar_green" style="width:{{bidperc}}%">&nbsp;</div>
																				<div class="arb_bar_red" style="width:{{askperc}}%">&nbsp;</div>
																			</div>
																			<div class="arb_clear"></div>
																			<div class="dlabels">
																				<div class="buyers">
																					<span style="font-weight: normal;color: #c9ccce;">BUYERS</span> {{bidperc | number : 2}}%
																				</div>
																				<div class="sellers">
																					{{askperc | number : 2}}% <span style="font-weight: normal;color: #c9ccce;">SELLERS</span>
																				</div>
																			</div>
																			<div class="arb_clear"></div>
																		</div>

																		<div class="arb_bar fullbar" style="display: none">
																			<div class="arb_bar_green" style="width:{{fullbidperc}}%">&nbsp;</div>
																			<div class="arb_bar_red" style="width:{{fullaskperc}}%">&nbsp;</div>
																			<div class="arb_clear"></div>
																			<div class="dlabels">
																				<div class="buyers">
																					<span style="font-weight: normal;color: #c9ccce;">BUYERS</span> {{fullbidperc | number : 2}}%
																				</div>
																				<div class="sellers">
																					{{fullaskperc | number : 2}}% <span style="font-weight: normal;color: #c9ccce;">SELLERS</span>
																				</div>
																			</div>
																			<div class="arb_clear"></div>
																		</div>
																	</div>

																	<?php /*?> All stocks / Watchlist <?php */?>


																	<div class="fixbrdebtm"></div>

																	<div class="vertical-box-row allstocksbox" style="border-bottom-width:6px;">
																		<ul class="nav nav-tabs" style="border-radius: 0;">
																			<li class="active">
																				<a href="#allstock" data-toggle="tab" style="padding: 5px 15px; margin-right: 0px;font-weight: bold;" aria-expanded="true">
																					<small>All Stocks</small>
																				</a>
																			</li>
																			<li class="">
																				<a href="#watchlists" data-toggle="tab" style="padding: 5px 15px; margin-right: 0px;font-weight: bold;" aria-expanded="false">
																					<small>Watchlist</small>
																				</a>
																			</li>
																		</ul>

																		<div style="clear:both"></div>

																		<div class="vertical-box">
																			<div class="vertical-box-row">
																				<div class="vertical-box-cell">
																					<div class="tab-content vertical-box-inner-cell" style="background-color: transparent; border-radius: 0; padding: 0; margin-bottom: 0;">
																						<div data-scrollbar="true" data-height="100%" style="height: 100%;">
																							<div class="vertical-box tab-pane fade in active" id="allstock">
																								<?php if ( ! WP_PROD_ENV): ?>
																								<table class="table table-condensed m-b-0" style="font-size: 10px; width:90%;">
																									<thead style="position: fixed; background-color: #2c3e50">
																										<tr>
																											<th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('symbol')" style="padding: 3px 12px 3px 6px !important; cursor: pointer;">
																												<strong>STOCK</strong>
																											</th>
																											<th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('last')" style="padding: 3px 15px 3px 4px !important; cursor: pointer;">
																												<strong>LAST</strong>
																											</th>
																											<th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('change_percentage')" style="padding: 3px !important; cursor: pointer;">
																												<strong>CHANGE</strong>
																											</th>
																											<th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('value')" style="padding: 3px !important; cursor: pointer;">
																												<strong>VALUE</strong>
																											</th>
																											<th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('trades')" style="padding: 3px 3px 3px 10px !important; cursor: pointer;">
																												<strong>TRADES</strong>
																											</th>
																										</tr>
																									</thead>
																								</table>

																								<table class="dstocklistitems table table-condensed m-b-0 text-inverse border-default" style="font-size: 10px; border-bottom: 1px solid; width:97%; margin-top: 19px;">
																									<tbody>

																										<tr
																											ng-repeat="stock in stocks | orderBy: sort : reverse track by stock.symbol"
																											ng-class="{'text-green': stock.displayChange > 0, 'text-red': stock.displayChange < 0, 'text-yellow': stock.displayChange == 0, 'bg-grey-transparent-5': stock.symbol == $parent.stock.symbol, 'hidden': sort != 'symbol' && !latest_trading_date.isSame(stock.lastupdatetime, 'day')}"
																											change-alt="stock"
																											style="font-weight: bold;"
																											>
																											<td class="text-default dspecitem" style="padding: 0px 7px 0 7px !important;" ng-click="select(stock.symbol)" style="cursor: pointer;">
																												<div style="width: 0; height: 0; overflow: hidden; display: block;">
																													<input type="radio" name="selected_stock" ng-model="selectedStock" value="{{::stock.symbol}}" id="select-{{::stock.symbol}}"/>
																												</div>
																												<div class="ditemone" style="cursor: pointer;">{{::stock.symbol}}</div>
																											</td>
																											<td align="left" ng-click="select(stock.symbol)" style="cursor: pointer;">{{stock.displayLast}}</td>
																											<td align="left" ng-click="select(stock.symbol)" style="cursor: pointer;text-align: center;">{{stock.displayChange}}%</td>
																											<td align="left" class="text-default" ng-click="select(stock.symbol)" style="cursor: pointer;">{{stock.displayValue}}</td>
																											<td align="right" class="text-default" ng-click="select(stock.symbol)" style="cursor: pointer;padding-right: 5px !important;">{{stock.trades | numeraljs:'0,0'}}</td>
																										</tr>
																										<tr ng-if="stocks.length == 0">
																											<td colspan="5" align="center">No Data Found</td>
																										</tr>
																									</tbody>
																								</table>
																								<?php else: ?>
																								<div
																									style="padding: 20px; text-align: center; color: #fff;">Temporarily disabled.</div>
																								<?php endif ?>
																							</div>

																							<div class="vertical-box tab-pane fade" id="watchlists">
																								<div class="arb_watchlst_cont">
																									<table>
																										<thead style="text-transform: uppercase;font-weight: normal !important;font-family: 'Roboto', Arial !important;">
																											<tr>
																												<th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;"><strong>Stock</strong></th>
																												<th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;"><strong>Day Range</strong></th>
																												<th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;"><strong>Price</strong></th>
																												<th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;"><strong>Change</strong></th>
																											</tr>
																										</thead>
																										<?php
		  $curl = curl_init();
		  curl_setopt($curl, CURLOPT_URL, '/wp-json/data-api/v1/stocks/history/latest?exchange=PSE' );

		  curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	      $dhistofronold = curl_exec($curl);
	      curl_close($curl);

	      $dhistoforchart = json_decode($dhistofronold);
	      $stockinfo = $dhistoforchart->data;

		  $userID = $current_user->ID;
																										?>
			<tbody>
				<?php $havemeta = get_user_meta($userID, '_watchlist_instrumental', true); ?>
				<?php if ($havemeta): ?>

				<?php foreach ($havemeta as $key => $value) { ?>
				<?php

					$dstock = $value['stockname'];
					$dprice = 0;
					$dchange = 0;

						foreach($stockinfo as $stkey => $stvals){
                              if($stvals->symbol == $dstock ){
                                $dprice = $stvals->last;
								$dchange = $stvals->changepercentage;
								$dlow = $stvals->low;
								$dhigh = $stvals->high;
                              }
                          }
					?>
					<tr class="tr-background">
						<td ng-click="select('<?php echo $value['stockname']; ?>')">	<div class="block"><?php echo $value['stockname']; ?></div></td>
						<td ng-click="select('<?php echo $value['stockname']; ?>')"><?php echo number_format( $dlow, 2, '.', ',' ); ?> ~ <?php echo number_format( $dhigh, 2, '.', ',' ); ?></td>
						<td style="text-align: left;" ng-click="select('<?php echo $value['stockname']; ?>')">
							<?php if ($dchange > 0): ?>
								<div class="chgreen-price" style="text-align: right;">&#8369;<?php echo number_format( $dprice, 2, '.', ',' ); ?></div>
							<?php else: ?>
								<div class="chred-price" style="text-align: right;">&#8369;<?php echo number_format( $dprice, 2, '.', ',' ); ?></div>
							<?php endif ?>
						</td>
						<td style="padding-left: 4px !important;" ng-click="select('<?php echo $value['stockname']; ?>')">
							<?php if ($dchange > 0): ?>
								<div class="chgreen"><?php echo number_format( $dchange, 2, '.', ',' ); ?>%</div>
							<?php else: ?>
								<div class="chred"><?php echo number_format( $dchange, 2, '.', ',' ); ?>%</div>
							<?php endif ?>

						</td>
					</tr>
				<?php } ?>
				<?php endif ?>

			</tbody>
																									</table>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="chartlocker"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end #content -->

		<!-- begin theme-panel -->
		<div class="theme-panel">
			<a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn" style="border: 1px solid #ccc; border-right: none; display: none;"><i class="fa fa-cog"></i></a>
			<div class="theme-panel-content">
				<h5 class="m-t-0">Settings</h5>
				<div class="row m-t-10">
					<div class="col-md-5 control-label double-line">Chart</div>
					<div class="col-md-7">
						<select name="header-styling" class="form-control input-sm" ng-model="settings.chart" ng-change="updateSettings('chart')">
							<option value="1">Volume On</option>
							<option value="0">Mute</option>
						</select>
					</div>
				</div>
				<div class="row m-t-10">
					<div class="col-md-5 control-label double-line">Disclosure</div>
					<div class="col-md-7">
						<select name="sidebar-styling" class="form-control input-sm" ng-model="settings.disclosure" ng-change="updateSettings('disclosure')">
							<option value="1">Show</option>
							<option value="0">Disable</option>
						</select>
					</div>
				</div>
				<div class="row m-t-10">
					<div class="col-md-12">
						<button type="button" class="btn btn-inverse btn-block btn-sm" data-click="theme-panel-expand">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- end theme-panel -->

	</div>
    <!-- end page container -->

    <div class="arbmobilebtns">
    	<ul>
        	<li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
<?php
require "interactivechart/footer.php";
