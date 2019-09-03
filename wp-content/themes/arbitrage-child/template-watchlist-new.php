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
// echo "on here";
// echo "<pre>";
// print_r($havemeta);
// echo "</pre>";
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
						
						<?php //get_template_part('parts/sidebar', 'tasks'); ?>
                    
						<?php 
						get_template_part('parts/sidebar', 'profile'); 
						?>
                        
					</div>
				</div>
			</div>
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="add-post">
                        <!--start content-->
						<div class="row">
							<div class="col-md-12">
								<div class="box-portlet">
									<div class="box-portlet-header">
										<!-- <div class="optbase">
											<ul>
												<li class="watchtab" data-toptab="watchtab">Watchlist</li>
												<li class="addwatchtab" data-toptab="addwatchtab">Add Watchlist</li>
											</ul>
										</div> -->
										<h2 class="watchtitle">Watchlist</h2>
									</div>
									<div class="box-portlet-content">
										<div class="dtabcontent">
											<div class="dclosetab watchtab active">
												
												<div class="dinnerlist">
													<?php if ($havemeta): ?>
														<ul>
															<li class="addwatch">
																<div class="dplusbutton">
																	<div class="dplsicon"><i class="fa fa-plus-circle"></i></div>
																	<div class="dplstext">Add watchlist</div>
																</div>
															</li>
															<?php foreach ($havemeta as $key => $value) { ?>
																<?php
																	// get current price and increase/decrease percentage
																	$curl = curl_init();
                                                                    //curl_setopt($curl, CURLOPT_URL, 'http://phisix-api4.appspot.com/stocks/'.$value['stockname'].'.json');
                                                                    curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE&symbol='.$value['stockname']);
                                                                    curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.25.248.104']);
																	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
																	$dwatchinfo = curl_exec($curl);
																	curl_close($curl);
																	// adding static json list of stocks
																	//$staticstock = '["2GO","8990P","AAA","AB","ABA","ABC","ABG","ABS","ABSP","AC","ACE","ACPA","ACPB1","ACPB2","ACR","AEV","AGI","ALCO","ALCPB","ALHI","ALI","ALL","ANI","ANS","AP","APC","APL","APO","APX","AR","ARA","AT","ATI","ATN","ATNB","AUB","BC","BCB","BCOR","BCP","BDO","BEL","BH","BHI","BKR","BLFI","BLOOM","BMM","BPI","BRN","BSC","CA","CAB","CAT","CDC","CEB","CEI","CEU","CHI","CHIB","CHP","CIC","CIP","CLC","CLI","CNPF","COAL","COL","COSCO","CPG","CPM","CPV","CPVB","CROWN","CSB","CYBR","DAVIN","DD","DDPR","DELM","DFNN","DIZ","DMC","DMCP","DMPA1","DMPA2","DMW","DNA","DNL","DTEL","DWC","EAGLE","ECP","EDC","EEI","EG","EIBA","EIBB","ELI","EMP","EURO","EVER","EW","FAF","FB","FBP","FBP2","FDC","FERRO","FEU","FFI","FGEN","FGENF","FGENG","FIN","FJP","FJPB","FLI","FMETF","FNI","FOOD","FPH","FPHP","FPHPC","FPI","FYN","FYNB","GEO","GERI","GLO","GLOPA","GLOPP","GMA7","GMAP","GPH","GREEN","GSMI","GTCAP","GTPPA","GTPPB","H2O","HDG","HI","HLCM","HOUSE","HVN","I","ICT","IDC","IMI","IMP","IND","ION","IPM","IPO","IRC","IS","ISM","JAS","JFC","JGS","JOH","KEP","KPH","KPHB","LAND","LBC","LC","LCB","LFM","LIHC","LMG","LOTO","LPZ","LR","LRP","LRW","LSC","LTG","M-O","MA","MAB","MAC","MACAY","MAH","MAHB","MARC","MAXS","MB","MBC","MBT","MED","MEG","MER","MFC","MFIN","MG","MGH","MHC","MJC","MJIC","MPI","MRC","MRP","MRSGI","MVC","MWC","MWIDE","MWP","NI","NIKL","NOW","NRCP","NXGEN","OM","OPM","OPMB","ORE","OV","PA","PAL","PAX","PBB","PBC","PCOR","PCP","PERC","PGOLD","PHA","PHC","PHEN","PHES","PHN","PIP","PIZZA","PLC","PMPC","PMT","PNB","PNC","PNX","PNX3A","PNX3B","PNXP","POPI","PORT","PPC","PPG","PRC","PRF2A","PRF2B","PRIM","PRMX","PRO","PSB","PSE","PSEI","PTC","PTT","PX","PXP","RCB","RCI","REG","RFM","RLC","RLT","ROCK","ROX","RRHI","RWM","SBS","SCC","SECB","SEVN","SFI","SFIP","SGI","SGP","SHLPH","SHNG","SLF","SLI","SM","SMC","SMC2A","SMC2B","SMC2C","SMC2D","SMC2E","SMC2F","SMC2G","SMC2H","SMC2I","SMCP1","SMPH","SOC","SPC","SPM","SRDC","SSI","SSP","STI","STN","STR","SUN","SVC","T","TBGI","TECB2","TECH","TEL","TFC","TFHI","TLII","TLJJ","TUGS","UBP","UNI","UPM","URC","V","VITA","VLL","VMC","VUL","VVT","WEB","WIN","WLCON","WPI","X","ZHI"]';
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
																			if ($count == 10) {
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

																
																<li class="watchonlist" class="to-watch-data" data-dstock="<?php echo $value['stockname']; ?>" data-dhisto='<?php echo json_encode($dstockinfo); ?>'>
																	<div class="watchlist--buttons">
																		<div><a href="#" class="removeItem" data-space="<?php echo $value['stockname']; ?>"><i class="fa fa-trash"></i></a></div>
																		<div><a href="#" class="editItem" data-toggle="modal" data-target="#modal<?php echo $value['stockname']; ?>" data-space="<?php echo $value['stockname']; ?>"><i class="fa fa-edit"></i></a></div>
																	</div>
																	
																	<div class="row">
																		<div class="wlttlstockvals">
																			<div class="stocknn"><?php echo $value['stockname']; ?></div>
																			<div class="subnotif" style="display: none;">
																				<?php foreach ($value['delivery_type'] as $dtkey => $dtvalue) {
																					echo ($dtvalue == 'web-notif' ? 'Web Notif' : 'SMS Notif');
																					echo ",";
																				} ?>
																			</div>

																			<div class="dpricechange">
																				<div class="curprice">&#8369;<?php echo $dinstall['data']->last; ?></div>
																				<?php if (strpos($dinstall['data']->changepercentage, '-') !== false): ?>
																					<div class="curchange onred"><?php echo round($dinstall['data']->changepercentage, 2); ?>%</div>

																				<?php elseif (round($dinstall['data']->changepercentage, 2) == 0.00): ?>
																					<div class="curchange" style="color:#FFC107;"><?php echo round($dinstall['data']->changepercentage, 2); ?>%</div>
																					

																				<?php else: ?>
																					<div class="curchange ongreen">+<?php echo round($dinstall['data']->changepercentage, 2); ?>%</div>
																				<?php endif; ?>
																		</div>
																		</div>
																		<div class="col-md-12">
																			 <div class="dchart">
																				<div class="chartjs">
                                                                               <!-- <span class="nocont"><i class="fas fa-kiwi-bird" style="font-size: 25px;"></i><br>Waiting for API</span> -->
																				
                                                                                	<div id="chart_div_<?php echo $value['stockname']; ?>" class="chart">
																					</div>
                                                                                    <div class="minichartt">
                                                                                    <a href="https://arbitrage.ph/chart/<?php echo $value['stockname']; ?>" target="_blank" class="stocklnk"></a>
                                                                                    <div ng-controller="minichartarb<?php echo strtolower($value['stockname']); ?>">
                                                                                        <nvd3 options="options" data="data" class="with-3d-shadow with-transitions"></nvd3>
                                                                                    </div>
                                                                                </div>
																				
                                                                                </div>
																			</div>
																		</div>
																	</div>
																	
                                                                     <!--                       
																	 <div class="dtockname">
																		<div class="stocknn"><?php echo $value['stockname']; ?></div>
																		<div class="subnotif">
																			<?php foreach ($value['delivery_type'] as $dtkey => $dtvalue) {
																				echo ($dtvalue == 'web-notif' ? 'Web Notif' : 'SMS Notif');
																				echo ",";
																			} ?>
																		</div>
																	</div>															
                                                                    <div class="dcontainer">
																		<div class="dchart">
																			<div class="chartjs">
																				<div id="chart_div_<?php //echo $value['stockname']; ?>" class="chart">
																				 </div>
																			</div>
																		</div>
																		<div class="dpricechange">
																			<?php //if (strpos($dinstall['stock'][0]->percent_change, '-') !== false): ?>
																				<div class="curchange onred"><?php //echo $dinstall['stock'][0]->percent_change; ?>%</div>
																			<?php// else: ?>
																				<div class="curchange ongreen">+<?php //echo $dinstall['stock'][0]->percent_change; ?>%</div>
																			<?php// endif; ?>
																			<div class="curprice">&#8369;<?php //echo $dinstall['stock'][0]->price->amount; ?></div>
																		</div>
																		<br style="clear:both;">
																	</div> -->



																	<div class="dparams">
																		<ul>
																			<?php if (isset($value['dcondition_entry_price'])): ?>
																				<li>
																					<div class="dcondition">Entry Price</div>
																					<div class="dvalue">
																						<span class="ontoleft"><?php echo $value['dconnumber_entry_price']; ?></span>
																						<span class="ontoright">Php</span>
																					</div>
																				</li>
																			<?php endif ?>
																			<?php if (isset($value['dcondition_take_profit_point'])): ?>
																				<li>
																					<div class="dcondition">Take Profit</div>
																					<div class="dvalue">
																						<span class="ontoleft"><?php echo $value['dconnumber_take_profit_point']; ?></span>
																						<span class="ontoright">Php</span>
																					</div>
																				</li>
																			<?php endif ?>
																			<?php if (isset($value['dcondition_stop_loss_point'])): ?>
																				<li>
																					<div class="dcondition">Stop<br>Loss</div>
																					<div class="dvalue">
																						<span class="ontoleft"><?php echo $value['dconnumber_stop_loss_point']; ?></span>
																						<span class="ontoright">Php</span>
																					</div>
																				</li>
																			<?php endif ?>
																		</ul>
																	</div>
																	<div class="modal fade dmodaleditwatch" id="modal<?php echo $value['stockname']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
																	  <div class="modal-dialog" role="document">
																	    <div class="modal-content mc-background">
																	      <div class="modal-header">
																	        <h5 class="modal-title" id="exampleModalLabel" style="color: #333;"><?php echo $value['stockname']; ?></h5>
																	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	          <span aria-hidden="true">&times;</span>
																	        </button>
																	      </div>
																	      <div class="modal-body edit-stocks-padding">
																	        <div class="">
																				<div class="editme">
																					<form method="post" action="#" id="edit-watchlist-param-<?php echo strtolower($value['stockname']); ?>">
																						<input type="hidden" name="stockname" value="<?php echo $value['stockname']; ?>">
																						<div class="instumentinner">
																							<div class="row">
																								<div class="col-md-12">
																									<div class="innerdeliver innerdeliver-editstock">
																										<ul>
																											<li><input id="webpop" type="checkbox" name="delivery_type[]" value="web-notif" <?php echo (in_array("web-notif", $value['delivery_type']) ? 'checked' : ''); ?> checked><label id="webpop" class="label--margin condition-notif">Website Popup</label></li>
																											<li><input id="smspop" type="checkbox" name="delivery_type[]" value="sms-notif" <?php echo (in_array("sms-notif", $value['delivery_type']) ? 'checked' : ''); ?>><label id="smspop" class="label--margin condition-notif">SMS Notification</label></li>
																										</ul>
																									</div>
																								</div>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-6">
                                                                                                        <div class="condition-params">
                                                                                                            <div class="condition-type">
                                                                                                                <!-- <label class="label--margin">Conditions</label> -->
                                                                                                                <select id="condition-list">
                                                                                                                    <option value="">Select Conditions</option>
                                                                                                                    <option style="<?php echo ($value['dcondition_entry_price'] == 'entry_price' ? 'display: none;' : ''); ?>" value="entry_price">Entry Price</option>
                                                                                                                    <option style="<?php echo ($value['dcondition_take_profit_point'] == 'take_profit_point' ? 'display: none;' : ''); ?>" value="take_profit_point">Take Profit Point</option>
                                                                                                                    <option style="<?php echo ($value['dcondition_stop_loss_point'] == 'stop_loss_point' ? 'display: none;' : ''); ?>" value="stop_loss_point">Stop Loss Point</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="condition-freq">
                                                                                                                <!-- <label class="label--margin">Condition Frequency</label> -->
                                                                                                                <input type="number" id="condition_frequency" name="confreq" placeholder="Enter Amount">
                                                                                                            </div>
                                                                                                            <div class="addtolist">
                                                                                                                <button class="add-params arbitrage-button arbitrage-button--primary">Add Parameters</button>
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
                                                                                                                            <button class="closemebutton"><i class="fa fa-minus-circle"></i></button>
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
                                                                                                                            <button class="closemebutton"><i class="fa fa-minus-circle"></i></button>
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
                                                                                                                            <button class="closemebutton"><i class="fa fa-minus-circle"></i></button>
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
                                                                                                            <button class="editmenow arbitrage-button arbitrage-button--primary" data-tochange="edit-watchlist-param-<?php echo strtolower($value['stockname']); ?>">Change</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
																							</div>
																						</div>
																					</form>
																				</div>
																			</div>
																	      </div>
																	      <!-- <div class="modal-footer">
																	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																	        <button type="button" class="btn btn-primary">Save changes</button>
																	      </div> -->
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
											<div class="dclosetab addwatchtab " style="width: 275px;">
												<form method="post" action="" id="add-watchlist-param">
													<div class="instumentinner">
														<div class="">

														<div class="groupinput midd"><label>Stock Code</label>
															<input type="text" name="" id="myDropdown" placeholder="Search.." style="margin-left: -3px; text-align: left;" >
															<div class="dropdown-content ddropbase" style="display: none;">
																		<input type="hidden" id="dstockname" name="stockname">
																		<!--<input type="text" placeholder="Search.." id="myInput">-->
																		<div class="listofstocks"></div>
																	</div>
														</div>
														<hr>
														<div class="groupinput midd"><label>Entry Price</label>
															<input type="number" name="dconnumber_entry_price" class="inpt_data_price number" placeholder="Enter Amount">
														</div>
														<div class="groupinput midd"><label>Take Profit</label>
															<input type="number" name="dconnumber_take_profit_point" class="inpt_data_price number" placeholder="Enter Amount">
														</div>
														<div class="groupinput midd"><label>Stop Loss</label>
															<input type="number" name="dconnumber_stop_loss_point" class="inpt_data_price number" placeholder="Enter Amount">
														</div>
														<div class="">
																<div class="innerdeliver innerdeliver-addstock">
																	<ul>
																		<li><input type="checkbox" name="delivery_type[]" value="web-notif" checked disabled><label class="condition-notif">Website Popup</label></li>
																		<li><input type="checkbox" name="delivery_type[]" value="sms-notif"><label class="condition-notif">SMS Notification</label></li>
																	</ul>
																</div>
														</div>

															<!--<div class="dselectstockname">
																<div class="dropdown ddropconts">
																	<button id="myDropdown" class="dropbtn arbitrage-button arbitrage-button--primary">Select a Stock</button>
																	<div class="dropdown-content ddropbase" style="display: none;">
																		<input type="hidden" id="dstockname" name="stockname">
																		<input type="text" placeholder="Search.." id="myInput">
																		<div class="listofstocks"></div>
																	</div>
																</div>
																<div class="dselected"></div>
															</div>-->
															<!--<div class="">
																<div class="innerdeliver innerdeliver-addstock">
																	<ul>
																		<li><input type="checkbox" name="delivery_type[]" value="web-notif" checked disabled><label class="condition-notif">Website Popup</label></li>
																		<li><input type="checkbox" name="delivery_type[]" value="sms-notif"><label class="condition-notif">SMS Notification</label></li>
																	</ul>
																</div>
															</div>-->
                                                            <div class="row">
                                                                <!--<div class="col-md-6 condition-padding">
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
                                                                            
                                                                            <input type="number" id="condition_frequency" name="confreq" placeholder="Enter Amount">
                                                                        </div>
                                                                        <div class="addtolist">
                                                                            <button class="add-params arbitrage-button arbitrage-button--primary">Add Parameters</button>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                                                                <div class="col-md-6">
                                                                    <!--<div class="dpaste">
                                                                        <ul class="listofinfo"></ul>
                                                                    </div>-->
                                                                    <div class="submitform" style="margin-right: -113px;">
                                                                        <input type="hidden" name="toadddate" value="<?php echo date('m/d/Y h:i:s a', time()); ?>">
                                                                        <input type="hidden" name="isticked" value="<?php echo time(); ?>">
                                                                        <button id="canceladd" class="arbitrage-button arbitrage-button--primary" style="margin-right: 2px;">Cancel</button>
                                                                        <button id="submitmenow" class="arbitrage-button arbitrage-button--primary">Submit</button>
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
									<div class="box-portlet-footer"></div>
								</div>
							</div>
						</div>
                        <!--end content-->
					</div>
				</div>
			</div>
			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">

					<?php //get_template_part('parts/sidebar', 'trendingstocks'); ?>

                    <?php get_template_part('parts/sidebar', 'viewedstocks'); ?>
					
                    <?php get_template_part('parts/sidebar', 'latestnews'); ?>
                    
                    <?php //get_template_part('parts/sidebar', 'traders'); ?>
                    
                    <?php //get_template_part('parts/sidebar', 'watchlist'); ?>

                    <?php get_template_part('parts/sidebar', 'alert'); ?>
					
					<?php get_template_part('parts/sidebar', 'footer'); ?>

				</div>
			</div>

			<br class="clear">
		</div>
	</div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.3/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.6/nv.d3.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.9/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-nvd3/1.0.9/angular-nvd3.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.6/nv.d3.css">
<script>
    if (typeof angular !== 'undefined') {
		var app = angular.module('arbitrage_wl', ['nvd3']);
		<?php
        
        

		if ($havemeta) {
		foreach ($havemeta as $key => $value) {    
            // get stcok history
			#$curl = curl_init();
			#curl_setopt($curl, CURLOPT_URL, 'https://chart.pse.tools/api/history2?symbol='.$value['stockname'].'&firstDataRequest=true&from='.working_days_ago('20') );
			#curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			#$dhistofronold = curl_exec($curl);
            #curl_close($curl); 

            $charthistory = 'https://data-api.arbitrage.ph/api/v1/charts/history?symbol=' . $value['stockname'] . '&exchange=PSE&resolution=1D&from='. date('Y-m-d', strtotime("-20 days")) .'&to=' . date('Y-m-d');
            //echo "CHART HISTORY :::::: " . $charthistory . "<br/>";
            $chartintraday = 'https://data-api.arbitrage.ph/api/v1/charts/history/intraday?symbol=' . $value['stockname'] . '&exchange=PSE';
            //echo "CHART INTRA DAY :::::: " . $chartintraday;


            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/charts/history?symbol=' . $value['stockname'] . '&exchange=PSE&resolution=1D&from='. date('Y-m-d', strtotime("-20 days")) .'&to=' . date('Y-m-d'));
            curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.25.248.104']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $dhistofronold = curl_exec($curl);
            curl_close($curl);

			$dhistoforchart = json_decode($dhistofronold);
            $dhistoforchart = $dhistoforchart->data;

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
				curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/charts/history/intraday?symbol=' . $value['stockname'] . '&exchange=PSE' );
                curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.25.248.104']);
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
	<style>
  .nvd3 .nv-axis line {
    display: none;
  }

  .nvd3 .nv-axis path.domain {
    display: none;
  }

  .negative > line, .negative > rect {
    stroke: #eb4d5c !important;
    fill: #eb4d5c !important;
  }

  .positive > line {
    stroke: #53b987 !important;
  }
  .positive > rect {
    stroke: #53b987 !important;
    fill: #53b987 !important;
  }


.dtabspart ul li {
    color: #000;
}
.dtabspart ul.tabbutton > li {
    display: inline-block;
    line-height: 1em;
}
.dtabspart ul.tabbutton > li:hover {
    border-bottom: 2px solid #263646;
}
.dtabspart ul.tabbutton {
    margin: 0;
}
.totab {
    color: #000 !important;
}
.totab > div {
    display: none;
}
#dwatchlistmodal {
    color: #000;
}
.submitform {
    text-align: right;
    margin-top: 0;
    float: right;
}
.dclosetab {
    display: none;
}
.dclosetab.active {
    display: block;
    box-shadow: -4px 4px 8px -2px rgba(4,13,23,0.7);
    background: linear-gradient(45deg, #0a1c31 0%,#1a3550 100%) !important;
    margin: 0;
}
.side-header .right-image .onto-user-name {
    margin-bottom: 0 !important;
}
.addwatchs {
    display: block;
    /* border: 1px solid #2c3e50; */
    padding: 10px 15px;
    /* float: left; */
    width: 100% !important;
    margin-right: 1%;
    border-radius: 5px;
    position: relative;
    min-height: 113px !important;
    margin-bottom: 15px;
    box-shadow: -4px 4px 8px -2px rgba(4,13,23,0.7);
    background: linear-gradient(45deg, #0a1c31 0%,#1a3550 75%) !important;
}
.stats-watch {
    font-size: 13px;
    font-weight: bold;
    color: #fffffe;
}
.box-portlet {
    overflow: visible;
}
.left-stats-watch {
    float: left;
    font-size: 12px;
    font-family: Roboto, sans-serif;
    font-weight: 400;
    line-height: 1.7;
    left: 1px;
    position: relative;
    color: #fffffe;
}
.right-stats-watch {
    float: right;
    text-align: right;
    font-size: 13px;
    font-family: Roboto, sans-serif;
    line-height: 1.7;
    right: 1px;
    position: relative;
}
.dinnerlist > ul > li {
    display: block;
    border: 1px solid #2c3e50;
    padding: 10px;
    float: left;
    width: 49%;
    margin-right: 1%;
    border-radius: 5px;
    position: relative;
    min-height: 185px;
    margin-bottom: 25px;
}
.dinnerlist > ul > li.addwatch {
    text-align: center;
}
.dplusbutton .dplsicon {
    font-size: 68px;
    line-height: 1em;
}
.dplusbutton .dplstext {
    font-size: 20px;
    text-transform: capitalize;
}

.dinnerlist > ul > li.addwatch:hover {
    background: #2c3e50;
    cursor: pointer;
}
.dinnerlist > ul > li.addwatch:hover .dplsicon,
.dinnerlist > ul > li.addwatch:hover .dplstext {
    color: #3b5269;
}
.dinnerlist .dtockname {
    /*display: inline-block;
    width: 40%;*/
    font-size: 13px;
    margin-bottom: 10px;
    text-align: right;
    margin-top: 20px;
}
.dinnerlist .dtype {
    /*display: inline-block;
    width: 40%;*/
    font-size: 13px;
}
.dinnerlist .deleteme > div {
    display: inline-block;
}
.dinnerlist .dparams {
    display: block;
    margin-top: 5px;
}
.dinnerlist .dparams ul li {
    display: inline-block;
}
.dinnerlist .dparams ul li > div {
    display: inline-block;
}
.dinnerlist .dparams ul li {
    display: inline-block;
    padding: 0;
    width: 32%;
    font-size: 11px;
    line-height: 1em;
    margin-bottom: 5px;
    text-align: center;
    position: relative;
    box-shadow: 0px 0px 6px -3px rgba(4,13,23,0.7);
}
.dinnerlist .dparams ul li > div.dvalue {
    font-size: 19px;
    line-height: 1em;
    text-align: right;
    width: 100%;
    font-weight: bold;
    padding: 5px;
    border: 1px solid #fff;
}
.dinnerlist .dparams ul li > div.dcondition {
    background: #173250ad;
    display: block;
    color: #fffffe;
    font-size: 10px;
    padding: 4px;
    text-align: left;
    text-transform: uppercase;
    line-height: 1em;
    text-align: center;
    border-radius: 5px 5px 0px 0px;
}
.dinnerlist .deleteme {
    text-align: right;
    position: absolute;
    top: -15px;
    right: -5px;
}
.dinnerlist .deleteme a {
    background: #2c3e50;
    color: #fff;
    font-size: 13px;
    padding: 6px 10px;
    border: 1px solid #2c3e50;
    border-radius: 30px;
}
.dinnerlist .deleteme a:hover {
    text-decoration: none;
}
.dinnerlist .deleteme a.removeItem {
    padding: 6px 10px;
}
.dinnerlist .deleteme a.editItem {
    padding: 6px 8px;
}
.condition-params {
    border-right: none;
    margin-right: -15px;
}
/* #canceladd {
    padding: 0 18px !important;
} */
#main-header {
    z-index: 1;
}
.editpartme {
    display: none;
}

/* Dropdown Button */
/* .dropbtn {
    display: inline-block;
    background-color: #11273e;
    border-radius: 25px;
    border-radius: 26px !important;
    border: 1px solid #6583a8 !important;
    padding: 6px 17px !important;
    font-family: 'Nunito', sans-serif;
    color: #6583a8;
    background: none !important;
} */

/* Dropdown button on hover & focus */
.dropbtn:hover, .dropbtn:focus {
 /* background-color: #3b5269;*/
  /*color: #2c3e50;*/
}

/* The search field */
#myInput {
  border-box: box-sizing;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}

/* The search field when it gets focus/clicked on */
#myInput:focus {outline: none;}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
    background: #142c46;
    border: 1px solid #1e3554;
    min-width: 230px;
    z-index: 1;
    border-radius: 8px;
    overflow: hidden;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  font-size: 13px;
  padding: 5px 15px;
  border-bottom: 1px solid #dddddd;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {    
    background-color: #18314c;
}
.dropdown-content .listofstocks {
    height: 120px;
    overflow-y: auto;
}
input#myInput {
    padding: 10px 10px;
    font-size: 13px;
    display: block;
    width: 100%;
    background: #11273e;
    color: #fff;
    border: none;
}
.dropdown-content .listofstocks a {
    font-size: 13px;
    padding: 5px 10px;
    border-bottom: none;
    color: #d8d8d8;
}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;}

.dbox {
}
.dbox.boxsred .innerbox {
    background: #b93c2c;
}
.dbox.boxsgreen .innerbox {
    background: #52c27a;
}
.dbox .innerbox {
    border-radius: 50px;
    display: inline-block;
    padding: 5px 10px;
}
.dbox .innerbox .hidedis {
  display: none;
}
.dgencode {
    text-align: center;
    width: 90%;
    margin: 0 auto;
}
a#gencode {
    font-size: 16px;
    text-transform: uppercase;
    color: #fff;
    font-weight: lighter;
    background: #2b3e4f;
    padding: 10px 15px;
    display: inline-block;
    border-radius: 5px;
    margin-bottom: 15px;
}
a#gencode:hover {
  text-decoration: none;
}
.dcodegenerated {
    background: #33465c;
    font-size: 24px;
    margin-bottom: 15px;
    padding: 15px 0;
}
input.subbuttons {
    background: #2b3e4f;
    border: none;
    color: #fff;
    text-transform: uppercase;
    font-weight: lighter;
    padding: 10px 15px;
    margin-top: 15px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

.innerreference {
    text-align: center;
}
.innerreference .notebig {
    font-size: 17px;
    text-transform: uppercase;
    font-weight: lighter;
}
.innerreference h2 {
    background: #2b3e4f;
    width: 50%;
    margin: 10px auto;
    border-radius: 5px;
    line-height: 1em;
    padding: 20px 0;
}
.innerreference .notesmall {
    text-transform: uppercase;
    font-size: 12px;
    font-weight: lighter;
}
.dcontainer .dchart {
    float: left;
    width: 75%;
}
.dcontainer .dpricechange {
    float: left;
    width: 25%;
    text-align: right;
}
.dpricechange .curprice {
    line-height: 1em;
    font-size: 17px;
    padding-bottom: 3px;
    padding-top: 0;
    font-weight: 500 !important;
}
.dpricechange .curchange {
    font-size: 13px;
    line-height: 1em;
}
.dpricechange .curchange.onred {
    color: #eb4d5c;
}
.dcontainer {
    margin-bottom: 10px;
}
.stocknn {
    font-size: 21px;
    font-weight: bold;
    line-height: 1em;
}
.dselectstockname > div {
    display: inline-block;
    margin-right: 10px;
}
.innerdeliver ul li {
    display: inline-block;
    margin-right: 10px;
}
.innerdeliver.innerdeliver-addstock ul li:first-child {
    display: inline-block;
    margin-right: 0;
}
.innerdeliver ul li input[type="checkbox"] {
    margin-right: 5px;
    vertical-align: middle;
}
.condition-params > div {
    margin-bottom: 10px;
}
.condition-params > div select#condition-list {
    color: #fff;
    display: block;
    width: 100%;
    padding: 5px 10px;
    -webkit-appearance: none;
    -moz-appearance: none;
    border-radius: 25px;
    min-height: 33px;
    background: #11273e;
    border: 1px solid #1e3554 !important;
    font-size: 13px;
}
.box-portlet-content [type=button], [type=reset], [type=submit], button:hover {
    background-color: #123;
}
.condition-freq input#condition_frequency {
    color: #fff;
    font-size: 13px;
    background: #11273e;
    border: 1px solid #1e3554 !important;
    padding: 5px 10px;
    width: 100%;
    border-radius: 25px;
    min-height: 33px;
}
.addtolist {
    margin-bottom: 0px !important;
    text-align: right;
    margin-right: 0;
}
.dbaseitem .dinfodata {
    width: 84%;
    float: left;
    font-size: 12px;
    padding: 6px 5px;
    border: 1px solid #2a405b;
    border-radius: 25px;
    display: inline-flex;
    margin: 1px 0px 0px 3px;
    background: #2a405b;
}
.dbaseitem .closetab {
    width: 12%;
    float: left;
    text-align: center;
    background: none !important;
    margin-top: 0;
}
li.dbaseitem {
    border: 1px solid #0c1e33;
    background: #2b405b;
    border-radius: 5px;
    /* margin-top: 20px; */
    min-height: 36px;
}
button#submitmenow,
button#canceladd {
    color: white;
    cursor: pointer;
    display: inline-block;
    background-color: #11273e;
    padding: 4px 14px !important;
    border-radius: 25px;
}
ul.listofinfo {
    margin: 0;
    padding: 0;
}
button.closemebutton {
    background: #2a405b;
    color: #fff;
    border: 0 none;
    font-size: 20px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 0px;
}
li.dbaseitem {
    border: 1px solid #0c1e33;
    background: #2a405b;
    border-radius: 5px;
    /* margin-top: 20px; */
}
h2.watchtitle {
    font-size: 18px;
	padding: 0 10px 4px;
    margin: 0;
    font-weight: 800;
}
.dmodaleditwatch .modal-header h5 {
    color: #fff !important;
    margin: 0;
    line-height: 1em;
    /* padding: 0 10px; */
    font-size: 21px;
}
.dmodaleditwatch .modal-header {
    background-color: #34495e;
    padding: 12px;
    border-radius: 4px;
    margin: 13px;
    margin-bottom: 1px !important;
}
.dmodaleditwatch .modal-header button.close {
    padding: 0;
    color: #fff;
    position: absolute;
    top: 39px;
    right: 41px;
    background: none;
}
.dmodaleditwatch .modal-header {
    padding: 10px !important;
    border-bottom: 1px solid #3b5269;
}
.dmodaleditwatch .modal-header {
    padding: 0;
}
.dssinner .dleftpart {
    width: 20%;
    float: left;
}

