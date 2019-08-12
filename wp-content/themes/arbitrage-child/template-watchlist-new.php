<?php

	/*
	* Template Name: Watchlist Page New
	* Template page for Watchlist Page Platform
    */

global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
get_header( 'dashboard' );

date_default_timezone_set('Asia/Manila');

?>    

<?php
// adding static json list of stocks
$staticstock = '["2GO","8990P","AAA","AB","ABA","ABC","ABG","ABS","ABSP","AC","ACE","ACPA","ACPB1","ACPB2","ACR","AEV","AGI","ALCO","ALCPB","ALHI","ALI","ALL","ANI","ANS","AP","APC","APL","APO","APX","AR","ARA","AT","ATI","ATN","ATNB","AUB","BC","BCB","BCOR","BCP","BDO","BEL","BH","BHI","BKR","BLFI","BLOOM","BMM","BPI","BRN","BSC","CA","CAB","CAT","CDC","CEB","CEI","CEU","CHI","CHIB","CHP","CIC","CIP","CLC","CLI","CNPF","COAL","COL","COSCO","CPG","CPM","CPV","CPVB","CROWN","CSB","CYBR","DAVIN","DD","DDPR","DELM","DFNN","DIZ","DMC","DMCP","DMPA1","DMPA2","DMW","DNA","DNL","DTEL","DWC","EAGLE","ECP","EDC","EEI","EG","EIBA","EIBB","ELI","EMP","EURO","EVER","EW","FAF","FB","FBP","FBP2","FDC","FERRO","FEU","FFI","FGEN","FGENF","FGENG","FIN","FJP","FJPB","FLI","FMETF","FNI","FOOD","FPH","FPHP","FPHPC","FPI","FYN","FYNB","GEO","GERI","GLO","GLOPA","GLOPP","GMA7","GMAP","GPH","GREEN","GSMI","GTCAP","GTPPA","GTPPB","H2O","HDG","HI","HLCM","HOUSE","HVN","I","ICT","IDC","IMI","IMP","IND","ION","IPM","IPO","IRC","IS","ISM","JAS","JFC","JGS","JOH","KEP","KPH","KPHB","LAND","LBC","LC","LCB","LFM","LIHC","LMG","LOTO","LPZ","LR","LRP","LRW","LSC","LTG","M-O","MA","MAB","MAC","MACAY","MAH","MAHB","MARC","MAXS","MB","MBC","MBT","MED","MEG","MER","MFC","MFIN","MG","MGH","MHC","MJC","MJIC","MPI","MRC","MRP","MRSGI","MVC","MWC","MWIDE","MWP","NI","NIKL","NOW","NRCP","NXGEN","OM","OPM","OPMB","ORE","OV","PA","PAL","PAX","PBB","PBC","PCOR","PCP","PERC","PGOLD","PHA","PHC","PHEN","PHES","PHN","PIP","PIZZA","PLC","PMPC","PMT","PNB","PNC","PNX","PNX3A","PNX3B","PNXP","POPI","PORT","PPC","PPG","PRC","PRF2A","PRF2B","PRIM","PRMX","PRO","PSB","PSE","PSEI","PTC","PTT","PX","PXP","RCB","RCI","REG","RFM","RLC","RLT","ROCK","ROX","RRHI","RWM","SBS","SCC","SECB","SEVN","SFI","SFIP","SGI","SGP","SHLPH","SHNG","SLF","SLI","SM","SMC","SMC2A","SMC2B","SMC2C","SMC2D","SMC2E","SMC2F","SMC2G","SMC2H","SMC2I","SMCP1","SMPH","SOC","SPC","SPM","SRDC","SSI","SSP","STI","STN","STR","SUN","SVC","T","TBGI","TECB2","TECH","TEL","TFC","TFHI","TLII","TLJJ","TUGS","UBP","UNI","UPM","URC","V","VITA","VLL","VMC","VUL","VVT","WEB","WIN","WLCON","WPI","X","ZHI"]';

