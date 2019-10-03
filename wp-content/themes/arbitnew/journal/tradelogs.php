
    <div class="tradelogsbox">
        <div class="box-portlet">

            <div class="box-portlet-header" style="padding-bottom: 20px;">
            <span class="title_logss">Tradelogs</span>
                <div class="headright" style="display:none;">
                    <form action="" method="get" id="ptchangenum">
                        <input type="number" id="ptnum" name="ptnum">
                        <input type="hidden" name="pt" value="1">
                        <a href="#" class="dmoveto">Go</a>
                    </form>
                </div>

                <!-- <div class="search-tlogs">
                    <form action="" method="get">
                            <input type="text" name="searchlogs" id="searchlogs" class=" search-logs" style="padding: 0px 10px; width: 150px;font-size: 12px;" placeholder="Search logs..." >
                    </form>
                </div> -->
                <div class="tradelogsbutton">
                    <div class="dbuttonrecord">
                        <form action="" method="post" class="recordform">
                            <input type="hidden" name="recorddata" value="record">
                            <input type="submit" name="record" value="Record" class="record-data-btn recorddata">
                        </form>
                    </div>
                </div>
            </div>
            <div class="box-portlet-content">
                <div class="stats-info">
                    <div class="dstatstrade overridewidth dstatstrade1">
                        <ul>
                            <li class="headerpart headerpart-tradelogs">
                                <div style="width:100%;">
                                    <div style="width:45px">Stocks</div>                                                                                	
                                    <div style="width:65px">Date</div>
                                    <div style="width:55px" class="table-title-live">Volume</div>
                                    <div style="width:65px" class="table-title-live">Ave. Price</div>
                                    <div style="width:95px" class="table-title-live">Buy Value</div>
                                    <div style="width:65px" class="table-title-live">Sell Price</div>
                                    <div style="width:88px" class="table-title-live">Sell Value</div>
                                    <div style="width:80px" class="table-title-live">Profit/Loss</div>
                                    <div style="width:65px" class="table-title-live">%</div>
                                    <div style="width:65px; text-align:center">Action</div>
                                </div>
                            </li>
                            
                            <?php
                            $trtotals = 0;
                            if(!empty($ismytrades)):
                    
                                foreach ($ismytrades as $key => $value) {
                                    $marketvals = $value->tlvolume * $value->tlaverageprice;
                                    $selltotal = $value->tlvolume * $value->tlsellprice;
                                    $sellvalue = $selltotal - getjurfees($selltotal, 'sell');

                                    $profit = $sellvalue - $marketvals;
                                    $profitperc = ($profit / $marketvals) * 100;

                                    $tliswin = ($profit > 0 ? 'Win' : ($profit < 0 ? 'Loss' : 'Break Even'));

                                    $trtotals += $profit;
                                    ?>
                                    <li class="<?php echo $value->tlid; ?> dloglist">
                                        <div style="width:99%;">
                                            <div style="width:45px" class="tdata" id="tdata<?php echo $value->tlid; ?>"><a href="/chart/<?php echo $value->isstock; ?>" class="stock-label"><?php echo $value->isstock; ?></a></div>
                                            <div style="width:65px" class="tdate" id="tdate<?php echo $value->tlid; ?>"><?php echo $value->tldate; ?></div>
                                            <div style="width:55px" class="table-cell-live" id="tquantity<?php echo $value->tlid; ?>"><?php echo $value->tlvolume; ?></div>
                                            <div style="width:65px" class="table-cell-live" id="tavprice<?php echo $value->tlid; ?>">₱<?php echo number_format($value->tlaverageprice, 3, ".", ","); ?></div>
                                            <div style="width:95px" class="table-cell-live" id="tbvalue<?php echo $value->tlid; ?>">₱<?php echo number_format($marketvals, 2, ".", ","); ?></div>
                                            <div style="width:65px" class="table-cell-live" id="tsellprice<?php echo $value->tlid; ?>">₱<?php echo number_format($value->tlsellprice, 2, ".", ","); ?></div>
                                            <div style="width:88px" class="table-cell-live" id="tsellvalue<?php echo $value->tlid; ?>">₱<?php echo number_format($sellvalue, 2, ".", ","); ?></div>
                                            <div style="width:80px" class="<?php echo ($profit > 0 ? 'txtgreen' : 'txtred'); ?> table-cell-live" id="tploss1">₱<?php echo number_format($profit, 2, ".", ","); ?></div>
                                            <div style="width:56px" class="<?php echo ($profit > 0 ? 'txtgreen' : 'txtred'); ?> table-cell-live" id="tpercent1"><?php echo number_format($profitperc, 2, ".", ","); ?>%</div>
                                            <div style="width:27px; text-align:center">
                                                <a href="#tradelognotes_<?php echo $value->tlid; ?>" class="smlbtn blue fancybox-inline"><i class="fas fa-clipboard"></i></a>
                                            </div>
                                            <input type="hidden" id="deletelog1" value="4394">
                                            <div style="width:25px">
                                                <a class="deletelog smlbtn-delete" data-istl="<?php echo $value->tlid; ?>" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a>
                                            </div>
                                            <div style="width:25px; margin-left: 2px;">
                                                <a href="#editlognotes_<?php echo $value->tlid; ?>" class="editlog smlbtn-edit fancybox-inline" style="cursor:pointer;text-align:center"><i class="fas fa-edit"></i></a>
                                            </div>
                                        </div>
                                        <div class="hidethis" id="hidelogs">
                                            <div class="tradelogbox" id="tradelognotes_<?php echo $value->tlid; ?>">
                                                <div class="entr_ttle_bar">
                                                    <strong><?php echo $value->isstock; ?></strong> <span class="datestamp_header"><?php echo $value->tldate; ?></span>
                                                </div>
                                                <hr class="style14 style15" style="width: 93% !important;margin: 5px auto !important;">
                                                <div class="trdlgsbox">

                                                    <div class="trdleft">
                                                        <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Strategy:</strong></span> <span class="modal-notes-result modal-notes-result-toleft"><?php echo $value->tlstrats; ?></span></div>
                                                        <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Trade Plan:</strong></span> <span class="modal-notes-result modal-notes-result-toleft"><?php echo $value->tltradeplans; ?></span></div>
                                                        <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Emotion:</strong></span> <span class="modal-notes-result modal-notes-result-toleft"><?php echo $value->tlemotions; ?></span></div>
                                                        <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Performance:</strong></span> <span class="modal-notes-result <?php echo ($profit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo number_format($profitperc, 2, ".", ","); ?>%</span></div>
                                                        <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Outcome:</strong></span> <span class="modal-notes-result modal-notes-result-toleft <?php echo ($profit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo $tliswin; ?></span></div>
                                                    </div>
                                                    <div class="trdright darkbgpadd">
                                                        <div><strong>Notes:</strong></div>
                                                        <div><?php echo $value->tlnotes; ?></div>
                                                    </div>
                                                    <div class="trdclr"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hidethis" id="hidelogs1">
                                                
                                                <div class="tradelogbox" id="editlognotes_<?php echo $value->tlid; ?>">
                                                    <div class="entr_ttle_bar">
                                                    <strong><?php echo $value->isstock; ?></strong> <span class="datestamp_header"><?php echo $value->tldate; ?></span>
                                                    </div>
                                                    <hr class="style14 style15" style="width: 93% !important;margin: 5px auto !important;">

                                                    
                                                    <div class="trdlgsbox">
                                                        <!-- <form method="post" class="edittlogs"> -->
                                                        <div class="trdleft">
                                                            <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Strategy:</strong></span> 
                                                                    <select class="rnd selecteditlog strat_<?php echo $value->tlid; ?>" name="data_strategy" id="strat">
                                                                        <option  <?php if($value->tlstrats == 'Bottom Picking') echo "selected"; ?> value="Bottom Picking">Bottom Picking</option>
                                                                        <option <?php if($value->tlstrats == 'Breakout Play') echo "selected"; ?> value="Breakout Play">Breakout Play</option>
                                                                        <option <?php if($value->tlstrats == 'Trend Following') echo "selected"; ?> value="Trend Following">Trend Following</option>
                                                                    </select>
                                                                </div>
                                                            <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Trade Plan:</strong></span>
                                                                <select class="rnd selecteditlog tplan_<?php echo $value->tlid; ?>" name="data_tradeplan" id="">
                                                                        <option <?php if($value->tltradeplans == 'Day Trade') echo "selected"; ?> value="Day Trade">Day Trade</option>
                                                                        <option <?php if($value->tltradeplans == 'Swing Trade') echo "selected"; ?> value="Swing Trade">Swing Trade</option>
                                                                        <option <?php if($value->tltradeplans == 'Investment') echo "selected"; ?> value="Investment">Investment</option>
                                                                </select>
                                                            </div>
                                                            <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Emotion:</strong></span> 
                                                                <select class="rnd selecteditlog emot_<?php echo $value->tlid; ?>" name="data_emotion" id="">
                                                                        <option  <?php if($value->tlemotions == 'Neutral') echo "selected"; ?> value="Neutral">Neutral</option>
                                                                        <option <?php if($value->tlemotions == 'Greedy') echo "selected"; ?> value="Greedy">Greedy</option>
                                                                        <option <?php if($value->tlemotions == 'Fearful') echo "selected"; ?> value="Fearful">Fearful</option>
                                                                </select>
                                                            </div>
                                                            <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Performance:</strong></span> <span class="modal-notes-result <?php echo ($profit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo number_format($profitperc, 2, ".", ","); ?>%</span></div>
                                                            <div class="onelnetrd"><span class="modal-notes-ftitle"><strong>Outcome:</strong></span> <span class="modal-notes-result modal-notes-result-toleft <?php echo ($profit > 0 ? 'txtgreen' : 'txtred'); ?>"><?php echo $tliswin; ?></span></div>
                                                        </div>
                                                        <div class="trdright darkbgpadd">
                                                            <div><strong>Notes:</strong></div>
                                                            <div>
                                                                <textarea rows="3" name="tlnotes" class="tnotes_<?php echo $value->tlid; ?>" style="width: 313px; border-radius: 5px; background: #4e6a85;border: 0; color: #a1adb5;"><?php echo $value->tlnotes; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="trdleft">
                                                            <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right;margin-right: 10px; margin-top: 10px;">
                                                            <input type="hidden" value="Edit" name="inpt_data_status">
                                                            <input type="hidden" name="log_id" value="<?php echo $value->tlid; ?>">
                                                            <input type="hidden" name="logs" value="">
                                                            <div class="onelnetrd" style="margin-top: 9px;"> 
                                                                <button class="editmenow arbitrage-button arbitrage-button--primary" name="editbutton" data-istl="<?php echo $value->tlid; ?>" style="float: right;">Update</button>
                                                            </div>
                                                        </div>
                                                        <!--</form>-->
                                                        <div class="trdclr"></div>
                                                        </div>
                                                    
                                                </div>
                                            
                                        </div>

                                        <form method="post" class="edittlogs_<?php echo $value->tlid; ?>">
                                                <input type="hidden" name="to_edit" id="tl_id" value="<?php echo $value->tlid; ?>">
                                                <input type="hidden" name="strategy_<?php echo $value->tlid; ?>" id="strategy" value="">
                                                <input type="hidden" name="trade_plan_<?php echo $value->tlid; ?>" id="trade_plan" value="">
                                                <input type="hidden" name="emotion_<?php echo $value->tlid; ?>" id="emotion" value="">
                                                <input type="hidden" name="tlnotes_<?php echo $value->tlid; ?>" id="tlnotes" value="">
                                        </form>

                                    </li>

                            <?php 	 }
                            endif; 

                                // $paginate = (isset($_GET['ptnum']) && @$_GET['ptnum'] != "" ? 1 : $_GET['ptnum']);
                                // echo  $_GET['ptnum'];
                                $paginate = 20;
                                $count = 1;
                                $dpage = 1;
                                $current = (isset($_GET['pt']) ? $_GET['pt'] : 1);
                                $dlisttrade = [];
                                
                                if ($author_posts->have_posts()) {
                                    while ($author_posts->have_posts()) {
                                        $author_posts->the_post();
                                        $tradelogid = get_the_ID();
                                        // $dlisttrade[$dpage]
                                        if ($count == $paginate) {
                                            $count = 1;
                                            ++$dpage;
                                        } else {
                                            ++$count;
                                        }
                                    }
                                    wp_reset_postdata();
                                }

                            ?>
                        <input type="hidden" name="hsearchlogs" value="<?php echo $tnum; ?>" >
                        </ul>
                    </div>
                    <div class="deleteform">
                        <form class="deleteformitem" action="" method="post">
                            <input type="hidden" value="" name="todelete" id="todelete">
                        </form>
                    </div>
                    <div class="pagination">
                        <div class="pginner">
                            <ul>
                                <?php for ($i = 1; $i <= $dpage; ++$i) {
                                    ?>
                                    <li><a href="/journal/?pt=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php
                                } ?>
                            </ul>
                        </div>
                    </div>	
                </div>
            </div>

        </div>
    </div>
    <br class="clear">

    <div class="totalpl">
            <p>Total Profit/Loss as of <?php
            echo date('F j, Y'); ?>: <span class="totalplscore <?php echo $trtotals > 0 ? 'txtgreen' : 'txtred'; ?>">₱<?php echo number_format($trtotals, 2, '.', ','); ?></span></p>
    </div>

    <!--<div class="adsbygoogle">
        <div class="box-portlet">

            <div class="box-portlet-content">
                <small>ADVERTISEMENT</small>
                <div class="adscontainer">
                    <img src="<?php // echo get_home_url(); ?>/ads/addsample728x90_<?php //echo rand(1, 3); ?>.png">
                </div>
            </div>
        </div>
    </div>-->
    <br class="clear">