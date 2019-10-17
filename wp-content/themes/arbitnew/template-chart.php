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

	<div>
		<div class="chart_logo_arbitrage"><a href="/" target="_blank"><img src="/wp-content/themes/arbitnew/images/arblogo_svg1.svg" style="width: 33px;"></a></div>

        <?php require "interactivechart/components/ticker.php" ?>

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
			<a href="https://vyndue.com/#/login" target="_blank" rel="noopener noreferrer" class="arb-side-icon"><img src="/svg/vyndue-newlogo-white.svg" style="width: 19px;display: inline-block;vertical-align: top;margin-top: 4px;"></a>
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

									<div class="vertical-box-column width-250 mobileinithide" id="right-sidebar">
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
																		<?php require "interactivechart/components/stock-info.php" ?>
																	</div>

																	<?php require "interactivechart/components/stock-sentiments.php" ?>

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
																						<?php require "interactivechart/components/market-depth.php" ?>
																						<?php require "interactivechart/components/transactions.php" ?>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>

																	<?php require "interactivechart/components/bids-asks.php" ?>

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
																							<?php require "interactivechart/components/stocks-list.php" ?>
																							<?php require "interactivechart/components/watchlist.php" ?>
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
		<!-- <div class="theme-panel">
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
		</div> -->
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