$havemeta = get_user_meta($userID, '_watchlist_instrumental', true);

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['subtype']) && $_POST['subtype'] == 'editdata') {

        foreach ($havemeta as $key => $value) {
            if ($value['stockname'] == $_POST['stockname']) {
                unset($havemeta[$key]);
            }
        }

        array_push($havemeta, $_POST);
        update_user_meta($userID, '_watchlist_instrumental', $havemeta);

        wp_redirect( 'https://arbitrage.ph/watchlist' );
        exit;

    } else {

        if (isset($havemeta) && !empty($havemeta)){
            if (in_array($_POST['stockname'], array_column($havemeta, 'stockname'))) {
                echo "Stock Already Exist";
            } else {
                array_push($havemeta, $_POST);
                update_user_meta($userID, '_watchlist_instrumental', $havemeta);
            }

        } else {
            $newarray = [];
            array_push($newarray, $_POST);
            // add_user_meta($userID, '_watchlist_instrumental', $newarray);
            update_user_meta($userID, '_watchlist_instrumental', $newarray);
        }

        wp_redirect( 'https://arbitrage.ph/watchlist' );
        exit;
    }


}

if (isset($_GET['remove'])) {
    foreach ($havemeta as $key => $value) {
        if ($value['stockname'] == $_GET['remove']) {
            unset($havemeta[$key]);
        }
    }
    update_user_meta($userID, '_watchlist_instrumental', $havemeta);
    wp_redirect( 'https://arbitrage.ph/watchlist' );
}

//removing date compare function as it broke the page:

#function date_compare($a, $b)
#{
#    $t1 = strtotime($a['toadddate']);
#    $t2 = strtotime($b['toadddate']);
#    return $t1 - $t2;
#}

#if ($havemeta) {
#    usort($havemeta, 'date_compare');
#    array_reverse($havemeta);
#}

#function working_days_ago($days) {
#    $count = 0;
#    $day = strtotime('-2 day');
#    while ($count < $days || date('N', $day) > 5) {
#       $count++;
#       $day = strtotime('-1 day', $day);
#    }
#    return date('Y-m-d', $day);
#}

$watchinfo = get_user_meta('7', '_scrp_stocks_chart', true);

