<div class="dbuttonenter" style="margin-right: 1px;margin-left: 6px;">
    <a href="javascript:void(0)" data-toggle="modal" data-target="#enter_trade" class="fancybox-inline enter-trade-btn" style="font-weight: 400;">Trade</a>

    <?php //require __DIR__ . "/../components/modals/buy-sell-order.php" ?>
</div>

<div class="modal fade" id="enter_trade" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <div class="entr_title_bar">
                        <span class="label_enter">Enter Order:</span><div class="bsbutton"><span class="btnbuy">BUY</span> <div class="bbuy">&nbsp;</div>|<div class="bsell">&nbsp;</div> <span class="btnsell">SELL</span></div>
                        <input type="hidden" name="" class="btnValue" value="buy">
                        <button type="button" class="close_btn" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                   
                         <div class="groupinput midd lockedd"><label>Stock</label>
                            <select name="inpt_data_stock_y" class="data_stocks" id="inpt_data_select_stock" style="margin-left: -4px; text-align: left;width: 111px;">
                                <option value="">Select Stocks</option>
                            </select>
                            <input type="hidden" name="inpt_data_stock" id="dfinstocks">
                            <div class="date_now" style="position: absolute;right: 0;">
                                <span>Date:</span><span style="margin-left: 5px;"><?php echo date("M. d, Y"); ?></span>
                            </div>
                        </div>

                        <div class="desc"><span class="sdesc"></span></div>
                        <div class="crice">
                            <span>Current Price: </span><span class="cprice" style="font-size: 14px;"></span><span class="change" style="font-size: 12px;"></span><span class="cpercentage" style="font-size: 12px;"></span>
                        </div>
                        <hr>
                        <div>
                            <p style="font-size: 14px; margin-bottom: 3px;">STOCK DETAILS</p>
                            <div class="details">
                            <p>Previous <span class="pdetails prev"></span></p>
                            <p>Low <span class="pdetails low" style="color: #e64c3c;"></span></p>
                            <p>52WKLow <span class="pdetails klow" style="color: #e64c3c;"></span></p>
                            <p>Volume <span class="pdetails vol"></span></p>
                            <p>Trades <span class="pdetails trade"></span></p>
                            </div>
                            <div class="details2">
                            <p>Open <span class="pdetails open"></span></p>
                            <p>High <span class="pdetails high" style="color: #25ae5f"></span></p>
                            <p>52WKHigh <span class="pdetails khigh" style="color: #25ae5f"></span></p>
                            <p>Value <span class="pdetails val"></span></p>
                            <p>Average <span class="pdetails av"></span></p>
                            </div>
                        </div>

                        <div class="bars">
                            <div class="bidaskbar">
                                <span style="font-weight: 600;">Bid/Ask Bar</span>
                                <div class="arb_bar fullbar">
                                    <div class="arb_bar_green" style="width:60%; height: 6px;">&nbsp;</div>
                                    <div class="arb_bar_red" style="width:40%; height: 6px;">&nbsp;</div>
                                </div>
                            </div>
                            <div class="marketsents">
                                <span style="font-weight: 600;">Members Sentiments</span>
                                <div class="arb_bar fullbar">
                                    <div class="arb_bar_green_m" style="width:50%;height: 6px;">&nbsp;</div>
                                    <div class="arb_bar_red_m" style="width:50%;height: 6px;">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="tdetails">
                            <span style="font-weight: 600;font-size: 14px;">TRADE DETAILS</span>
                            <span class="avfunds">Available funds: <span class="av_funds" style="font-size: 11px;">100,000.00</span></span>
                        </div>
                        <div class="footer_details">
                            <div class="buyprice">
                                <div class="groupinput midd"><label class="labelprice">Buy Price</label><input type="text" id="entertopdataprice" name="inpt_data_price" class="inputbuyprice number" disabled></div>
                            </div>
                            <div class="quantity">
                                <div class="groupinput midd"><label class="labelquantity">Quantity</label><input type="text" autocomplete="off" class="inputquantity number" style="padding-right: 5px;" required></div>
                            </div>
                        </div>
                        <div class="total_cost" style="text-align: right; margin-top: -5px;"><span style="font-size: 11px;">Total Cost: </span><span class="tlcost"></span></div>
                            <div class="footer_details2">  
                                <div class="entry_wrapper_mid">
                                    <div class="dropdown_btn">
                                        <div class="groupinput selectstrategy">
                                            <select name="inpt_data_strategy" class="inpt_data_strategy rnd">
                                                <option value="" selected>Select Strategy</option>
                                                <option value="Bottom Picking">Bottom Picking</option>
                                                <option value="Breakout Play">Breakout Play</option>
                                                <option value="Trend Following">Trend Following</option>
                                                <option value="1-2-3 Reversal">1-2-3 Reversal</option>
                                                <option value="First Hour Breakout">First Hour Breakout</option>
                                                <option value="Range Breakout">Range Breakout</option>
                                                <option value="Support-Resistance">Support-Resistance</option>
                                                <option value="Trendline Breakout">Trendline Breakout</option>
                                                <option value="Darvas Range">Darvas Range</option>
                                                <option value="Catalyst Driven">Catalyst Driven</option>
                                            </select>
                                        </div>
                                        <div class="groupinput selectstrategy">
                                            <select name="inpt_data_tradeplan" class="inpt_data_tradeplan rnd">
                                                <option value="" selected>Select Trade Plan</option>
                                                <option value="Day Trade">Day Trade</option>
                                                <option value="Swing Trade">Swing Trade</option>
                                                <option value="Investment">Investment</option>
                                            </select>
                                        </div>
                                        <div class="groupinput selectstrategy">
                                            <select name="inpt_data_emotion" class="inpt_data_emotion rnd">
                                                <option value="" selected>Select Emotion</option>
                                                <option value="Neutral">Neutral</option>
                                                <option value="Greedy">Greedy</option>
                                                <option value="Fearful">Fearful</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="tradenotes">
                                    <textarea class="darktheme tnotes" name="inpt_data_tradingnotes" onClick="this.value = ''">Trading Notes</textarea>
                                </div>
                                <input type="hidden" name="userid" class="userid" value="<?php echo $user->ID;?>">
                            </div>                         
                            
                            <div class="groupinput" style="text-align: right;">
                                <div class="marketstatus" style="width: 200px;"><span style="float: left;">Market Status:</span><span class="mstatus" style="float: left; padding-left: 5px;"></span></div>
                                <input type="button" class="confirm_order" value="Confirm Order">
                            </div> 

                </div>
               <!-- <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>-->
              </div>
              
            </div>
    </div>