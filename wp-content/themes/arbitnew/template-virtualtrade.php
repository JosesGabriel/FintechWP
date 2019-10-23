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


<!--<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/journal_style.css?<?php echo time(); ?>">-->

<?php //get_template_part('parts/sidebar', 'calc'); ?>
<?php //get_template_part('parts/sidebar', 'varcalc'); ?>
<?php //get_template_part('parts/sidebar', 'avarageprice'); ?>

<!-- BOF Trade Logs Data from DB -->
<?php
	//global $wpdb;
	//$sql = "select * from arby_vt_live where userid = ".$user->ID;
   // $query = $wpdb->get_results($sql);
   
?>


<div id="main-content" class="oncommonsidebar">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div class="left-dashboard-part">
				<div class="dashboard-sidebar-left" id="testdiv">
					<div class="dashboard-sidebar-left-inner">

						<?php //require("parts/global-sidebar.php"); ?>
						<?php require("virtual/virtual-sidebar.php"); ?>
						<div id="canvasImg"></div>
					</div>
				</div>
			</div>
			<div class="center-dashboard-part" style="max-width: 1000px !important;">
				<div class="inner-center-dashboard">
					<div class="post-content">
						<div id="virtual-trade-wrapper">
							<div class="row">
								<div class="col-md-12">

									<div class="liveportfoliobox">
                                        <div class="box-portlet">
                                            <div class="box-portlet-header">
                                                Live Portfolio
                                                <div class="dltbutton virtual_button">
													<?php require __DIR__ . "/components/modals/share.php" ?>
													<?php require "virtual/enter-trade.php";?>
													<div class="dbuttondelete">
														<form action="/virtual-trades" method="post" class="resetform">
															<input type="hidden" name="deletedata" value="reset">
															<input type="button" name="resetdd" value="Reset" class="delete-data-btn resetdata">
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
									                        </ul>
									                        <div class="totalpl" style="font-size: 13px;padding-top: 12px;">
														            <p>Total Profit/Loss as of <?php echo date('F j, Y'); ?>: <span class="totalplscore"></span></p>
														    </div>
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

