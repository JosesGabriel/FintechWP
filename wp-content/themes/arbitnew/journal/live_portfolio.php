<div id="live_portfolio" class="dstatstrade overridewidth">
    <ul>
        <li class="headerpart">
            <div style="width:100%;">
                <div style="width:7%; text-align: left !important;">Stocks</div>
                <div style="width:9%" class="table-title-live table-title-avprice">Position</div>
                <div style="width:11%" class="table-title-live table-title-avprice">Avg. Price</div>
                <div style="width:15%" class="table-title-live table-title-tcost">Total Cost</div>
                <div style="width:15%" class="table-title-live table-title-mvalue">Market Value</div>
                <div style="width:15%" class="table-title-live table-title-profit">Profit</div>
                <div style="width:8%" class="table-title-live table-title-performance">Perf.</div>
                <div style="width:105px; text-align:center;">Action</div>
            </div>
        </li>
    </ul>
    <div class="hideformodal">
        <a href="#entertradelive" id="openboxmode"></a>
        <div class="entertrade buyaddtrade" id="entertradelive">
            <div class="entr_ttle_bar">
                <strong>Enter Buy Order</strong> <span class="datestamp_header"><?php echo date('F j, Y g:i a'); ?><input type="date" class="buySell__date-picker" onchange="buydate(this);"></span>
            </div>
            <form action="/journal" method="post">
            <div class="entr_wrapper_top">
                <div class="entr_col">
                    <div class="groupinput fctnlhdn">
                        <label style="width:100%">Buy Date:</label>
                        <input type="hidden" name="inpt_data_buymonth" value="<?php echo date('F'); ?>">
                        <input type="hidden" name="inpt_data_buyday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date('j'); ?>">
                        <input type="hidden" name="inpt_data_buyyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date('Y'); ?>">
                    </div>
                    <div class="groupinput midd lockedd"><label>Stock</label>
                    <input type="text" name="inpt_data_stock" id="inpt_data_stock" style="margin-left: -4px; text-align: left;" value="" readonly>
                    <i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd"><label>Buy Power</label>
                    <input type="text" name="input_buy_product" id="input_buy_product" class="number" style="margin-left: -4px;" value="" readonly>
                    <i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd"><label>Buy Price</label><input type="text" name="inpt_data_price" class="textfield-buyprice number" required></div>
                    <div class="groupinput midd"><label>Quantity</label><input type="text" name="inpt_data_qty" class="textfield-quantity number" required></div>
                </div>
                <div class="entr_col">
                    <div class="groupinput midd lockedd"><label>Curr. Price</label><input readonly type="text" name="inpt_data_currprice" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd"><label>Change</label><input readonly type="text" name="inpt_data_change" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd"><label>Open</label><input readonly type="text" name="inpt_data_open" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd"><label>Low</label><input readonly type="text" name="inpt_data_low" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd"><label>High</label><input readonly type="text" name="inpt_data_high" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                </div>
                <div class="entr_col">
                    <div class="groupinput midd lockedd"><label>Volume</label><input readonly type="text" name="inpt_data_volume" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd"><label>Value</label><input readonly type="text" name="inpt_data_value" value=""><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd">
                        <label>Board Lot</label><input type="text" name="inpt_data_boardlot" id="" value="<?php echo $dboard; ?>" readonly>
                        <i class="fa fa-lock" aria-hidden="true"></i>

                        <input type="hidden" id="inpt_data_boardlot_get" value="<?php echo $dboard; ?>">
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
                        <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right;margin-right: 10px;">
                    <input type="hidden" value="Live" name="inpt_data_status">
                    <input type="hidden" value="" name="addstockisdate" id="addstockisdate">
                    <input type="submit" class="confirmtrd green modal-button-confirm" value="Confirm Trade">
                </div>
                </div>
            </form>
        </div>
        <a href="#selllivetrade" id="opensellbox"></a>
        <div class="selltrade selltrade--align" id="selllivetrade">
            <div class="entr_ttle_bar"><strong>Sell Trade</strong></div>
                <form action="/journal" method="post">
                    <div class="entr_wrapper_top">
                        <div class="entr_col">
                            <div class="groupinput fctnlhdn">
                                <label>Sell Date</label>
                                <select name="inpt_data_sellmonth" style="width:90px;">
                                    <option value="<?php echo date('F'); ?>" selected><?php echo date('F'); ?></option>
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
                                <input type="text" name="inpt_data_sellday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date('j'); ?>">
                                <input type="text" name="inpt_data_sellyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date('Y'); ?>">
                            </div>
                        <div class="groupinput midd lockedd"><label>Stock</label><input type="text" name="inpt_data_stock" value="" readonly style="text-align: left;"><i class="fa fa-lock" aria-hidden="true"></i></div>
                        <div class="groupinput midd lockedd"><label>Position</label><input type="text" name="inpt_data_position" value="" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                    </div>
                    <div class="entr_col">
                        <div class="groupinput midd lockedd"><label>Avr. Price</label><input type="text" name="inpt_avr_price_b" value="" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                        <div class="groupinput midd lockedd"><label>Curr. Price</label><input type="text" name="inpt_data_price" value="" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                    </div>
                    <div class="entr_col">
                        <div class="groupinput midd"><label>Sell Price</label><input step="0.01" name="inpt_data_sellprice" class="no-padding" id="sell_price--input" required></div>
                        <div class="groupinput midd"><label>Qty.</label><input name="inpt_data_qty" value="" class="no-padding" id="qty_price--input" required></div>
                        <div class="groupinput midd inpt_data_price"><label>Sell Date</label><input type="date" name="selldate" class="buySell__date-picker trade_input changeselldate"></div>
                    </div>
                    <div class="entr_clear"></div>
                </div>
                <div>
                    <div style="height: 36px;">
                        <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right;margin-right: 10px;">
                        <input type="hidden" value="Log" name="inpt_data_status">
                        <input type="hidden" value="" name="inpt_avr_price">
                        <input type="hidden" value="" name="inpt_data_postid">
                        <input type="hidden" name="dtradelogs" value=''>
                        <input type="submit" id="buy-order--submit" class="confirmtrd green buy-order--submit" value="Confirm Trade">
                    </div>
                </div>
            </form>
        </div>
        <a href="#livetradenotes" id="opentradedetails"></a>
        <div class="tradelogbox" id="livetradenotes">
            <div class="entr_ttle_bar">
                <strong>Trade Details</strong>
            </div>
            <hr class="style14 style15" style="width: 93% !important;margin: 5px auto !important;">
            <div class="trdlgsbox">

                <div class="trdleft">
                    <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Strategy:</strong></span> <span class="modal-notes-result modal-notes-result-toleft addstrats"></span></div>
                    <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Trade Plan:</strong></span> <span class="modal-notes-result modal-notes-result-toleft addtplan"></span></div>
                    <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Emotion:</strong></span> <span class="modal-notes-result modal-notes-result-toleft addemotion"></span></div>
                    <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Outcome:</strong></span> <span class="modal-notes-result modal-notes-result-toleft txtred addoutcome"></span></div>
                </div>
                <div class="trdright darkbgpadd">
                    <div><strong>Notes:</strong></div>
                    <div class="addnotes"></div>
                </div>
                <div class="trdclr"></div>
            </div>
        </div>
    </div>
</div>
