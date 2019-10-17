<?php
    /*
    * Template Name: Journal Design
    */

// get_header();
// Ralph Was Here 
// Trading Journal
global $current_user, $wpdb;
$user = wp_get_current_user();
date_default_timezone_set('Asia/Manila');

require("virtual/header-files.php");
require("parts/global-header.php");

?>


<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/journal_style.css?<?php echo time(); ?>">

<?php get_template_part('parts/sidebar', 'calc'); ?>
<?php get_template_part('parts/sidebar', 'varcalc'); ?>
<?php get_template_part('parts/sidebar', 'avarageprice'); ?>

<!-- BOF Trade Logs Data from DB -->
<?php

    if (isset($_POST) && strtolower(@$_POST['deletedata']) == 'reset') {

		
        $dlistofstocks = get_user_meta($user->ID, '_trade_list', true);

        // Delete Live Trade
        foreach ($dlistofstocks as $delkey => $delvalue) {
            update_user_meta($user->ID, '_trade_'.$delvalue, '');
            delete_user_meta($user->ID, '_trade_n  '.$delvalue);

            // $dsotcksss = get_user_meta($user->ID, '_trade_'.$delvalue, true);
        }
		delete_user_meta($user->ID, '_trade_list');
		

		update_user_meta($user->ID, 'issampleactivated', 'no');
        // delete ledger
		$wpdb->get_results('delete from arby_ledger where userid = '.$user->ID);
		$deletelogs = 'delete from arby_tradelog where isuser ='.$user->ID;
		$wpdb->query($deletelogs);
        wp_redirect('/journal');
        exit;
    }
?>
<!-- Delete Data -->
<!-- BOF Record a Trade -->
	<?php require "journal/record-trade.php";?>
<!-- EOF Record a Trade -->


