<div class="dbuttonenter" style="margin-right: 1px;">
    <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="fancybox-inline enter-trade-btn" style="font-weight: 400;">Trade</a>

      <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <div class="entr_title_bar">
                        Enter Order: <span class="btnbuy">BUY</span> <div class="bbuy">&nbsp;</div>|<div class="bsell">&nbsp;</div> <span class="btnsell">SELL</span>
                        <button type="button" class="close_btn" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                   
                         <div class="groupinput midd lockedd"><label>Stock</label>
                            <select name="inpt_data_stock_y" id="inpt_data_select_stock" style="margin-left: -4px; text-align: left;width: 111px;">
                                <option value="">Select Stocks</option>
                            </select>
                            <input type="hidden" name="inpt_data_stock" id="dfinstocks">
                        </div>
                        <div class="desc">Banco De Oro <span class="crice">Current Price: <span class="cprice">123.45</span></span></div>
                        <hr>
                        <div>
                            <p style="font-size: 14px; margin-bottom: 3px;">STOCK DETAILS</p>
                            <div class="details">
                            <p>Previous <span class="pdetails prev">235.40</span></p>
                            <p>Low <span class="pdetails low">235.10</span></p>
                            <p>52WKLow <span class="pdetails klow">212.00</span></p>
                            <p>Volume <span class="pdetails vol">18.17</span></p>
                            <p>Trades <span class="pdetails trade">561</span></p>
                            </div>
                            <div class="details2">
                            <p>Open <span class="pdetails open">235.20</span></p>
                            <p>High <span class="pdetails high">235.70</span></p>
                            <p>52WKHigh <span class="pdetails khigh">350.60</span></p>
                            <p>Value <span class="pdetails val">22.15M</span></p>
                            <p>Average <span class="pdetails av">234.20</span></p>
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
                                    <div class="arb_bar_green" style="width:80%;height: 6px;">&nbsp;</div>
                                    <div class="arb_bar_red" style="width:20%;height: 6px;">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="tdetails">
                            <span style="font-weight: 600;font-size: 14px;">TRADE DETAILS</span>
                            <span class="avfunds">Available funds: 2,000,000.00</span>
                        </div>
                        <div class="footer_details">
                            <div class="buyprice">
                                <div class="groupinput midd"><label class="labelprice">Buy Price</label><input type="text" id="entertopdataprice" name="inpt_data_price" class="inputbuyprice number" required></div>
                            </div>
                            <div class="quantity">
                                <div class="groupinput midd"><label class="labelquantity">Quantity</label><input type="number" id="entertopdataprice" name="quantity" class="inputquantity number" required></div>
                            </div>
                        </div>
                        <div class="total_cost" style="text-align: right; margin-top: -5px;"><span style="font-size: 11px;">Total Cost: 123,456,789.00</span></div>
                            <div class="footer_details2">  
                                <div class="entry_wrapper_mid">
                                    <div class="dropdown_btn">
                                        <div class="groupinput selectstrategy">
                                            <select name="inpt_data_strategy" class="rnd">
                                                <option value="" selected>Select Strategy</option>
                                                <option value="Bottom Picking">Bottom Picking</option>
                                                <option value="Breakout Play">Breakout Play</option>
                                                <option value="Trend Following">Trend Following</option>
                                            </select>
                                        </div>
                                        <div class="groupinput selectstrategy">
                                            <select name="inpt_data_tradeplan" class="rnd">
                                                <option value="" selected>Select Trade Plan</option>
                                                <option value="Day Trade">Day Trade</option>
                                                <option value="Swing Trade">Swing Trade</option>
                                                <option value="Investment">Investment</option>
                                            </select>
                                        </div>
                                        <div class="groupinput selectstrategy">
                                            <select name="inpt_data_emotion" class="rnd">
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
                            </div>
                            <div class="groupinput" style="text-align: right;">
                                <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right;margin-right: 10px;">
                                <input type="submit" class="confirm_order" value="Confirm Order">
                            </div> 

                </div>
               <!-- <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>-->
              </div>
              
            </div>
    </div>

</div>