.dssinner .drightpart {
    width: 80%;
    float: left;
}

.drefmeninner .leftpart {
    width: 20%;
    float: left;
}
.drefmeninner .rightpart {
    width: 80%;
    float: left;
}
.dsidemenu ul li a {
    color: #fff;
}
.ditem.fullwid {
    width: 100%;
    float: left;
}
.ditem.halfwid {
    width: 50%;
    float: left;
}
.dbillitem > div {
    display: inline-block;
    width: 30%;
}
.listofcoms li > div {
    display: inline-block;
    width: 30%;
}
.dlistinner ul li > div {
    display: inline-block;
    width: 30%;
}
.dlistinner.dmemberblock ul li > div {
    display: inline-block;
    width: 49%;
}
.dlistinner.dmentorblock ul li > div {
    display: inline-block;
    width: 24%;
}
.dadminusermods {
    margin-top: 10%;
}
.dadminusermods h5#exampleModalLongTitle {
    color: #333;
    font-size: 16px;
    margin: 0;
    padding: 0;
    line-height: 1em;
}
.dadminusermods button.close {
    padding: 10px;
    line-height: 1em;
    font-size: 20px;
}
.dadminusermods .modal-header {
    padding: 10px 15px;
}
.innermods {
    color: #333;
}
.dseparator h3 {
    font-size: 16px;
    text-transform: uppercase;
    padding: 2px;
    margin-bottom: 2px;
    line-height: 1em;
    border-bottom: 1px solid #333;
    font-weight: bold;
}
.dprofdatainner {
    margin-bottom: 10px;
}
.dprofpicinner {
    /*border-radius: 150px;
    overflow: hidden;
    border: 5px solid #333;*/
    position: relative;
}
.dprofpicinner img {
    border-radius: 150px;
    border: 5px solid #d3d3d3;
}
.dadminusermods .modal-body {
    padding: 15px 0;
}
.ditem {
    border: 1px solid #fff;
    margin: 5px 0;
}
.dmentorfollowmodalb h5#exampleModalLongTitle {
    color: #333;
    font-size: 16px;
    padding: 0;
    line-height: 1em;
}
.dmentorfollowmodalb .modal-header {
    padding: 10px;
    text-align: right;
    display: block;
    line-height: 1em;
}
.dmentorfollowmodalb button.close {
    font-size: 16px;
    padding: 0;
    margin: 0;
    float: none;
}
.dmentorfollowmodalb .modal-body {
    color: #333;
}
.dlistinner.dmentorblock .dmentorfollowmodalb ul li > div {
    width: 30%;
}
.tradelogtable .dreditem {
    color: #e64b3c;
    font-weight: bold;
}
.tradelogtable .dgreenitem {
    color: #27ae60;
    font-weight: bold;
}
.lisrofactivity table {
    width: 100%;
}
.dstockdetails .ditmleft,
.dstockdetails .ditmright {
    display: inline-block;
    width: 45%;
}
.ddetails {
    margin-bottom: 30px;
}

