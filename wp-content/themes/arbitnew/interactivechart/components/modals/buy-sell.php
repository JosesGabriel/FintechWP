<?php
    $dledger = $wpdb->get_results( "SELECT * FROM arby_ledger where userid = ".$user_id);
?>
<div class="arb_buysell ui-draggable ui-draggable-handle" id="draggable_buysell">
    <div class="buysell-grip-btn">
        <i class="fa fa-grip-vertical fa-lg" style="color: white;"></i>
    </div>
    <div class="buttons">
        <a class="arb_buy" data-fancybox data-src="#entertrade" href="javascript:;"><i class="fas fa-arrow-up"></i> Buy</a>
        <a class="arb_sell" data-fancybox data-src="#buytrade" href="javascript:;" data-stocksel="{{stockInfo.symbol}}" disabled><i class="fas fa-arrow-down"></i> Sell</a>
    </div>
</div>

<div class="hideformodal">
    <div class="buytrade" style="display:none" id="buytrade">
        <div class="innerbuy">
            <div class="selltrade selltrade--align" id="selltrade_">
                <div class="entr_ttle_bar">
                    <strong>Sell Trade</strong>
                </div>
                <form action="/journal" method="post">
                    <div class="entr_wrapper_top">
                        <div class="entr_col">
                            <div class="groupinput midd lockedd"><label>Stock</label><input type="text" id="sellstockname" name="inpt_data_stock" value="{{stockInfo.symbol}}" readonly style="text-align: left;"><i class="fa fa-lock" aria-hidden="true"></i></div>
                            <div class="groupinput midd lockedd"><label>Position</label><input type="text" id="sellvolume" name="inpt_data_price" value="" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                        </div>
                        <div class="entr_col">
                            <div class="groupinput midd lockedd"><label>Avr. Price</label><input type="text" id="sellavrprice" name="inpt_avr_price" value="" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                            <div class="groupinput midd lockedd"><label>Curr. Price</label><input type="text" id="sellcurrprice" name="inpt_data_price" value="{{stock.last | number:2}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                        </div>
                        <div class="entr_col">
                            <div class="groupinput midd"><label>Sell Price</label><input step="0.01" id="sellprice" name="inpt_data_sellprice" class="no-padding" id="sell_price--input" required></div>
                            <div class="groupinput midd"><label>Qty.</label><input name="inpt_data_qty" value="<?php echo get_post_meta(get_the_ID(), 'data_qty', true); ?>" class="no-padding" id="qty_price--input" required></div>
                            <div class="groupinput midd inpt_data_price"><label>Sell Date</label><input type="date" name="selldate" class="buySell__date-picker trade_input changeselldate" required></div>
                        </div>
                        <div class="entr_clear"></div>
                    </div>
                    <div>
                        <div style="height: 36px;">
                            <input type="hidden" value="Log" name="inpt_data_status">
                            <input type="hidden" value="fromchart" name="formsource">
                            <input type="hidden" name="dtradelogs" id="tradelogs" value=''>
                            <input type="submit" id="confirmsellparts" class="confirmtrd green buy-order--submit" value="Confirm Trade" style="display:none;">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="entertrade" style="display:none" id="entertrade">
        <?php
            $dbaseaccount = 0;
            foreach ($dledger as $dbaseledgekey => $dbaseledgevalue) {
                if ($dbaseledgevalue->trantype == "deposit" || $dbaseledgevalue->trantype == "selling") {
                    $dbaseaccount = $dbaseaccount + $dbaseledgevalue->tranamount;
                } else {
                    $dbaseaccount = $dbaseaccount - $dbaseledgevalue->tranamount;
                }
            }
        ?>

        <div class="entr_ttle_bar">
            <strong>Enter Buy Order</strong>
        </div>

        <form action="/journal" method="post">
            <div class="entr_wrapper_top">
                <div class="entr_col">
                    <div class="groupinput fctnlhdn">
                    <label style="width:100%">Buy Date:</label>
                    <select name="inpt_data_buymonth" style="width:90px;">
                        <option value="<?php echo date("F"); ?>" selected><?php echo date("F"); ?></option>
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
                    <input type="text" name="inpt_data_buyday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("j"); ?>">
                    <input type="text" name="inpt_data_buyyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("Y"); ?>">
                    </div>

                    <div class="groupinput midd lockedd"><label>Stock</label>
                    <input type="text" name="inpt_data_stock" id="inpt_data_stock" style="margin-left: -3px; text-align: left;" value="{{stockInfo.symbol}}" readonly>
                    <i class="fa fa-lock" aria-hidden="true"></i></div>

                    <div class="groupinput midd"><label>Buy Price</label><input type="text" class="inpt_data_price number" name="inpt_data_price" required></div>
                    <div class="groupinput midd"><label>Quantity</label><input type="text" class="inpt_data_qty number" name="inpt_data_qty" required></div>
                    <div class="groupinput midd label_date">
                        <label>Enter Date</label><input type="date" class="inpt_data_boardlot_get buySell__date-picker" required="" id="journal__trade-btn--date-picker">
                    </div>
                    <div class="midd lockedd"><label style="color: white;">Available Funds</label><input type="text" class="input_buy_power" style="background-color: transparent; border: 0; color: white; padding-right: 0 !important;" name="input_buy_power" data-dbaseval="<?php echo $dbaseaccount; ?>" value="<?php echo number_format( $dbaseaccount, 2, '.', ',' ); ?>" readonly></div>
                    <div class="midd lockedd"><label style="color: white;">Total Cost</label><input type="text" class="inpt_total_cost" name="" style="background-color: transparent; border: 0; color: white; padding-right: 0 !important;"></div>
                </div>

                <div class="entr_col">
                    <div class="groupinput midd lockedd"><label>Curr. Price</label><input type="text" name="inpt_data_currprice" value="{{stock.last | number:2}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd"><label>Change</label><input type="text" name="inpt_data_change" value="{{stock.change_percentage | number:2}}%" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd"><label>Open</label><input type="text" name="inpt_data_open" value="{{stock.open | number:2}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd"><label>Low</label><input type="text" name="inpt_data_low" value="{{stock.low | number:2}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd"><label>High</label><input type="text" name="inpt_data_high" value="{{stock.high | number:2}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                </div>

                <div class="entr_col">
                    <div class="groupinput midd lockedd"><label>Volume</label><input type="text" name="inpt_data_volume" value="{{stock.volume | abbr}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd"><label>Value</label><input type="text" name="inpt_data_value" value="{{stock.displayValue}}" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                    <div class="groupinput midd lockedd">
                        <label>Board Lot</label><input type="text" name="inpt_data_boardlot" id="inpt_data_boardlot" value="" readonly>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <input type="hidden" id="inpt_data_boardlot_get" value="{{stock.last | number:2}}">
                    </div>
                </div>

                <div class="entr_clear"></div>
            </div>

            <div class="derrormes" style="color: #f44336;"></div>

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
                    <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right; margin-right: 20px;">
                    <input type="hidden" value="Live" name="inpt_data_status">
                    <input type="submit" class="confirmtrd green" style="outline: none;" value="Confirm Trade">
                </div>
            </div>
        </form>
    </div>
</div>