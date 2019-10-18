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
													                <td style="width:9%" class="table-title-live table-title-avprice">Current Price</td>
													                <td style="width:9%" class="table-title-live table-title-avprice">Position</td>
													                <td style="width: 12%;" class="table-title-live table-title-avprice">Avg. Price</td>
													                <td style="width:15%" class="table-title-live table-title-tcost">Total Cost</td>
													                <td style="width:15%" class="table-title-live table-title-mvalue">Market Value</td>
													                <td style="width:10%" class="table-title-live table-title-profit">Profit</td>
													                <td style="width:8%" class="table-title-live table-title-performance">Perf.</td>
													                <td style="width:105px;text-align: left;padding-left: 25px;">Action</td>
													                </tr></thead>
													            </table>
													        </li>
													        <li>
													            <table width="100%">
													                <tbody><tr><td style="width: 7%;text-align: left !important;">PHEN</td>
													                <td style="width:9%" class="table-title-live">2.78</td>
													                <td style="width:9%" class="table-title-live">₱15,000</td>
													                <td style="width: 12%;" class="table-title-live">₱2,213</td>
													                <td style="width:15%" class="table-title-live">₱33,197.65</td>
													                <td style="width:15%" class="table-title-live">₱41,029.47</td>
													                <td style="width:10%" class="dgreenpart table-title-live">₱7,831.82</td>
													                <td style="width:8%" class="dgreenpart table-title-live">23.59%</td>
													                <td style="width:77px;text-align:center;">
													                	<a class="smlbtn fancybox-inline green buymystocks" data-toggle="modal" data-target="#enter_trade" data-stockdetails="" data-boardlot="">BUY</a>
													                	<a class="smlbtn fancybox-inline red sellmystocks" data-toggle="modal" data-target="#enter_trade"data-stockdetails=""data-trades="" data-position="" data-stock="" data-averprice="" >SELL</a>
													                </td>
													                <td style="width:27px; text-align:center"><a data-emotion="" data-toggle="modal" data-target="#livetradenotes" data-strategy="" data-tradeplan="" data-tradingnotes="" data-outcome="" class="livetrbut smlbtn blue fancybox-inline"><i class="fas fa-clipboard"></i></a></td>
													                <td style="width:25px"><a data-stock="" data-totalprice="" class="deletelive smlbtn-delete" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a></td>
													                </tr></tbody>
													            </table>
													        </li>
													        <li>
													            <table width="100%">
													                <tbody><tr><td style="width: 7%;text-align: left !important;">ISM</td>
													                <td style="width:9%" class="table-title-live">4.80</td>
													                <td style="width:9%" class="table-title-live">₱10,000</td>
													                <td style="width: 12%;" class="table-title-live">₱4,975</td>
													                <td style="width:15%" class="table-title-live">₱49,746.32</td>
													                <td style="width:15%" class="table-title-live">₱48,858.76</td>
													                <td style="width:10%" class="dredpart table-title-live">₱-887.56</td>
													                <td style="width:8%" class="dredpart table-title-live">-1.78%</td>
													                <td style="width:77px;text-align:center;">
													                	<a class="smlbtn fancybox-inline green buymystocks" data-stockdetails="" data-boardlot="">BUY</a>
													                	<a class="smlbtn fancybox-inline red sellmystocks" data-stockdetails=""data-trades="" data-position="" data-stock="" data-averprice="" >SELL</a>
													                </td>
													                <td style="width:27px; text-align:center"><a data-emotion="" data-toggle="modal" data-target="#livetradenotes" data-strategy="" data-tradeplan="" data-tradingnotes=""data-outcome="" class="livetrbut smlbtn blue fancybox-inline"><i class="fas fa-clipboard"></i></a></td>
													                <td style="width:25px"><a data-stock="" data-totalprice="" class="deletelive smlbtn-delete" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a></td>
													                </tr></tbody>
													            </table>
													        </li>


													    </ul>

																 <div class="modal fade" id="livetradenotes" role="dialog">
																	<div class="modal-dialog">
																		 <div class="modal-content modal_logs">
																            <div class="entr_ttle_bar" style="width: 94%;margin: 10px;">
																                <strong>Trade Details</strong>
																                 <button type="button" class="close_btnlogs" data-dismiss="modal">&times;</button>
																            </div>
																            <hr class="style14 style15" style="width: 93% !important;margin: 5px auto !important;">
																            <div class="trdlgsbox">

																                <div class="trdleft">
																                    <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Strategy:</strong></span> <span class="modal-notes-result modal-notes-result-toleft addstrats">Bottom Picking</span></div>
																                    <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Trade Plan:</strong></span> <span class="modal-notes-result modal-notes-result-toleft addtplan">Day Trade</span></div>
																                    <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Emotion:</strong></span> <span class="modal-notes-result modal-notes-result-toleft addemotion">Neutral</span></div>
																                    <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Outcome:</strong></span> <span class="modal-notes-result modal-notes-result-toleft txtred addoutcome">Winning</span></div>
																                </div>
																                <div class="trdright darkbgpadd">
																                    <div><strong>Notes:</strong></div>
																                    <div class="addnotes">Trading Notes</div>
																                </div>
																                <div class="trdclr"></div>
																            </div>
																        </div>
																    </div>
																</div>

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
									                    
									                </div>
									            </div>

									        </div>
									    </div>
									    <br class="clear">

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
