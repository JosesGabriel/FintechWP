
<?php 
include_once "watchlist/header-files.php";
require("parts/global-header.php");
?>


<?php

global $wpdb, $current_user;
$userID = $current_user->ID;

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

        wp_redirect( '/watchlist' );
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
            add_user_meta($userID, '_watchlist_instrumental', $newarray);
            //update_user_meta($userID, '_watchlist_instrumental', $newarray);
        }

        wp_redirect( '/watchlist' );
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
    wp_redirect( '/watchlist' );
}

if(isset($_GET['addcp'])){
    $cpnum = $_GET['addcp'];
    add_user_meta( $userID, 'cpnum', $cpnum, true);
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


<!-- #main-header -->
<div id="main-content" class="oncommonsidebar">

    <div class="inner-placeholder">
        <div class="inner-main-content">
            <div class="left-dashboard-part">
                <div class="dashboard-sidebar-left">
                    <div class="dashboard-sidebar-left-inner">
                        <?php include_once "parts/sidebar-profile.php";?>
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
                                                                    <div class="dplstext">Add watchlist</div>
                                                                    <div class="dplsicon" style="margin: 5px 70px;"><i class="fa fa-plus-circle"></i></div>
                                                                </div>
                                                            </li>
                                                            <?php foreach ($havemeta as $key => $value) { ?>
                                                                <?php
                                                                    // get current price and increase/decrease percentage
                                                                    $curl = curl_init();
                                                                    //curl_setopt($curl, CURLOPT_URL, 'http://phisix-api4.appspot.com/stocks/'.$value['stockname'].'.json');
                                                                    curl_setopt($curl, CURLOPT_URL, '/wp-json/data-api/v1/stocks/history/latest?exchange=PSE&symbol='.$value['stockname']);

                                                                    //

                                                                    
                                                                    curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);

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

                                                                         curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);

                                                                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                                                        $dwatchhisto = curl_exec($curl);
                                                                        curl_close($curl);

                                                                        $ddata = json_decode($dwatchhisto);
                                                                        
                                                                        if (!is_array($ddata)) continue;

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
                                                                    if (is_object($dinstall['data'])):
                                                                ?>

                                                                <li class="watchonlist" class="to-watch-data" data-dstock="<?php echo $value['stockname']; ?>" data-dhisto='<?php echo json_encode($dstockinfo); ?>'>
                                                                    <!--<div class="watchlist--buttons">
                                                                        <div><a href="#" class="removeItem" data-space="<?php echo $value['stockname']; ?>"><i class="fa fa-trash"></i></a></div>-->
                                                                        <div style="display: none;"><a href="#" class="editItem" id="edit_<?php echo $value['stockname']; ?>" data-toggle="modal" data-target="#modal<?php echo $value['stockname']; ?>" data-space="<?php echo $value['stockname']; ?>"><i class="fa fa-edit"></i></a></div>
                                                                    <!--</div>-->
                                                                    
                                                                    <div class="row">
                                                                        <div class="wlttlstockvals">
                                                                            <div class="stocknn"><?php echo $value['stockname']; ?></div>
                                                                            <div class="s_dropdown" style="display: inline-block;"> 
                                                                                <select class="editwatchlist" name="editstock" id="" data-space="<?php echo $value['stockname']; ?>">
                                                                                        <option  value="select" hidden></option>
                                                                                        <option  value="delete">Delete</option>
                                                                                        <option  value="edit">Edit</option>
                                                                                </select>

                                                                            </div>
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
                                                                                    <a href="/chart/<?php echo $value['stockname']; ?>" target="_blank" class="stocklnk"></a>
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
                                                                            <?php if (isset($value['dcondition_entry_price']) && $value['dconnumber_entry_price'] > 0 ): ?>
                                                                                <li>
                                                                                    <div class="dcondition">Entry Price</div>
                                                                                    <div class="dvalue">
                                                                                        <span class="ontoleft"><?php echo $value['dconnumber_entry_price']; ?>
                                                                                        
                                                                                        </span>
                                                                                        <!--<span class="ontoright">Php</span>-->
                                                                                    </div>
                                                                                </li>
                                                                            <?php endif ?>
                                                                            <?php if (isset($value['dcondition_take_profit_point']) && $value['dconnumber_take_profit_point'] > 0 ): ?>
                                                                                <li>
                                                                                    <div class="dcondition">Take Profit</div>
                                                                                    <div class="dvalue">
                                                                                        <span class="ontoleft"><?php echo $value['dconnumber_take_profit_point']; ?>
                                                                                        
                                                                                        </span>
                                                                                        <!--<span class="ontoright">Php</span>-->
                                                                                    </div>
                                                                                </li>
                                                                            <?php endif ?>
                                                                            <?php if (isset($value['dcondition_stop_loss_point']) && $value['dconnumber_stop_loss_point'] > 0 ): ?>
                                                                                <li>
                                                                                    <div class="dcondition">Stop<br>Loss</div>
                                                                                    <div class="dvalue">
                                                                                        <span class="ontoleft"><?php echo $value['dconnumber_stop_loss_point']; ?>
                                                                                        
                                                                                        </span>
                                                                                        <!--<span class="ontoright">Php</span>-->
                                                                                    </div>
                                                                                </li>
                                                                            <?php endif ?>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="modal fade dmodaleditwatch" id="modal<?php echo $value['stockname']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                      <div class="modal-dialog" role="document">
                                                                        <div class="modal-content mc-background" style="width: 60%; height: 265px;">
                                                                          <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel" style="color: #333;"><?php echo $value['stockname']; ?></h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                              <span class="closemodal" aria-hidden="true">&times;</span>
                                                                            </button>
                                                                          </div>
                                                                          <div class="modal-body edit-stocks-padding">
                                                                            <div class="">
                                                                                <div class="editme">
                                                                                    <form method="post" action="#" id="edit-watchlist-param-<?php echo strtolower($value['stockname']); ?>">
                                                                                        <input type="hidden" name="stockname" value="<?php echo $value['stockname']; ?>">
                                                                                        <div class="instumentinner">
                                                                                            <div class="row">

                                                                                                <div class="cond-ion" style="margin: 15px 0px 0px 26px;">                           
                                                                                                    <div class="groupinput midd"><label>Entry Price</label>
                                                                                                        <input type="text" name="dconnumber_entry_price" class="inpt_data_price number" value="<?php echo $value['dconnumber_entry_price']; ?>" >
                                                                                                        <input type="hidden" id="dparamcondition" name="dcondition_entry_price" value="entry_price">
                                                                                                    </div>
                                                                                                    <div class="groupinput midd"><label>Take Profit</label>
                                                                                                        <input type="text" name="dconnumber_take_profit_point" class="inpt_data_price number" value="<?php echo $value['dconnumber_take_profit_point']; ?>">
                                                                                                        <input type="hidden" id="dparamcondition" name="dcondition_take_profit_point" value="take_profit_point">
                                                                                                    </div>
                                                                                                    <div class="groupinput midd"><label>Stop Loss</label>
                                                                                                        <input type="text" name="dconnumber_stop_loss_point" class="inpt_data_price number" value="<?php echo $value['dconnumber_stop_loss_point']; ?>">
                                                                                                        <input type="hidden" id="dparamcondition" name="dcondition_stop_loss_point" value="stop_loss_point">
                                                                                                    </div>
                                                                                                </div>      

                                                                                                <div class="col-md-12">
                                                                                                    <div class="innerdeliver innerdeliver-editstock">
                                                                                                        <ul>
                                                                                                            <li><input id="webpop" type="checkbox" name="delivery_type[]" value="web-notif" <?php echo (in_array("web-notif", $value['delivery_type']) ? 'checked' : ''); ?> checked><label id="webpop" class="label--margin condition-notif">Website Popup</label></li>
                                                                                                            <li id="smscheckboxli"><input id="smspop" type="checkbox" name="delivery_type[]" value="sms-notif" <?php echo (in_array("sms-notif", $value['delivery_type']) ? 'checked' : ''); ?>><label id="smspop" class="label--margin condition-notif">SMS Notification</label></li>
                                                                                                        </ul>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                   <!-- <div class="col-md-6">
                                                                                                        <div class="condition-params">
                                                                                                            <div class="condition-type">
                                                                                                                
                                                                                                                <select id="condition-list">
                                                                                                                    <option value="">Select Conditions</option>
                                                                                                                    <option style="<?php //echo ($value['dcondition_entry_price'] == 'entry_price' ? 'display: none;' : ''); ?>" value="entry_price">Entry Price</option>
                                                                                                                    <option style="<?php //echo ($value['dcondition_take_profit_point'] == 'take_profit_point' ? 'display: none;' : ''); ?>" value="take_profit_point">Take Profit Point</option>
                                                                                                                    <option style="<?php// echo ($value['dcondition_stop_loss_point'] == 'stop_loss_point' ? 'display: none;' : ''); ?>" value="stop_loss_point">Stop Loss Point</option>
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
                                                                                                    <!--<div class="col-md-6">
                                                                                                        <div class="dpaste">
                                                                                                            <ul class="listofinfo">
                                                                                                                <?php // if (isset($value['dcondition_entry_price'])): ?>
                                                                                                                    <li class="dbaseitem">
                                                                                                                        <div class="dinfodata">
                                                                                                                            <div class="dcondition"><?php //echo $value['dcondition_entry_price']; ?></div>
                                                                                                                            <div class="dfreq"><?php //echo $value['dconnumber_entry_price']; ?></div>
                                                                                                                        </div>
                                                                                                                        <div class="closetab">
                                                                                                                            <input type="hidden" id="dparamcondition" name="dcondition_entry_price" value="<?php //echo $value['dcondition_entry_price']; ?>">
                                                                                                                            <input type="hidden" id="" name="dconnumber_entry_price" value="<?php //echo $value['dconnumber_entry_price']; ?>">
                                                                                                                            <button class="closemebutton"><i class="fa fa-minus-circle"></i></button>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <?php //endif ?>
                                                                                                                <?php //if (isset($value['dcondition_take_profit_point'])): ?>
                                                                                                                    <li class="dbaseitem">
                                                                                                                        <div class="dinfodata">
                                                                                                                            <div class="dcondition"><?php //echo $value['dcondition_take_profit_point']; ?></div>
                                                                                                                            <div class="dfreq"><?php //echo $value['dconnumber_take_profit_point']; ?></div>
                                                                                                                        </div>
                                                                                                                        <div class="closetab">
                                                                                                                            <input type="hidden" id="dparamcondition" name="dcondition_take_profit_point" value="<?php //echo $value['dcondition_take_profit_point']; ?>">
                                                                                                                            <input type="hidden" id="" name="dconnumber_take_profit_point" value="<?php //echo $value['dconnumber_take_profit_point']; ?>">
                                                                                                                            <button class="closemebutton"><i class="fa fa-minus-circle"></i></button>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <?php //endif ?>
                                                                                                                <?php //if (isset($value['dcondition_stop_loss_point'])): ?>
                                                                                                                    <li class="dbaseitem">
                                                                                                                        <div class="dinfodata">
                                                                                                                            <div class="dcondition"><?php// echo $value['dcondition_stop_loss_point']; ?></div>
                                                                                                                            <div class="dfreq"><?php //echo $value['dconnumber_stop_loss_point']; ?></div>
                                                                                                                        </div>
                                                                                                                        <div class="closetab">
                                                                                                                            <input type="hidden" id="dparamcondition" name="dcondition_stop_loss_point" value="<?php// echo $value['dcondition_stop_loss_point']; ?>">
                                                                                                                            <input type="hidden" id="" name="dconnumber_stop_loss_point" value="<?php //echo $value['dconnumber_stop_loss_point']; ?>">
                                                                                                                            <button class="closemebutton"><i class="fa fa-minus-circle"></i></button>
                                                                                                                        </div>
                                                                                                                    </li>
                                                                                                                <?php// endif ?>
                                                                                                                
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                    </div>-->
                                                                                                    <div class="col-md-12">
                                                                                                        <div class="submitform" style="margin-left: 84px;">
                                                                                                            <img class="chart-preloader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 30px; height: 30px; display: none; float: right; margin-right: -6px; margin-left: 23px;">
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
                                                            <?php endif; } ?>
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
                                            <div class="dclosetab addwatchtab " style="width: 271px;">


                                                <!-- wathlist phone number modal -->    
                                                <div class="modal" id="modal-phonenum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-modelbox-margin" role="document" style="left: 0; width: 300px">
                                                        <div class="modal-content">
                                                            <div class="modal-header header-depo">
                                                                <h5 class="modal-title title-depo" id="exampleModalLabel">Add Cellphone Number</h5>
                                                                <button type="button" class="close close-depo" data-dismiss="modal" aria-label="Close">
                                                                    <i class="fas fa-times modal-btn-close-deposit"></i>
                                                                </button>
                                                            </div>
                                                            <hr class="style14 style15">
                                                            <form action="/watchlist" method="GET" id="frmcpnum" class="add-funds-show depotincome">
                                                            <div class="modal-body depo-body">
                                                                <div class="dmainform">
                                                                    <div class="dinnerform">
                                                                        <div class="dinitem">
                                                                                <h5 class="modal-title title-depo-in" id="exampleModalLabel" style="font-weight: 300;font-size: 13px;">Cellphone</h5>
                                                                                <div class="dninput"><input type="text" id="txtcpnum" name="txtcpnum" class="depo-input-field" style="background: #4e6a85; text-align: right; font-size: 13px !important;"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer footer-depo">
                                                                    <a href="#" id="cpsubmitbtn" class="depotbutton arbitrage-button arbitrage-button--primary" style="font-size: 11px;">Submit</a>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- wathlist phone number modal -->    



                                                <form method="post" action="" id="add-watchlist-param">
                                                    <div class="instumentinner">
                                                        <div class="">


                                                        <div class="groupinput midd selectstock"><label>Stock Code</label>
                                                            

                                                            <input type="text" autocomplete="off" class="input-stock" id="myDropdown" placeholder="Search" style="margin-left: -3px; text-align: right;" >


                                                            <div class="dropdown-content ddropbase" style="display: none;">
                                                                        <input type="hidden" id="dstockname" name="stockname">
                                                                        <div class="listofstocks"></div>
                                                                    </div>

                                                        </div>
                                                        <hr>
                                                        <div class="groupinput midd"><label>Entry Price</label>
                                                            <input type="text" name="dconnumber_entry_price" class="inpt_data_price number" placeholder="Enter Amount" autocomplete="off">
                                                            <input type="hidden" id="dparamcondition" name="dcondition_entry_price" value="entry_price">
                                                        </div>
                                                        <div class="groupinput midd"><label>Take Profit</label>
                                                            <input type="text" name="dconnumber_take_profit_point" class="inpt_data_price number" placeholder="Enter Amount" autocomplete="off">
                                                            <input type="hidden" id="dparamcondition" name="dcondition_take_profit_point" value="take_profit_point" autocomplete="off">
                                                        </div>
                                                        <div class="groupinput midd"><label>Stop Loss</label>
                                                            <input type="text" name="dconnumber_stop_loss_point" class="inpt_data_price number" placeholder="Enter Amount">
                                                            <input type="hidden" id="dparamcondition" name="dcondition_stop_loss_point" value="stop_loss_point">
                                                        </div>
                                                        <div class="selectnotifitems">
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
                                                                    <div class="submitform" style="margin-right: -125px;">
                                                                        <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 30px; height: 30px; display: none; float: right; margin-right: 14px; margin-left: 23px;">
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
                      <?php include_once "watchlist/sidebar-viewedstocks.php";?>
                      <?php include_once "watchlist/sidebar-topgainerslosers.php";?>    
                      <?php //include_once "parts/sidebar-latestnews.php";?>    
                      <?php include_once "parts/sidebar-footer.php";?>               
                </div>

            </div>
            <br class="clear">

        </div>
    </div>

</div> <!-- #main-content -->

<?php include_once "watchlist/footer-files.php";?> 