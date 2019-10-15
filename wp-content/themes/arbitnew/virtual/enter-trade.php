<div class="dbuttonenter" style="margin-right: 1px;">
    <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="fancybox-inline enter-trade-btn" style="font-weight: 400;">Trade</a>

      <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <div class="entr_ttle_bar">
                        <strong>Enter Order: </strong> <span class="btnbuy">BUY</span>|<span class="btnsell">SELL</span>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                   
                         <div class="groupinput midd lockedd"><label>Stock</label>
                            <select name="inpt_data_stock_y" id="inpt_data_select_stock" style="margin-left: -4px; text-align: left;width: 111px;">
                                <option value="">Select Stocks</option>
                            </select>
                            <input type="hidden" name="inpt_data_stock" id="dfinstocks">
                        </div>
                        <div class="desc">Banco De Oro <span class="crice">Current Price: 123.45</span></div>
                        <hr>
                        <div>
                            <p style="font-size: 12px;">STOCK DETAILS</p>
                            <div class="details">
                            <p>Previous</p>
                            <p>Low</p>
                            <p>52WKLow</p>
                            <p>Volume</p>
                            <p>Trades</p>
                            </div>
                            <div class="details2">
                            <p>Open</p>
                            <p>High</p>
                            <p>52WKHigh</p>
                            <p>Valve</p>
                            <p>Average</p>
                            </div>
                        </div>

                        <div class="bars">
                            <div class="bidaskbar">
                                <span>Bid/Ask Bar</span>
                                <div class="arb_bar fullbar">
                                    <div class="arb_bar_green" style="width:60%">&nbsp;</div>
                                    <div class="arb_bar_red" style="width:40%">&nbsp;</div>
                                </div>
                            </div>
                            <div class="marketsents">
                                <span>Members Sentiments</span>
                                <div class="arb_bar fullbar">
                                    <div class="arb_bar_green" style="width:80%">&nbsp;</div>
                                    <div class="arb_bar_red" style="width:20%">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="tdetails">
                            <span>TRADE DETAILS</span>
                            <span class="avfunds">Available funds: 2,000,000.00</span>
                        </div>
                        <div class="footer_details">
                            <div class="buyprice">
                                <div class="groupinput midd"><label class="labelprice">Buy Price</label><input type="text" id="entertopdataprice" name="inpt_data_price" class="inputbuyprice number" required></div>
                            </div>
                            <div class="quantity">
                                <div class="groupinput midd"><label class="labelquantity">Quantity</label><input type="text" id="entertopdataprice" name="quantity" class="inputquantity number" required></div>
                            </div>
                        </div>
                        <div class="total_cost" style="text-align: right;"><span>Total Cost: 123,456,789.00</span></div>
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
                                <input type="submit" class="confirmtrd dloadform green modal2-button-confirm" value="Confirm Order">
                            </div> 

                </div>
               <!-- <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>-->
              </div>
              
            </div>
    </div>

</div>