<div class="dbuttonenter">
    <!-- <form action="/journal" method="post"> -->
        <!-- <input type="submit" name="entertradebtn" value="Trade" class="enter-trade-btn"> -->
        <a href="#entertrade_mtrade" class="fancybox-inline enter-trade-btn" style="font-weight: 400;">Trade</a>
        <div class="hideformodal">
            
            <div class="entertrade dtopentertrade" id="entertrade_mtrade">
                <div class="entr_ttle_bar">
                    <strong>Enter Buy Order</strong> <span class="datestamp_header"><?php /*echo date('F j, Y g:i a');*/ ?></span>
                </div>
                <form action="/journal" method="post" class="dentertrade" autocomplete="off">
                <div class="entr_wrapper_top">
                        <div class="entr_col">
                            <div class="groupinput fctnlhdn">
                                <label style="width:100%">Buy Date:</label>
                                <input type="hidden" name="inpt_data_buymonth" value="<?php echo date('F'); ?>">
                                <input type="hidden" name="inpt_data_buyday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date('j'); ?>">
                                <input type="hidden" name="inpt_data_buyyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date('Y'); ?>">
                            </div>
                            <div class="groupinput midd lockedd"><label>Stock</label>
                                <!-- <input type="text" name="inpt_data_stock" id="inpt_data_stock" style="margin-left: -3px; text-align: left;" value="" readonly> -->
                                <select name="inpt_data_stock_y" id="inpt_data_select_stock" style="margin-left: -4px; text-align: left;width: 138px;">
                                    <option value="">Select Stocks</option>
                                    <?php foreach($listosstocks as $dstkey => $dstvals): ?>
                                        <option value='<?php echo json_encode($dstvals); ?>'><?php echo $dstvals->symbol; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" name="inpt_data_stock" id="dfinstocks">
                                <!-- <i class="fa fa-lock" aria-hidden="true"></i> -->
                            </div>
                            <div class="groupinput midd"><label>Enter Price</label><input type="text" id="entertopdataprice" name="inpt_data_price" class="textfield-buyprice number" required></div>
                            <div class="groupinput midd"><label>Quantity</label><input type="text" id="entertopdataquantity" name="inpt_data_qty" class="textfield-quantity number" required></div>
                            <div class="groupinput midd label_date">
                                <label>Enter Date</label><input type="date" class="inpt_data_boardlot_get buySell__date-picker" required id="journal__trade-btn--date-picker">
                            </div>
                            <div class="groupinput midd lockedd label_funds"><label>Available Funds: </label>
                            <input type="text" name="input_buy_product" id="input_buy_product" class="number" step="0.01" style="margin-left: -4px;" value="<?php echo number_format($buypower, 2, '.', ','); ?>" readonly>
                            <i class="fa fa-lock" aria-hidden="true" style="display: none;"></i></div>
                            <div class="groupinput midd lockedd label_cost"><label>Total Cost: </label><input readonly="" type="text" class="number" name="inpt_data_total_price" value=""><i class="fa fa-lock" aria-hidden="true" style="display:none;"></i></div>
                        </div>
                        <div class="entr_col">
                            <div class="groupinput midd lockedd"><label>Curr. Price</label><input readonly type="text" name="inpt_data_currprice" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                            <div class="groupinput midd lockedd"><label>Change</label><input readonly type="text" name="inpt_data_change" value="%"><i class="fa fa-lock" aria-hidden="true"></i></div>
                            <div class="groupinput midd lockedd"><label>Open</label><input readonly type="text" name="inpt_data_open" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                            <div class="groupinput midd lockedd"><label>Low</label><input readonly type="text" name="inpt_data_low" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                            <div class="groupinput midd lockedd"><label>High</label><input readonly type="text" name="inpt_data_high" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                        </div>
                        <div class="entr_col">
                            <div class="groupinput midd lockedd"><label>Volume</label><input readonly type="text" name="inpt_data_volume" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                            <div class="groupinput midd lockedd"><label>Value</label><input readonly type="text" name="inpt_data_value" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                            <div class="groupinput midd lockedd">
                                <label>Board Lot</label><input type="text" name="inpt_data_boardlot" id="" value="0" readonly>
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <input type="hidden" id="inpt_data_boardlot_get" value="0">
                            </div>

                            


                        </div>
                        <div class="entr_clear"></div>
                </div>
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
                                <option value="Neutral">Neutral</option>
                                <option value="Greedy">Greedy</option>
                                <option value="Fearful">Fearful</option>
                            </select>
                        </div>
                    </div>
                    <div class="groupinput">
                        <textarea class="darktheme" name="inpt_data_tradingnotes" onClick="this.value = ''">Trading Notes</textarea>
                        <!-- <div>this is it</div> -->
                    </div>
                    <div class="groupinput">
                            <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right;margin-right: 10px;">
                        <input type="hidden" value="Live" name="inpt_data_status">
                        <input type="hidden" id="newdate" name="newdate">
                        <input type="submit" class="confirmtrd dloadform green modal-button-confirm" value="Confirm Trade">
                    </div>
                    </div>
                </form>
            </div>
        </div>
    <!-- </form> -->
</div>