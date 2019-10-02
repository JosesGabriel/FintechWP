<div id="live_portfolio" class="dstatstrade overridewidth">
    <ul>
        <li class="headerpart">
            <div style="width:100%;">
                <div style="width:7%; text-align: left !important;">Stocks</div>
                <div style="width:8%" class="table-title-live table-title-avprice">Position</div>
                <!--<div style="width:11%">Average Price</div>-->
                <div style="width:10%" class="table-title-live table-title-avprice">Avg. Price</div>
                <div style="width:14%" class="table-title-live table-title-tcost">Total Cost</div>
                <!--<div style="width:11%">Market Value</div>-->
                <div style="width:14%" class="table-title-live table-title-mvalue">Market Value</div>
                <div style="width:14%" class="table-title-live table-title-profit">Profit</div>
                <!--<div style="width:9%">Performance</div>-->
                <div style="width:7%" class="table-title-live table-title-performance">Perf.</div>
                <div style="width:77px; text-align:center;">Action</div>
                <!--<div style="width:45px; text-align: right;">Notes</div>-->
            </div>
        </li>
        <?php
        
        if ($getdstocks) {
            foreach ($getdstocks as $key => $value) {
                
                

                if(!$isjounalempty){
                    $dstocktraded = get_user_meta($user->ID, '_trade_'.$value, true);
                } else {
                    if($value == 'SampleStock_1'){
                        $dstocktraded = [
                            'data' => [
                                [
                                    'buymonth' => 'August',
                                    'buyday' => 22,
                                    'buyyear' => 2019,
                                    'stock' => 'MBT',
                                    'price' => 100,
                                    'qty' => 620,
                                    'currprice' => 75.40,
                                    'change' => '0.40%',
                                    'open' => 75.50,
                                    'low' => 75.20,
                                    'high' => 75.80,
                                    'volume' => '957.73K',
                                    'value' => '72.29m',
                                    'boardlot' => 10,
                                    'strategy' => 'Trend Following',
                                    'tradeplan' => 'Day Trade',
                                    'emotion' => 'this is a test',
                                    'tradingnotes' => 'Trading Notes',
                                    'status' => 'Live',
                                ],
                            ],
                            'totalstock' => 620,
                            'aveprice' => 2228.5209688868,
                            'totalcost' => 84225991.13847,
                            'stockname' => 'SampleStock_1',
                        ];
                    } else {
                        $dstocktraded = [
                            'data' => [
                                [
                                    'buymonth' => 'August',
                                    'buyday' => 22,
                                    'buyyear' => 2019,
                                    'stock' => 'MBT',
                                    'price' => 90,
                                    'qty' => 600,
                                    'currprice' => 75.40,
                                    'change' => '0.40%',
                                    'open' => 75.50,
                                    'low' => 75.20,
                                    'high' => 75.80,
                                    'volume' => '957.73K',
                                    'value' => '72.29m',
                                    'boardlot' => 10,
                                    'strategy' => 'Trend Following',
                                    'tradeplan' => 'Day Trade',
                                    'emotion' => 'this is a test',
                                    'tradingnotes' => 'Trading Notes',
                                    'status' => 'Live',
                                ],
                            ],
                            'totalstock' => 600,
                            'aveprice' => 2228.5209688868,
                            'totalcost' => 84225991.13847,
                            'stockname' => 'Sample_2',
                        ];
                    }
                    
                    
                }
                if ($dstocktraded && $dstocktraded != '') {
                    $key = array_search($value, array_column($gerdqoute->data, 'symbol'));
                    $stockdetails = $gerdqoute->data[$key];

                    $dstockinfo = $stockdetails;
                    if($isjounalempty){
                        $dstockinfo = new \stdClass();
                        $dstockinfo->last = 100.50;
                    }

                    $totalmarketvalue = 0;
                    $dtotalcosts = 0;
                    $dselltotal = 0;
                    $intcost = 0;
                    $totalquanta = 0;
                    
                    $favtotal = 0;
                    $favvols = 0;
                    

                    foreach ($dstocktraded['data'] as $dtradeissuekey => $dtradeissuevalue) {
                        $dmarketvalue = $dtradeissuevalue['price'] * $dtradeissuevalue['qty'];
                        $dfees = getjurfees($dmarketvalue, 'buy');
                        $totalmarketvalue += $dmarketvalue;
                        $dtotalcosts += $dmarketvalue + $dfees;
                        $totalquanta += $dtradeissuevalue['qty'];
                        $intcost = $dtradeissuevalue['price'];

                        $favvols += $dtradeissuevalue['qty'];
                        $favtotal += $dmarketvalue + $dfees;
                        // calculate averate price
                        // echo ($dmarketvalue + $dfees)."~";
                    }

                    $avrprice = $favtotal / $favvols;
                    
                    // echo $dstockinfo->last;

                    $dsellmarket = $dstockinfo->last * $dstocktraded['totalstock'];
                    $dsellfees = getjurfees($dsellmarket, 'sell');
                    $dselltotal += $dsellmarket - $dsellfees;
                    
                    // echo $favtotal;
                    $totalfixmarktcost = $favtotal;

                    // $totalfixmarktcost = $dstocktraded['totalstock'] * $dstocktraded['aveprice'];
                    // $totalfinalcost = $totalfixmarktcost + getjurfees($totalfixmarktcost, 'buy');

                    $totalbuyfee = getjurfees($totalfixmarktcost, 'buy');
                    $totalfinalcost = $totalfixmarktcost - $totalbuyfee;

                    $dprofit = ($dselltotal - $totalfixmarktcost);
                    $profpet = (abs($dprofit) / $totalfixmarktcost) * 100; ?>
                <li>
                    <div style="width:99%;">
                        <div style="width:7%;color: #fffffe;"><a target="_blank" class="stock-label" href="/chart/<?php echo $value; ?>"><?php echo $value; ?></a>	</div>
                        <div style="width:8%" class="table-cell-live"><?php echo number_format($dstocktraded['totalstock'], 0, '.', ','); ?></div>
                        <div style="width:10%" class="table-cell-live">&#8369;<?php echo number_format($avrprice, 3, '.', ','); ?></div>
                        <div style="width:14%" class="table-cell-live">&#8369;<?php echo number_format($totalfixmarktcost, 2, '.', ','); ?></div>
                        <div style="width:14%" class="table-cell-live">&#8369;<?php echo number_format($dselltotal, 2, '.', ','); ?></div>
                        <!-- <div style="width:11%" class="<?php //echo ($dprofit < 0 ? 'dredpart' : 'dgreenpart');?>">&#8369;<?php //echo number_format( $dprofit, 2, '.', ',' );?></div>-->
                        <div style="width:14%" class="<?php echo $dprofit < 0 ? 'dredpart' : 'dgreenpart'; ?> table-cell-live">&#8369;<?php echo number_format($dprofit, 2, '.', ','); ?></div>
                        <!--<div style="width:9%" class="<?php //echo ($dprofit < 0 ? 'dredpart' : 'dgreenpart');?>"><?php //echo ($dprofit < 0 ? '-' : '')?><?php //echo number_format( $profpet, 2, '.', ',' );?>%</div>-->
                            <div style="width:7%" class="<?php echo $dprofit < 0 ? 'dredpart' : 'dgreenpart'; ?> table-cell-live"><?php echo $dprofit < 0 ? '-' : ''; ?><?php echo number_format($profpet, 2, '.', ','); ?>%</div>
                        <div style="width:77px;text-align:center;"><?php /*?>Action<?php */?>
                        <a href="#entertrade_<?php echo $value; ?>" class="smlbtn fancybox-inline green" style="border: 0px;color:#27ae60;" onMouseOver="this.style.color='white'" onMouseOut="this.style.color='#27ae60'">BUY</a>
                        <a href="#selltrade_<?php echo $value; ?>" class="smlbtn fancybox-inline red" style="border: 0px;color:#e64c3c;" onMouseOver="this.style.color='white'" onMouseOut="this.style.color='#e64c3c'">SELL</a>
                        
                            <div class="hideformodal">
                                <div class="selltrade selltrade--align" id="selltrade_<?php echo $value; ?>">

                                    <div class="entr_ttle_bar">
                                        <strong>Sell Trade</strong>
                                        <!-- <span class="datestamp_header"><?php echo date('F j, Y g:i a'); ?></span> -->
                                    </div>

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

                                                <div class="groupinput midd lockedd"><label>Stock</label><input type="text" name="inpt_data_stock"
                                                value="<?php echo $value; ?>" readonly style="text-align: left;"><i class="fa fa-lock" aria-hidden="true"></i></div>

                                                <div class="groupinput midd lockedd"><label>Position</label><input type="text" name="inpt_data_price"
                                                value="<?php echo number_format($dstocktraded['totalstock'], 2, '.', ','); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>


                                            </div>

                                            <div class="entr_col">
                                                <div class="groupinput midd lockedd"><label>Avr. Price</label><input type="text" name="inpt_avr_price_b"
                                                value="&#8369;<?php echo number_format($dstocktraded['aveprice'], 2, '.', ','); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>

                                                <div class="groupinput midd lockedd"><label>Curr. Price</label><input type="text" name="inpt_data_price"
                                                value="&#8369;<?php echo number_format($dstockinfo->last, 2, '.', ','); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>


                                            </div>
                                            <div class="entr_col">
                                                <div class="groupinput midd"><label>Sell Price</label><input step="0.01" name="inpt_data_sellprice" class="no-padding" id="sell_price--input" required></div>

                                                <div class="groupinput midd"><label>Qty.</label><input name="inpt_data_qty"
                                                value="<?php echo get_post_meta(get_the_ID(), 'data_qty', true); ?>" class="no-padding" id="qty_price--input" required></div>
                                                
                                                <div class="groupinput midd inpt_data_price"><label>Sell Date</label><input type="date" name="selldate" class="buySell__date-picker trade_input changeselldate"></div>
                                            </div>

                                            <div class="entr_clear"></div>

                                    </div>
                                    <div>
                                        <div style="height: 36px;">
                                                <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right;margin-right: 10px;">
            
                                            <input type="hidden" value="Log" name="inpt_data_status">
                                            <input type="hidden" value="<?php echo $dstocktraded['aveprice']; ?>" name="inpt_avr_price">
                                            <input type="hidden" value="<?php echo get_the_ID(); ?>" name="inpt_data_postid">
                                            <input type="hidden" name="dtradelogs" value='<?php echo json_encode($dstocktraded['data']); ?>'>
                                            <!-- <input type="hidden" name="selldate" id="selldate"> -->
                                            <input type="submit" id="buy-order--submit" class="confirmtrd green buy-order--submit" value="Confirm Trade">
                                        </div>

                                        </div>

                                    </form>
                                </div>
                                <div class="entertrade buyaddtrade" id="entertrade_<?php echo $value; ?>">
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
                                                <input type="text" name="inpt_data_stock" id="inpt_data_stock" style="margin-left: -4px; text-align: left;" value="<?php echo $value; ?>" readonly>
                                                <i class="fa fa-lock" aria-hidden="true"></i></div>
                                                <div class="groupinput midd lockedd"><label>Buy Power</label>
                                                <input type="text" name="input_buy_product" id="input_buy_product" class="number" style="margin-left: -4px;" value="<?php echo number_format($buypower, 2, '.', ','); ?>" readonly>
                                                <i class="fa fa-lock" aria-hidden="true"></i></div>
                                                <div class="groupinput midd"><label>Buy Price</label><input type="text" name="inpt_data_price" class="textfield-buyprice number" required></div>
                                                <div class="groupinput midd"><label>Quantity</label><input type="text" name="inpt_data_qty" class="textfield-quantity number" required></div>
                                            </div>
                                            <div class="entr_col">
                                                <div class="groupinput midd lockedd"><label>Curr. Price</label><input readonly type="text" name="inpt_data_currprice" value="&#8369;<?php echo number_format($dstockinfo->last, 2, '.', ','); ?>"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                                <div class="groupinput midd lockedd"><label>Change</label><input readonly type="text" name="inpt_data_change" value="<?php echo $dstockinfo->change; ?>%"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                                <div class="groupinput midd lockedd"><label>Open</label><input readonly type="text" name="inpt_data_open" value="&#8369;<?php echo number_format($dstockinfo->open, 2, '.', ','); ?>"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                                <div class="groupinput midd lockedd"><label>Low</label><input readonly type="text" name="inpt_data_low" value="&#8369;<?php echo number_format($dstockinfo->low, 2, '.', ','); ?>"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                                <div class="groupinput midd lockedd"><label>High</label><input readonly type="text" name="inpt_data_high" value="&#8369;<?php echo number_format($dstockinfo->high, 2, '.', ','); ?>"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                            </div>
                                            <div class="entr_col">
                                                <div class="groupinput midd lockedd"><label>Volume</label><input readonly type="text" name="inpt_data_volume" value="<?php echo number_format_short($dstockinfo->volume); ?>"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                                <div class="groupinput midd lockedd"><label>Value</label><input readonly type="text" name="inpt_data_value" value="<?php echo number_format_short($dstockinfo->value); ?>"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                                <div class="groupinput midd lockedd">
                                                    <?php
                                                        $dboard = 0;
                                                        if ($dstockinfo->last >= 0.0001 && $dstockinfo->last <= 0.0099) {
                                                            $dboard = 1000000;
                                                        } elseif ($dstockinfo->last >= 0.01 && $dstockinfo->last <= 0.049) {
                                                            $dboard = 100000;
                                                        } elseif ($dstockinfo->last >= 0.05 && $dstockinfo->last <= 0.495) {
                                                            $dboard = 10000;
                                                        } elseif ($dstockinfo->last >= 0.5 && $dstockinfo->last <= 4.99) {
                                                            $dboard = 1000;
                                                        } elseif ($dstockinfo->last >= 5 && $dstockinfo->last <= 49.95) {
                                                            $dboard = 100;
                                                        } elseif ($dstockinfo->last >= 50 && $dstockinfo->last <= 999.5) {
                                                            $dboard = 10;
                                                        } elseif ($dstockinfo->last >= 1000) {
                                                            $dboard = 5;
                                                        } ?>
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
                                            <!-- <div>this is it</div> -->
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
                            </div>
                        </div>
                        <div style="width:27px; text-align:center">
                            <a href="#livetradenotes_<?php echo $value; ?>" class="smlbtn blue fancybox-inline"><i class="fas fa-clipboard"></i></a>
                        </div>
                        <!-- <input type="hidden" id="deletelog1"> -->
                        <div style="width:25px">
                            <a data-stock="<?php echo $value; ?>" data-totalprice="<?php echo $totalfixmarktcost; ?>" class="deletelive smlbtn-delete" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a>
                        </div>
                        <div style="width:25px; margin-left: 2px;">
                            </div>
                        
                        <div class="hidethis" id="hidelogs">
                            <div class="tradelogbox" id="livetradenotes_<?php echo $value; ?>">
                                <div class="entr_ttle_bar">
                                    <strong><?php echo $value; ?></strong> <span class="datestamp_header"><?php echo $value; ?></span>
                                </div>
                                <hr class="style14 style15" style="width: 93% !important;margin: 5px auto !important;">
                                <div class="trdlgsbox">

                                    <div class="trdleft">
                                        <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Strategy:</strong></span> <span class="modal-notes-result modal-notes-result-toleft"><?php echo $dstocktraded['data'][0]['strategy']; ?></span></div>
                                        <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Trade Plan:</strong></span> <span class="modal-notes-result modal-notes-result-toleft"><?php echo $dstocktraded['data'][0]['tradeplan']; ?></span></div>
                                        <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Emotion:</strong></span> <span class="modal-notes-result modal-notes-result-toleft"><?php echo $dstocktraded['data'][0]['emotion']; ?></span></div>
                                        <!-- <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Performance:</strong></span> <span class="modal-notes-result <?php echo ($dprofit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo number_format($profpet, 2, ".", ","); ?>%</span></div> -->
                                        <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Outcome:</strong></span> <span class="modal-notes-result modal-notes-result-toleft <?php echo ($dprofit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo ($dprofit > 0 ? 'Winning' : 'Loosing'); ?></span></div>
                                    </div>
                                    <div class="trdright darkbgpadd">
                                        <div><strong>Notes:</strong></div>
                                        <div><?php echo $dstocktraded['data'][0]['tradingnotes']; ?></div>
                                    </div>
                                    <div class="trdclr"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- <div style="width:40px; text-align: right;"><?php /*?>Notes<?php */?>
                            <a href="#tradingnotes_JFC" class="smlbtn blue fancybox-inline">
                                <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                            </a>
                        </div>-->
                    </div>
                </li>

                <?php
                }// if
            } // foreach
        } else { // if?>
                    <li style="text-align: center;">
                        <p>No Live Portfolio yet</p>
                    </li>
                <?php
        }
                ?>


    </ul>
</div>