?>



    <?php get_template_part('parts/global', 'css'); ?>
    <?php get_template_part('parts/sidebar', 'calc'); ?>
    <?php get_template_part('parts/sidebar', 'varcalc'); ?>
    <?php get_template_part('parts/sidebar', 'avarageprice'); ?>    

    <div id="main-content" class="ondashboardpage">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			
			<div class="left-dashboard-part" id="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">
						
						<?php get_template_part('parts/sidebar', 'tasks'); ?>
                    
                    	<?php get_template_part('parts/sidebar', 'profile'); ?>
                        
					</div>
				</div>
			</div>
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="add-post">
                        <!--start content-->

                        <div class="row">
							<div class="col-md-12" style="padding-right: 3px;padding-left: 3px;">
								<div class="box-portlet">
									<!-- <div class="box-portlet-header">

										<h2 class="watchtitle">My Watchlist</h2>
										<hr class="style14 style15" style="width: 96% !important;margin-bottom: 2px !important;margin-top: 6px !important;text-align: center;/* margin: 5px 0px !important; */">
									</div> -->
									<div class="box-portlet-content">
										<div class="dtabcontent">
											<div class="dclosetab watchtab active">

												<div class="dinnerlist">
													<?php if ($havemeta): ?>
														<ul>
															<li class="addwatch">
																<div class="dplusbutton">
																	<div class="dplsicon"><i class="fa fa-plus-circle"></i></div>
																	<!-- <div class="dplstext">Add watchlist</div> -->
																</div>
															</li>
															<?php


																$curl = curl_init();

                                                                #curl_setopt($curl, CURLOPT_URL, 'https://api2.pse.tools/api/quotes' );
                                                                curl_setopt($curl, CURLOPT_URL, 'https://arbitrage.ph/charthisto/?g=sampleprice' );
                                                                
                                                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                                                $dwatchinfo = curl_exec($curl);
                                                                #$dwatchinfo = $staticstock;
																curl_close($curl);
                                                                
                                                                $genstockinfo = json_decode($dwatchinfo);
                                                                //echo var_dump($genstockinfo);

																$stockinfo = $genstockinfo->data;

                                                                $counters = 0;
															?>
															<?php foreach ($havemeta as $key => $value) { ?>

                                                                <?php $counters++; ?>

																<?php

																$dstock = $value['stockname'];
																$dprice = $stockinfo->$dstock->last;
																$dchange = $stockinfo->$dstock->change;
																	// get current price and increase/decrease percentage
																	// $curl = curl_init();
																	// // curl_setopt($curl, CURLOPT_URL, 'http://phisix-api4.appspot.com/stocks/'.$value['stockname'].'.json');
																	// curl_setopt($curl, CURLOPT_URL, 'https://chart.pse.tools/api/intraday/?symbol='.$value['stockname'].'&firstDataRequest=true&from='.date('Y-m-d') );
																	// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
																	// $dwatchinfo = curl_exec($curl);
																	// curl_close($curl);

																	// $dstockinfo = json_decode($dwatchinfo);
																	// $dinstall = get_object_vars($dstockinfo);

																?>

																<li class="watchonlist" class="to-watch-data" data-dstock="<?php echo $value['stockname']; ?>" data-dhisto='<?php echo json_encode($dstockinfo); ?>'>

																	<div class="deleteme">
																		<div><a href="#" class="removeItem" data-space="<?php echo $value['stockname']; ?>"><i class="fa fa-trash"></i></a></div>
																		<div><a href="#" class="editItem" data-toggle="modal" data-target="#modal<?php echo $value['stockname']; ?>" data-space="<?php echo $value['stockname']; ?>"><i class="fa fa-edit"></i></a></div>
																	</div>

																	<div class="row">

                                                                        <div class="wlttlstockvals">

                                                                            <span class="stocknn"><?php echo $value['stockname']; ?></span>

                                                                            <span style="display:none;" class="subnotif">
                                                                                <?php foreach ($value['delivery_type'] as $dtkey => $dtvalue) {
                                                                                    echo ($dtvalue == 'web-notif' ? 'Web Notif' : 'SMS Notif');
                                                                                    echo ",";
                                                                                } ?>
                                                                            </span>

                                                                            <?php if($dchange < 0){$valcolor = "onred";}else{$valcolor = "ongreen";} ?>

                                                                            <span class="curprice <?php echo $valcolor; ?>">&#8369;<?php echo number_format( $dprice, 2, '.', ',' ); ?></span>

                                                                            <span class="curchange <?php echo $valcolor; ?>">(<?php echo $dchange; ?>%)</span>

                                                                            <?php /*?><?php if (strpos($dinstall['stock'][0]->percent_change, '-') !== false): ?>
                                                                                <span class="curchange onred">(<?php echo $dinstall['stock'][0]->percent_change; ?>%)</span>
                                                                            <?php else: ?>
                                                                                <span class="curchange ongreen">(+<?php echo $dinstall['stock'][0]->percent_change; ?>%)</span>
                                                                            <?php endif; ?>

                                                                            <span class="curprice">&#8369;<?php echo $dinstall['stock'][0]->price->amount; ?></span><?php */?>

                                                                        </div>

																		<div class="col-md-12" style="padding-top: 12px;">

                                                                          <div class="minichartt">
                                                                            <a href="https://arbitrage.ph/chart/<?php echo $value['stockname']; ?>" target="_blank" class="stocklnk"></a>
                                                                            <div ng-controller="minichartarb<?php echo strtolower($value['stockname']); ?>">
                                                                                <nvd3 options="options" data="data" class="with-3d-shadow with-transitions"></nvd3>
                                                                            </div>
                                                                          </div>

																		</div>
																		<div>

																		<br style="clear:both;">

																		</div>
																	</div>

																	<div class="dparams">
																		<ul>
																			<?php // if (isset($value['dcondition_entry_price'])): ?>
																				<li>
																					<div class="dcondition">Entry Price</div>
																					<div class="dvalue">
																						<span class="ontoleft">₱ <?php echo @$value['dconnumber_entry_price']; ?></span>
																					</div>
																				</li>
																			<?php // endif ?>
																			<?php // if (isset($value['dcondition_take_profit_point'])): ?>
																				<li>
																					<div class="dcondition">Take Profit</div>
																					<div class="dvalue">
																						<span class="ontoleft">₱ <?php echo @$value['dconnumber_take_profit_point']; ?></span>
																					</div>
																				</li>
																			<?php // endif ?>
																			<?php // if (isset($value['dcondition_stop_loss_point'])): ?>
																				<li>
																					<div class="dcondition">Stop <br/>Loss</div>
																					<div class="dvalue">
																						<span class="ontoleft">₱ <?php echo @$value['dconnumber_stop_loss_point']; ?></span>
																					</div>
																				</li>
																			<?php // endif ?>
																		</ul>
																	</div>
																	<div class="modal fade dmodaleditwatch" id="modal<?php echo $value['stockname']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																	  <div class="modal-dialog" role="document">
																	    <div class="modal-content" style="background: #0d1f33;padding: 15px;">
																	      <div class="modal-header">
																	        <h5 class="modal-title" id="exampleModalLabel" style="color: #333;"><?php echo $value['stockname']; ?></h5>
																	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	          <span aria-hidden="true">&times;</span>
																	        </button>
																	      </div>
																	      <div class="modal-body">
																	        <div class="">
																				<div class="editme">
																					<form method="post" action="#" id="edit-watchlist-param-<?php echo strtolower($value['stockname']); ?>">
																						<input type="hidden" name="stockname" value="<?php echo $value['stockname']; ?>">
																						<div class="instumentinner">
																							<div class="row">
																								<div class="col-md-8">
																									<div class="innerdeliver">
																										<ul>
																											<li><input id="webpop" type="checkbox" name="delivery_type[]" value="web-notif" <?php echo (in_array("web-notif", $value['delivery_type']) ? 'checked' : ''); ?>><label id="webpop">Website Popup</label></li>
																											<li><input id="smspop" type="checkbox" name="delivery_type[]" value="sms-notif" <?php echo (in_array("sms-notif", $value['delivery_type']) ? 'checked' : ''); ?>><label id="smspop">SMS Notif</label></li>
																											<li><input id="emailpop" type="checkbox" name="delivery_type[]" value="email-notif" <?php echo (in_array("email-notif", $value['delivery_type']) ? 'checked' : ''); ?>><label id="smspop">Email Notif</label></li>
                                                      <!--<li><input id="fbmpop" type="checkbox" name="delivery_type[]" value="fbm-notif" <?php //echo (in_array("fbm-notif", $value['delivery_type']) ? 'checked' : ''); ?>><label id="fbmpop">FB Messenger</label></li>-->
                                                      <!--<li><input id="whtapppop" type="checkbox" name="delivery_type[]" value="whtapp-notif" <?php //echo (in_array("whtapp-notif", $value['delivery_type']) ? 'checked' : ''); ?>><label id="whtapppop">WhatsApp</label></li>-->
																										</ul>
																									</div>
																								</div>
																								<div class="col-md-12">
																									<div class="row">
																										<div class="col-md-6">
																											<div class="condition-params">
																												<div class="condition-type">
																													<label>Conditions</label>
																													<select id="condition-list">
																														<option value="">Select Conditions</option>
																														<option style="<?php echo ($value['dcondition_entry_price'] == 'entry_price' ? 'display: none;' : ''); ?>" value="entry_price">Entry Price</option>
																														<option style="<?php echo ($value['dcondition_take_profit_point'] == 'take_profit_point' ? 'display: none;' : ''); ?>" value="take_profit_point">Take Profit Point</option>
																														<option style="<?php echo ($value['dcondition_stop_loss_point'] == 'stop_loss_point' ? 'display: none;' : ''); ?>" value="stop_loss_point">Stop Loss Point</option>
																													</select>
																												</div>
																												<div class="condition-freq">
																													<label>Condition Frequency</label>
																													<input type="number" id="condition_frequency" name="confreq">
																												</div>
																												<div class="addtolist">
																													<button class="add-params">Add Parameters</button>
																												</div>
																											</div>
																										</div>
																										<div class="col-md-6">
																											<div class="dpaste">
																												<ul class="listofinfo">
																													<?php if (isset($value['dcondition_entry_price'])): ?>
																														<li class="dbaseitem">
																															<div class="dinfodata">
																																<div class="dcondition"><?php echo $value['dcondition_entry_price']; ?></div>
																																<div class="dfreq"><?php echo $value['dconnumber_entry_price']; ?></div>
																															</div>
																															<div class="closetab">
																																<input type="hidden" id="dparamcondition" name="dcondition_entry_price" value="<?php echo $value['dcondition_entry_price']; ?>">
																																<input type="hidden" id="" name="dconnumber_entry_price" value="<?php echo $value['dconnumber_entry_price']; ?>">
																																<button class="closemebutton">×</button>

																															</div>
																														</li>
																													<?php endif ?>
																													<?php if (isset($value['dcondition_take_profit_point'])): ?>
																														<li class="dbaseitem">
																															<div class="dinfodata">
																																<div class="dcondition"><?php echo $value['dcondition_take_profit_point']; ?></div>
																																<div class="dfreq"><?php echo $value['dconnumber_take_profit_point']; ?></div>
																															</div>
																															<div class="closetab">
																																<input type="hidden" id="dparamcondition" name="dcondition_take_profit_point" value="<?php echo $value['dcondition_take_profit_point']; ?>">
																																<input type="hidden" id="" name="dconnumber_take_profit_point" value="<?php echo $value['dconnumber_take_profit_point']; ?>">
																																<button class="closemebutton">×</button>
																															</div>
																														</li>
																													<?php endif ?>
																													<?php if (isset($value['dcondition_stop_loss_point'])): ?>
																														<li class="dbaseitem">
																															<div class="dinfodata">
																																<div class="dcondition"><?php echo $value['dcondition_stop_loss_point']; ?></div>
																																<div class="dfreq"><?php echo $value['dconnumber_stop_loss_point']; ?></div>
																															</div>
																															<div class="closetab">
																																<input type="hidden" id="dparamcondition" name="dcondition_stop_loss_point" value="<?php echo $value['dcondition_stop_loss_point']; ?>">
																																<input type="hidden" id="" name="dconnumber_stop_loss_point" value="<?php echo $value['dconnumber_stop_loss_point']; ?>">
																																<button class="closemebutton">×</button>
																															</div>
																														</li>
																													<?php endif ?>

																												</ul>
																											</div>
																										</div>
																										<div class="col-md-12">
																											<div class="submitform">
																												<input type="hidden" name="toadddate" value="<?php echo $value['toadddate']; ?>">
																												<input type="hidden" name="isticked" value="<?php echo time(); ?>">
																												<input type="hidden" name="subtype" value="editdata">
																												<button class="editmenow" data-tochange="edit-watchlist-param-<?php echo strtolower($value['stockname']); ?>">Change</button>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</form>
																				</div>
																			</div>
																	      </div>
																	    </div>
																	  </div>
																	</div>

																</li>
															<?php } ?>

														</ul>
													<?php else: ?>
														<ul>
															<li class="addwatch">
																<div class="dplusbutton">
																	<div class="dplsicon"><i class="fa fa-plus-circle"></i></div>
																	<div class="dplstext">Add watchlist</div>
																</div>
															</li>
														</ul>
													<?php endif; ?>
												</div>
											</div>
											<div class="dclosetab addwatchtab ">
												<form method="post" action="" id="add-watchlist-param">
													<div class="instumentinner">
														<div class="">
															<div class="dselectstockname">
																<div class="dropdown ddropconts">
																	<button id="myDropdown" class="dropbtn">Select a Stock</button>
																	<div class="dropdown-content ddropbase" style="display: none;">
																		<input type="hidden" id="dstockname" name="stockname">
																		<input type="text" placeholder="Search.." id="myInput">
																		<div class="listofstocks"></div>
																	</div>
																</div>
																<div class="dselected"></div>
															</div>
															<div class="">
																<div class="innerdeliver">
																	<ul>
																		<li><input type="checkbox" name="delivery_type[]" value="web-notif" style=""><label>Website Popup</label></li>
																		<li><input type="checkbox" name="delivery_type[]" value="sms-notif"><label>SMS Notification</label></li>
																		<li><input type="checkbox" name="delivery_type[]" value="email-notif"><label>Email Notification</label></li>
                                    <!--<li><input type="checkbox" name="delivery_type[]" value="fbm-notif"><label>FB Messenger</label></li>-->
                                    <!--<li><input type="checkbox" name="delivery_type[]" value="whtapp-notif"><label>WhatsApp</label></li>-->
																	</ul>
																</div>
															</div>
															<div class="col-md-12">
																<div class="row">
																	<div class="col-md-6" style="padding-left: 0 !important;">
																		<div class="condition-params">
																			<div class="condition-type">
																				<select id="condition-list">
																					<option value="">Select Conditions</option>
																					<option value="entry_price">Entry Price</option>
																					<option value="take_profit_point">Take Profit Point</option>
																					<option value="stop_loss_point">Stop Loss Point</option>
																				</select>
																			</div>
																			<div class="condition-freq">
																				<input type="number" id="condition_frequency" name="confreq">
																			</div>
																			<div class="addtolist">
																				<button class="add-params">Add Parameters</button>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="dpaste">
																			<ul class="listofinfo"></ul>
																		</div>
																	</div>
																	<div class="col-md-12" style="padding-right: 8px;">
																		<div class="submitform">
																			<input type="hidden" name="toadddate" value="<?php echo date('m/d/Y h:i:s a', time()); ?>">
																			<input type="hidden" name="isticked" value="<?php echo time(); ?>">
																			<button id="canceladd">Cancel</button>
																			<button id="submitmenow">Submit</button>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</form>
											</div>
										</div>
										<br class="clear">
									</div>
									<?php /*?><div class="box-portlet-footer"></div><?php */?>
								</div>
							</div>
						</div>



                        <!--end content-->
					</div>
				</div>
			</div>
			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">

					<?php get_template_part('parts/sidebar', 'trendingstocks'); ?>
					
					<?php get_template_part('parts/sidebar', 'traders'); ?>
                    
                    <?php //get_template_part('parts/sidebar', 'latestnews'); ?>
                    
                    <?php get_template_part('parts/sidebar', 'watchlist'); ?>

                    <?php get_template_part('parts/sidebar', 'alert'); ?>
					
					<?php get_template_part('parts/sidebar', 'footer'); ?>

				</div>
			</div>

			<br class="clear">
		</div>
	</div>