.innerdeliver.innerdeliver-addstock {
    padding: 7px 5px 7px 0;
    text-align: left;
    margin-top: 0;
}
.innerdeliver.innerdeliver-editstock {
    padding: 5px 0px 5px 0;
    text-align: left;
}

    /* Enter Trade Form */
    .groupinput label {
        display: inline-block;
        width: 46px;
        font-weight: 300;
        font-size: 13px;
        height: 27px;
        line-height: 27px;
        padding: 0 0 0 7px;
        background-color: #34495e;
        border: none;
        color: #ecf0f1;
        border-radius: 3px 0 0 3px;
        margin-bottom: 0;
    }
    .groupinput input[type="text"] {
        display: inline-block;
        border-radius: 0 3px 3px 0;
        width: 172px;
        font-weight: 300;
        font-size: 13px;
        height: 27px;
        line-height: 27px;
        padding: 0 0 0 7px;
        background-color: #4e6a85;
        border: 1px solid #4e6a85;
        color: #ecf0f1;
        font-family: 'Roboto', sans-serif;
        font-size: 13px;
        font-weight: 300;
    }
    .groupinput select {
        display: inline-block;
        border-radius: 0 3px 3px 0;
        width: 140px;
        font-weight: 300;
        font-size: 13px;
        height: 27px;
        line-height: 27px;
        padding: 0 0 0 3px;
        background-color: #4e6a85;
        margin: 0 0 0 -4px;
        border: 1px solid #4e6a85;
        color: #ecf0f1;
        font-family: 'Roboto', sans-serif;
        font-size: 13px;
        font-weight: 300;
    }
    .confirmtrd,
    input[type="submit"].confirmtrd {
        background-color: #3597d3;
        border: 0;
        line-height: 34px;
        height: 34px;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 12px;
        padding: 0 22px;
        border-radius: 25px;
        color: #fff;
        cursor: pointer;
        font-family: 'Roboto', sans-serif;
        display:inline-block;
    }
    .confirmtrd:hover,
    input[type="submit"].confirmtrd:hover {
        background-color: #1870a6;
        color: #fff;
        text-decoration:none;
    }
    .confirmtrd.green {
        background-color: #27ae60 !important;
    }
    .confirmtrd.green:hover {
        background-color: #167b41 !important;
    }
    .confirmtrd.red {
        background-color: #e64c3c !important;
    }
    .confirmtrd.red:hover {
        background-color: #bb3527 !important;
    }
    .groupinput {
        margin-bottom: 10px;
    }
    textarea.darktheme {
        background-color: #4e6a85;
        border: 1px solid #4e6a85;
        height: 115px;
        max-width: 448px;
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        font-family: 'Roboto', sans-serif;
        font-size: 13px;
        font-weight: 300;
        color: #ecf0f1;
        margin-top: 10px;
    }
    .entr_col {
        width:33%;
        float:left;
    }
    .entr_clear {clear:both;}
    .selltrade,
    .entertrade {
        width: 720px;
        margin: auto;
    }
    .groupinput.midd label {
        width:80px;
    }
    .groupinput.midd select {
        width:157px;
    }
    .groupinput.midd input {
        width:138px;
    }
    .entr_wrapper_top {
        padding:20px 0 15px 20px;
        background-color:#0c1f33;
    }
    .entr_wrapper_mid {
        padding: 20px 0 15px 20px;
        background-color: #142b46;
        border-radius: 4px;
    }
    .entr_wrapper_bot {
        padding:25px 0 25px 25px;
        background-color:#2c3e50;
    }
    .rnd {border-radius:3px !important;}
    .selectonly select {
        width:219px;
        margin:0;
    }
    .entr_ttle_bar {
        background-color: #142b46;
        padding: 12px;
        border-radius: 4px;
    }
    .entr_ttle_bar img {
        width: 22px;
        vertical-align: middle;
        margin: 0 7px 0 0;
    }
    .entr_ttle_bar strong {
        font-size: 14px;
        text-transform: uppercase;
        display: inline-block;
        font-weight:700 !important;
        vertical-align: middle;
    }
    .entr_successmsg {
        border-radius: 3px;
        background-color: #27ae60;
        color: #fff;
        padding: 4px 7px;
        width: 100%;
        margin: 0 auto;
        margin-bottom: 10px;
    }
    span.selldot {
        display: inline-block;
        background-color: #e84c3c;
        width: 10px;
        height: 10px;
        border-radius: 10px;
        vertical-align: middle;
        margin: -1px 0 0px 5px;
    }
    span.buydot {
        display: inline-block;
        background-color: #27ae60;
        width: 10px;
        height: 10px;
        border-radius: 10px;
        vertical-align: middle;
        margin: -1px 0 0px 5px;
    }
    span.datestamp_header {
        color: #a1adb5;
        display: inline-block;
        vertical-align: middle;
        margin: 0 0 0px 10px;
    }
    .fctnlhdn {
        visibility:hidden;
        opacity:0;
        position:absolute;
        z-index:-1;
    }

    /* Popup Overrides */
    div#fancybox-content {
        border-color: #2c3e50 !important;
        background: #2c3e50 !important;
    }
    #fancybox-outer {
        background: #2c3e50 !important;
        box-shadow: none !important;
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        border-radius: 6px;
        overflow: hidden;
    }
    #fancybox-close {top: 18px;right: 18px;}
    .lockedd {position:relative;}
    .lockedd i.fa.fa-lock {
        top: 7px;
        position: absolute;
        right: 21px;
        font-size: 14px;
    }

    /* Table CSS */
    .tradelogtable {
        width:100%;
        margin-bottom:0;
    }
    .tradelogtable td {
        padding: 2px;
    }
    textarea.darktheme::-webkit-input-placeholder { /* Chrome/Opera/Safari */
        color: #ecf0f1;
    }
    textarea.darktheme::-moz-placeholder { /* Firefox 19+ */
        color: #ecf0f1;
    }
    textarea.darktheme:-ms-input-placeholder { /* IE 10+ */
        color: #ecf0f1;
    }
    textarea.darktheme:-moz-placeholder { /* Firefox 18- */
        color: #ecf0f1;
    }
    .tradelogscont {
        background-color:#34495e;
        max-width:1125px;
        width:100%;
        margin:0 auto;
    }
    .tradelogscont .innerr {
        padding:25px 0;
    }
    .side-header .right-image .onto-user-meta-details {
        color: #b2bbc4;
        font-size: 12px;
        font-weight: 400;
    }
    .box-portlet {
        border: none !important;
       /* border-radius: 5px;
        overflow: hidden;
        background-color: #142b46;
        box-shadow: 0px 0px 10px 1px rgba(4,13,23,1);*/
    }
    .side-header {
        border-radius: 5px 5px 0 0;
        border-bottom: none;
    }
    .dpricechange {
		text-align: right;
		padding-bottom: 7px;
		display: block;
		margin-top: -37px;
	}
	.chartjs span.nocont {
		padding: 14px 0;
    	font-size: 13px;
	}
    .subnotif {
		display: block;
		width: 50%;
		font-size: 13px;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
    }
    .dinnerlist .deleteme {
        text-align: right;
        position: absolute;
        top: -15px;
        z-index: 9;
        right: -5px;
        /* background: #132b46; */
        border-radius: 20px;
        padding: 2px 4px;
        background: linear-gradient(46deg, #10263d 0%,#1a3550 100%);
    }
    a.removeItem, a.editItem {
        padding: 0 !important;
        height: 26px;
        line-height: 25px;
        display: block;
        width: 22px;
        text-align: center;
        font-size: 16px !important;
        background: none !important;
        border: none !important;
        font-weight: 400 !important;
    }
    .oncommonsidebar .post-content {
        padding: 0px 0px;
    }
    .box-portlet-content {
        padding: 0px !important;


    }


.dinnerlist > ul > li {
        display: block;
        border: none;
        padding: 12px 18px 9px 18px;
        float: left;
        width: 46%;
        margin-right: 0%;
        border-radius: 5px;
        position: relative;
        min-height: 214px;
        background: #142c46;
        background: -moz-linear-gradient(45deg, #0a1c31 0%, #1a3550 100%);
        background: -webkit-linear-gradient(45deg, #0a1c31 0%,#1a3550 100%);
        background: linear-gradient(45deg, #0a1c31 0%,#1a3550 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0a1c31', endColorstr='#1a3550',GradientType=1 );
        box-shadow: -4px 4px 8px -2px rgba(4,13,23,0.7);
        border-radius: 5px;
        margin: 10px;
    }
    .dinnerlist .dtockname {
        margin-top: 0 !important;
    }
    .dpricechange .curchange, .dpricechange .curprice {
		font-weight: normal !important;
    }
    .dplusbutton {
        padding: 50px 0px 0px 0px;
    }
    .dinnerlist .dparams ul li {
        width: 31.6%;
	}
	.box-portlet-header, .box-portlet-footer {
		background: none;
    	padding: 0;
	}
    span.curchange {
        font-size: 15px;
        font-weight: normal;
        display: inline-block;
        margin: 0 7px 0 0;
    }
    .onred {color: #ea4d5c !important;}
    .ongreen {color: #53b987 !important;}
    .dinnerlist .dparams ul li > div.dvalue {
        font-size: 13px;
        width: 100%;
        font-weight: bold;
        padding: 5px;
        border: 1px solid #132b46;
        text-align: center;
        border-radius: 0px 0px 5px 5px;
	}
	.dvalue span.ontoleft, .dvalue span.ontoright {
		color: #ecf0f1;
		font-family: 'Roboto', sans-serif;
		font-size: 13px;
		font-weight: 300;
	}
    span.curprice {
        display: inline-block;
        margin: 0 3px 0 8px;
        font-size: 15px;
        font-weight: normal;
    }
    .curprice, .stocknn, .curchange {
        vertical-align: middle;
        line-height: 22px;
    }
    .stocknn {
        font-size: 20px;
        font-weight: bold;
        line-height: 1em;
        display: inline-block;
        padding: 0;
    }
    .wlttlstockvals {
		display: block;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    #page-container {
        background: #0c1e33;
    }

    .box-portlet-header {
        background: transparent;
        /*border-bottom: 1px solid #1e3554;*/
       padding: 10px 0px 0;
    }

    .inner-placeholder {
        background: #0d1f33;
        color: #d8d8d8;
        padding-top: 0%;
    }

    .et_non_fixed_nav.et_transparent_nav.et_show_nav #page-container, .et_fixed_nav.et_show_nav #page-container {
        padding-top: 45px;
    }

    .two a {
        border-radius: 4px;
    }

    .dinnerlist .dparams {
        display: block;
        margin-top: 10px;
        text-align: center;
    }

    .dinnerlist > ul > li.addwatch:hover .dplsicon, .dinnerlist > ul > li.addwatch:hover .dplstext {
        color: #ecf0f1;
    }

    .dinnerlist > ul > li.addwatch:hover {
        background: #2B405B;
        cursor: pointer;
    }

    .center-dashboard-part {
        float: left;
        width: 55% !important;
        margin-top: -10px;
    }

    .trading-name {
        font-family: 'Nunito', sans-serif;
        color: #999999;
        font-size: 13px;
        padding-left: 10px;
    }

    .dfreq {
        font-size: 12px;
        margin-left: 15px;
    }

    .editmenow {
        /* color: white;
        cursor: pointer;
        display: inline-block;
        border-radius: 25px;
        border-radius: 26px !important;
        border: 1.3px solid #6583a8 !important;
        padding: 0 17px !important;
        font-family: 'Nunito', sans-serif;
        color: #6583a8;
        background: none !important;
        line-height: 2; */
        margin: 5px 0 15px 0;
        cursor: pointer;
    }
    .eventnone {
        cursor: pointer;
    }
    button#submitmenow, button#canceladd {
        padding: 4px 9px !important;
    }
    /* button#submitmenow, button#canceladd {
        color: white;
        cursor: pointer;
        display: inline-block;
        border-radius: 25px;
        border-radius: 26px !important;
        border: 1.3px solid #6583a8 !important;
        padding: 0 17px !important;
        font-family: 'Nunito', sans-serif;
        color: #6583a8;
        background: none !important;
        line-height: 2;
    } */
    /* .addtolist button.add-params {
        color: white;
        cursor: pointer;
        display: inline-block;
        border-radius: 25px;
        border-radius: 26px !important;
        border: 1.3px solid #6583a8 !important;
        padding: 0 17px !important;
        font-family: 'Nunito', sans-serif;
        color: #6583a8;
        background: none !important;
        line-height: 2;
    } */
    .dropbtn:hover, .dropbtn:focus {
        /*color: white;
        cursor: pointer;
        display: inline-block;
        border-radius: 25px;
        border-radius: 26px !important;
        border: 1.3px solid #6583a8 !important;
        padding: 0 17px !important;
        font-family: 'Nunito', sans-serif;
        color: #6583a8;
        background: none !important;
        line-height: 2;*/
    }
    .addwatchtab {
        background-color: #142c46;
        padding: 16px 9px 16px 18px;
        margin-top: 11px;
        border-radius: 5px;
    }
    #main-header {
        z-index: 10 !important;
    }
    .top-stocks {
        box-shadow: -4px 4px 8px -2px rgba(4,13,23,0.7);
        background: linear-gradient(45deg, #0a1c31 0%,#1a3550 100%) !important;
        padding-bottom: 9px;
    }
    .to-content-part {
        background: none !important;
    }
    button.close span {
        font-size: 25px;
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
        font-weight: 400;
	}
	
.swal2-popup.swal2-modal {
	background-color: #142b46;
	border-radius: 15px;
	width: 500px;
}
.swal2-text, .swal2-title {
	color: #fff !important;
}
.swal2-button--confirm {
	font-family: 'Roboto', sans-serif;
    font-size: 16px;
    color: #ffffff;
    background: none;
    border: 2px #00bcd4 solid;
    height: auto;
    border-radius: 25px;
    padding: 3px 9px;
}
.swal2-popup .swal2-content {
    color: #fff;
    font-size: 16px;
}
.swal2-popup .swal2-styled.swal2-cancel {
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    color: #ffffff;
    background: none !important;
    border: 2px #9E9E9E solid !important;
    height: auto;
    border-radius: 25px;
    padding: 3px 9px;
}
.swal2-popup .swal2-styled:focus {
	outline: 0;
    box-shadow: none;
}
.swal2-popup .swal2-styled.swal2-confirm {
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    color: #ffffff;
    background: none !important;
    border: 2px #00bcd4 solid !important;
    height: auto;
    border-radius: 25px;
    padding: 3px 12px;
}
.swal2-popup .swal2-styled.swal2-confirm:hover {
    background: #00bcd4 !important;
    border-color: #00bcd4 !important;
}
.swal2-popup .swal2-styled.swal2-cancel:hover {
    background: #dd3333 !important;
    border-color: #dd3333 !important;
}
.swal2-popup .swal2-actions {
	margin: 1.25em 0 0 auto;
}
.latest-news {
	margin-top: 15px;
    background: linear-gradient(45deg, #0a1c31 0%,#1a3550 100%) !important;
    box-shadow: -4px 4px 8px -2px rgba(4,13,23,0.7);
}
.watchlist--buttons {
    display: flex;
}
.watchlist--buttons a {
    color: white;
}
</style>
<?php get_footer('dashboard'); ?>