<div id="main-content" class="oncommonsidebar">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">

						<?php require("parts/global-sidebar.php"); ?>

					</div>
				</div>
			</div>
			<div class="center-dashboard-part" style="max-width: 1000px !important;">
				<div class="inner-center-dashboard">
					<div class="post-content">
						<div>
							<div class="row">
								<div class="col-md-12">

									<div class="liveportfoliobox">
                                        <div class="box-portlet">
                                            <div class="box-portlet-header">
                                                Live Portfolio
                                                <div class="dltbutton">    
													<?php require "virtual/enter-trade.php";?>
													<div class="dbuttondelete">
														<form action="/virtual-trades" method="post" class="resetform">
															<input type="hidden" name="deletedata" value="reset">
															<input type="submit" name="resetdd" value="Reset" class="delete-data-btn resetdata">
														</form>
													</div>												
                                        		</div>
                                            </div>
                                            <div class="box-portlet-content">
                                                <div class="stats-info">
                                                	<div id="live_portfolio" class="dstatstrade overridewidth">
	                                                    <ul>
													        <li class="headerpart">
													            <table width="100%">
													                <thead><tr><td style="width: 7%;text-align: left !important;">Stocks</td>
													                <td style="width:9%" class="table-title-live table-title-avprice">Position</td>
													                <td style="width: 12%;" class="table-title-live table-title-avprice">Avg. Price</td>
													                <td style="width:15%" class="table-title-live table-title-tcost">Total Cost</td>
													                <td style="width:15%" class="table-title-live table-title-mvalue">Market Value</td>
													                <td style="width:15%" class="table-title-live table-title-profit">Profit</td>
													                <td style="width:8%" class="table-title-live table-title-performance">Perf.</td>
													                <td style="width:105px;text-align: left;padding-left: 25px;">Action</td>
													                </tr></thead>
													            </table>
													        </li>
													        <li>
													            <table width="100%">
													                <tbody><tr><td style="width: 7%;text-align: left !important;">PHEN</td>
													                <td style="width:9%" class="table-title-live">₱15,000</td>
													                <td style="width: 12%;" class="table-title-live">₱2,213</td>
													                <td style="width:15%" class="table-title-live">₱33,197.65</td>
													                <td style="width:15%" class="table-title-live">₱41,029.47</td>
													                <td style="width:15%" class="dgreenpart table-title-live">₱7,831.82</td>
													                <td style="width:8%" class="dgreenpart table-title-live">23.59%</td>
													                <td style="width:77px;text-align:center;">
													                	<a class="smlbtn fancybox-inline green buymystocks" data-stockdetails="" data-boardlot="">BUY</a>
													                	<a class="smlbtn fancybox-inline red sellmystocks" data-stockdetails=""data-trades="" data-position="" data-stock="" data-averprice="" >SELL</a>
													                </td>
													                <td style="width:27px; text-align:center"><a data-emotion="" data-strategy="" data-tradeplan="" data-tradingnotes" data-outcome="" class="livetrbut smlbtn blue fancybox-inline"><i class="fas fa-clipboard"></i></a></td>
													                <td style="width:25px"><a data-stock="" data-totalprice="" class="deletelive smlbtn-delete" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a></td>
													                </tr></tbody>
													            </table>
													        </li>


													    </ul>
													</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                        <div class="tradelogsbox">
									        <div class="box-portlet">

									            <div class="box-portlet-header" style="padding-bottom: 20px;">
									            <span class="title_logss">Tradelogs</span>
									                <div class="headright" style="display:none;">
									                    <form action="" method="get" id="ptchangenum">
									                        <input type="number" id="ptnum" name="ptnum">
									                        <input type="hidden" name="pt" value="1">
									                        <a href="#" class="dmoveto">Go</a>
									                    </form>
									                </div>

									            </div>
									            <div class="box-portlet-content">
									                <div class="stats-info">
									                    <div class="dstatstrade showtradelogs overridewidth dstatstrade1">
									                        <ul>
									                            <li class="headerpart headerpart-tradelogs">
									                                <div style="width:100%;">
									                                    <div style="width:45px">Stocks</div>                                                                                	
									                                    <div style="width:65px">Date</div>
									                                    <div style="width:55px" class="table-title-live">Volume</div>
									                                    <div style="width:65px" class="table-title-live">Ave. Price</div>
									                                    <div style="width:95px" class="table-title-live">Buy Value</div>
									                                    <div style="width:65px" class="table-title-live">Sell Price</div>
									                                    <div style="width:88px" class="table-title-live">Sell Value</div>
									                                    <div style="width:80px" class="table-title-live">Profit/Loss</div>
									                                    <div style="width:65px" class="table-title-live">%</div>
									                                    <div style="width:65px; text-align:center">Action</div>
									                                </div>
									                            </li>
									                            <li>
									                            	<div style="width:100%;">
									                                    <div style="width:45px">2GO</div>                                                                                	
									                                    <div style="width:65px">2019-02-23</div>
									                                    <div style="width:55px" class="table-title-live">2</div>
									                                    <div style="width:65px" class="table-title-live">₱24.87</div>
									                                    <div style="width:95px" class="table-title-live">₱24.87</div>
									                                    <div style="width:65px" class="table-title-live">₱10.00</div>
									                                    <div style="width:88px" class="table-title-live">₱91.89</div>
									                                    <div style="width:80px" class="table-title-live">₱22.55</div>
									                                    <div style="width:65px" class="table-title-live">32.52%</div>
									                                    <div style="width:65px; text-align:center">
									                                    	<div style="width:27px; text-align:center"><a class="smlbtn blue tldetails" data-tlstrats="" data-tltradeplans="" data-tlemotions="" data-tlnotes="" data-outcome=""><i class="fas fa-clipboard"></i></a></div>
									                                    	<div style="width:25px"><a class="deletelog smlbtn-delete" data-istl="" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a></div>

									                                    </div>
									                                </div>
									                            	
									                            </li>
									                        </ul>
									                    </div>
									                    <div class="deleteform">
									                        <form class="deleteformitem" action="" method="post">
									                            <input type="hidden" value="" name="todelete" id="todelete">
									                        </form>
									                    </div>
									                    <!-- <div class="pagination">
									                        <div class="pginner">
									                            <ul>
									                                <?php for ($i = 1; $i <= $dpage; ++$i) {
									                                    ?>
									                                    <li><a href="/journal/?pt=<?php echo $i; ?>"><?php echo $i; ?></a></li>
									                                <?php
									                                } ?>
									                            </ul>
									                        </div>
									                    </div>	 -->
									                </div>
									            </div>

									        </div>
									    </div>
									    <br class="clear">
									    <!--
									    <div class="totalpl">
									            <p>Total Profit/Loss as of <?php echo date('F j, Y'); ?>: <span class="totalplscore"></span></p>
									    </div>
									    <br class="clear">-->

                                    
                                    <!--
						            <div class="panel panel-primary">
						               <div class="panel-heading">
						                    <span id="journal" class="journaltabs">
						                     
						                        <ul class="nav testss">
						                            <li class="<?php //echo isset($_GET['pt']) || isset($_GET['ld']) ? '' : 'active'; ?>"><a href="#tab1" data-toggle="tab" class="<?php echo isset($_GET['pt']) || isset($_GET['ld']) ? '' : 'active show'; ?>">Dashboard</a></li>
						                            <li class="<?php// echo isset($_GET['pt']) ? 'active' : ''; ?>"><a href="#tab2" data-toggle="tab" class="<?php echo isset($_GET['pt']) ? 'active show' : ''; ?> opentradelogtab">Tradelogs</a></li>
						                            <li class="<?php //echo isset($_GET['ld']) ? 'active' : ''; ?>"><a href="#tab3" data-toggle="tab" class="<?php echo isset($_GET['ld']) ? 'active show' : ''; ?> openledger">Ledger</a></li>
						                        </ul>
						                    </span>
						                </div>
						                <div class="panel-body">
						                    <div class="tab-content">
						                        <div class="tab-pane <?php //echo isset($_GET['pt']) || isset($_GET['ld']) ? '' : 'active'; ?>" id="tab1">
                                                    <div class="liveportfoliobox">
                                                        <div class="box-portlet">
                                                            <div class="box-portlet-header">
                                                                Live Portfolio
                                                                <div class="dltbutton">
                                                                	
																	<?php //require "journal/enter-trade.php";?>

																	<div class="dbuttondelete">
																		<form action="/journal" method="post" class="resetform">
																			<input type="hidden" name="deletedata" value="reset">
																			<input type="submit" name="resetdd" value="Reset" class="delete-data-btn resetdata">
																		</form>
																	</div>
																	
                                                        		</div>
                                                            </div>
                                                            <div class="box-portlet-content">
                                                                <div class="stats-info">
                                                                    <?php //require "journal/live_portfolio.php";?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                	<?php //require "journal/dashboard.php";?>
						                        </div>
						                        <div class="tab-pane <?php //echo isset($_GET['pt']) ? 'active' : ''; ?>" id="tab2">
													<?php //require "journal/tradelogs.php";?>
						                        </div>
						                        <div class="tab-pane <?php //echo isset($_GET['ld']) ? 'active' : ''; ?>" id="tab3">
													<?php //require "journal/ledger.php";?>
                                                	<br class="clear">
						                        </div>
						                    </div>
						                </div>
						            </div> -->


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

<?php
get_template_part('parts/sidebar', 'alert');
require "virtual/footer-files.php";
