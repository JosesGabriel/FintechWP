<div ng-controller="stockInfo">
    <div id="stock-details" style="display:block" ng-if="hasData">
    <?php
    $dledger = $wpdb->get_results( "SELECT * FROM arby_ledger where userid = ".$user_id);
?>
<div class="arb_buysell" id="draggable_buysell">
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

        <div style="padding: 3px 5px 5px 40px; margin-bottom: 2px;" id="sval" class="sd_border_btm">
            
            <div class="arb_stock_name"><!-- STOCK NAME -->
                <i class="fas " ng-class="{'fa-arrow-up': stock.change > 0, 'fa-arrow-down': stock.change < 0}" style="font-size: 35px;position: absolute; left: 4px;"></i>
                <div class="name text-uppercase text-default" style="font-size: 15px; font-weight: bold; white-space: nowrap; width: 100%; overflow: hidden;
                text-overflow: ellipsis;">{{stockInfo.description}}</div>
                <div class="figures" style="margin-top: 0; overflow: visible; white-space: nowrap;">
                    <span style="
                        font-size: 25px;
                        font-weight: bold;
                        letter-spacing: -1px;" class="text-default">{{stock.last | number:2}}</span>
                    <span ng-class="{'text-green': stock.change > 0, 'text-red': stock.change < 0, 'text-yellow': stock.change == 0}" style="
                        font-size: 14px;
                        line-height: 1.42857143;">
                        <span style="font-size: 17px;font-weight: bold;margin-left: 5px;">{{stock.change | number:2}}</span>
                        <span style="font-size: 17px;font-weight: bold;margin-left: 5px;">({{stock.change_percentage | number:2}}%)</span>
                    </span>
                    <small class="arb_markcap">Market Capitalization: {{stock.displayMarketCap}}</small>
                </div>
            </div>
        </div>

        <div class="border-default" style="min-height: 77px;">
            <div style="float: left; width: 50%;">
                <table class="table table-condensed m-b-0 ">
                    <tbody style="font-size: 10px;">
                        <tr>
                            <td style="border-top: none; font-weight: bold; padding: 5px;" class="text-uppercase">Previous</td>
                            <td style="border-top: none; font-weight: bold; padding: 5px;" class="text-default"><strong>{{stock.previous | number:2}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">Low</td>
                            <td style="font-weight: bold; padding: 5px;" class="" changediv="stock.low"><strong ng-class="{'text-green': stock.low > stock.previous, 'text-red': stock.low < stock.previous}">{{stock.low | number:2}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">52WkLow</td>
                            <td style="font-weight: bold; padding: 5px;" class=""><strong ng-class="{'text-green': stock.weekYearLow > stock.last, 'text-red': stock.weekYearLow < stock.last}">{{stock.weekYearLow | number:2}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">Volume</td>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase text-default" changediv="stock.volume"><strong>{{stock.volume | abbr}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">Trades</td>
                            <td style="font-weight: bold; padding: 5px;" class="text-default" changediv="stock.trades"><strong>{{stock.trades | numeraljs: '0,0'}}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="float: left; width: 50%;">
                <table class="table table-condensed m-b-0 sd_border_btm">
                    <tbody style="font-size: 10px;">
                        <tr>
                            <td style="border-top: none; font-weight: bold; padding: 5px;" class="text-uppercase">Open</td>
                            <td style="border-top: none; font-weight: bold; padding: 5px;"><strong ng-class="{'text-green': stock.open > stock.previous, 'text-red': stock.open < stock.previous}">{{stock.open | number:2}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">High</td>
                            <td style="font-weight: bold; padding: 5px;" changediv="stock.high"><strong ng-class="{'text-green': stock.high > stock.previous, 'text-red': stock.high < stock.previous}">{{stock.high | number:2}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">52WkHigh</td>
                            <td style="font-weight: bold; padding: 5px;" class=""><strong ng-class="{'text-green': stock.weekYearHigh > stock.last, 'text-red': stock.weekYearHigh < stock.last}">{{stock.weekYearHigh}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">Value</td>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase text-default" changediv="stock.value"><strong>{{stock.displayValue}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">Average</td>
                            <td style="font-weight: bold; padding: 5px;" changediv="stock.average"><strong ng-class="{'text-green': stock.average > stock.previous, 'text-red': stock.average < stock.previous}">{{stock.average | number:2}}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <div class="arb_logo_placehldr">
        <h2><img src="/wp-content/themes/arbitrage-child/cd/img/Asset 4.png" style="width:53%;;vertical-align:baseline"></h2>
    </div>
</div>