</div>

<?php get_footer('dashboard'); ?>

<script>
    if (typeof angular !== 'undefined') {
		var app = angular.module('arbitrage_wl', ['nvd3']);
		<?php
		if ($havemeta) {
		foreach ($havemeta as $key => $value) {



			// get stcok history
			$curl = curl_init();
            #curl_setopt($curl, CURLOPT_URL, 'https://chart.pse.tools/api/history2?symbol='.$value['stockname'].'&firstDataRequest=true&from='.working_days_ago('20') );
            curl_setopt($curl, CURLOPT_URL, 'https://chart.pse.tools/api/history2?symbol='.$value['stockname'].'&firstDataRequest=true&from='.working_days_ago('20') );
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$dhistofronold = curl_exec($curl);
			curl_close($curl);

			$dhistoforchart = json_decode($dhistofronold);

			$dhistoflist = "";
			$counter = 0;
			for ($i=0; $i < (count($dhistoforchart->o)); $i++) {
				$dhistoflist .= '{"date": '.($i + 1).', "open": '.$dhistoforchart->o[$i].', "high": '.$dhistoforchart->h[$i].', "low": '.$dhistoforchart->l[$i].', "close": '.$dhistoforchart->c[$i].'},';
				$counter++;
			}

			$currentTime = (new DateTime())->modify('+1 day');
			$startTime = new DateTime('15:30');
			$endTime = (new DateTime('09:00'))->modify('+1 day');

			if ($currentTime >= $startTime && $currentTime <= $endTime) {
			  	$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, 'https://chart.pse.tools/api/intraday/?symbol='.$value['stockname'].'&firstDataRequest=true&from='.date('Y-m-d') );
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$dintrabase = curl_exec($curl);
				curl_close($curl);

				$dintraforchart = json_decode($dintrabase);

				$open = end($dintraforchart->o);
				$high = end($dintraforchart->h);
				$low = end($dintraforchart->l);

				$dhistoflist .= '{"date": '.($counter + 1).', "open": '.$open.', "high": '.$high.', "low": '.$low.', "close": 0},';
			}



			?>
		app.controller('minichartarb<?php echo strtolower($value['stockname']); ?>', function($scope) {
			$scope.options = {
					chart: {
						type: 'candlestickBarChart',
						height: 70,
						width: 195,
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
		<?php
			}
		}
        ?>
    }
    </script>