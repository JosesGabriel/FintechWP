
<?php
include_once "watchlist/header-files.php";
require("parts/global-header.php");
require("parts/sidebar-calc.php");
require("parts/sidebar-varcalc.php");
require("parts/sidebar-avarageprice.php");
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
            // add_user_meta($userID, '_watchlist_instrumental', $newarray);
            update_user_meta($userID, '_watchlist_instrumental', $newarray);
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


?>

<!-- #main-header -->
<div id="main-content" class="oncommonsidebar">

    <div class="inner-placeholder">
        <div class="inner-main-content">
            <div class="left-dashboard-part">
                <div class="swipeleft-area-l"></div>
                <div class="dashboard-sidebar-left">
                    <div class="dashboard-sidebar-left-inner">
                        <?php include_once "parts/sidebar-profile.php";?>
                    </div>
                </div>
            </div>
                        <div class="center-dashboard-part">
                <div class="swipecenter-area-r"></div>
                <div class="inner-center-dashboard">
                    <div class="add-post">
                        <!--start content-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-portlet">
                                    <!--<div class="box-portlet-header">

                                        <h2 class="watchtitle">Watchlist</h2>
                                    </div>-->
                                    <div class="box-portlet-content">
                                        <div class="dtabcontent">
                                            <div class="dclosetab watchtab active">
                                                <div class="dinnerlist watcherlist">
                                                        <ul>
                                                            <li class="addwatch">
                                                                <div class="dplusbutton">
                                                                    <div class="dplstext">Add watchlist</div>
                                                                    <div class="dplsicon" style="margin: 5px 70px;"><i class="fa fa-plus-circle"></i></div>
                                                                </div>
                                                            </li>
                                                        </ul> 
                                                        <!-- <div id="chartdivAB"></div>   -->
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
                                                                       <!-- <li><input type="checkbox" name="delivery_type[]" value="sms-notif"><label class="condition-notif">SMS Notification</label></li>-->
                                                                    </ul>
                                                                </div>
                                                        </div>


                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <!--<div class="dpaste">
                                                                        <ul class="listofinfo"></ul>
                                                                    </div>-->
                                                                    <div class="submitform watchlisteditsubmit" style="margin-right: -125px;">
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
                <div class="swipecenterl"></div>
                <div class="swipecenterr"></div>
            </div>

            <div class="right-dashboard-part">
                <div class="swiperight-area-r"></div>
                <div class="swiperight-area-r2"></div>
                <div class="right-dashboard-part-inner">
                      <?php include_once "watchlist/sidebar-viewedstocks.php";?>
                      <?php include_once "watchlist/sidebar-topgainerslosers.php";?>
                      <?php include_once "parts/sidebar-footer.php";?>
                      <?php include_once "parts/sidebar-alert.php";?>              
                </div>

            </div>
            <br class="clear">

        </div>
    </div>

</div> <!-- #main-content -->
<div class="modalparts">
    <div class="modal fade dmodaleditwatch" id="editstockmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content mc-background" style="width: 60%; height: 265px;">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" style="color: #333;"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="closemodal" aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body edit-stocks-padding">
            <div class="">
                <div class="editme">
                    <form method="post" action="#" id="edit-watchlist-para">
                        <input type="hidden" name="stockname" value="">
                        <div class="instumentinner">
                            <div class="row">
                                
                                <div class="cond-ion" style="margin: 15px 0px 0px 26px;">
                                    <div class="groupinput midd"><label>Entry Price</label>
                                        <input type="text" name="dconnumber_entry_price" class="inpt_data_price number" value="" >
                                        <input type="hidden" id="dparamcondition" name="dcondition_entry_price" value="entry_price">
                                    </div>
                                    <div class="groupinput midd"><label>Take Profit</label>
                                        <input type="text" name="dconnumber_take_profit_point" class="inpt_data_price number" value="">
                                        <input type="hidden" id="dparamcondition" name="dcondition_take_profit_point" value="take_profit_point">
                                    </div>
                                    <div class="groupinput midd"><label>Stop Loss</label>
                                        <input type="text" name="dconnumber_stop_loss_point" class="inpt_data_price number" value="">
                                        <input type="hidden" id="dparamcondition" name="dcondition_stop_loss_point" value="stop_loss_point">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="innerdeliver innerdeliver-editstock">
                                        <ul>
                                            <li><input id="webpop" type="checkbox" name="delivery_type[]" value="web-notif" checked><label id="webpop" class="label--margin condition-notif">Website Popup</label></li>
                                            <!--<li id="smscheckboxli"><input id="smspop" type="checkbox" name="delivery_type[]" value="sms-notif"><label id="smspop" class="label--margin condition-notif">SMS Notification</label></li>-->
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="submitform" style="margin-left: 84px;">
                                            <img class="chart-preloader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 30px; height: 30px; display: none; float: right; margin-right: -6px; margin-left: 23px;">
                                            <input type="hidden" name="toadddate" value="">
                                            <input type="hidden" name="isticked" value="">
                                            <input type="hidden" name="subtype" value="editdata">
                                            <button class="editmenow arbitrage-button arbitrage-button--primary" data-tochange="edit-watchlist-param">Change</button>
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
</div>

<?php include_once "watchlist/footer-files.php";?>
