<br class="clear">
    <div class="row">
        <div class="col-md-7" style="padding-right: 0;">
            <div class="box-portlet">
                <div class="box-portlet-header">
                    Portfolio Snapshot
                </div>
                <div class="box-portlet-content" style="padding-bottom: 0;">
                    <div class="row">
                        <div class="col-md-6" style="padding-right:0;">
                            <div class="inner-portlet">
                                <div class="inner-portlet-content">

                                    <div class="stats-info">
                                        <div class="dstatstrade">
                                            <ul>
                                                <li class="headerpart">
                                                    <div class="widthfull">Trading Results</div>
                                                </li>
                                                <li>
                                                    <div class="width60"><span class="bulletclrd clrg1"></span>Capital</div>
                                                    <div class="width35 addcapital"></div>
                                                </li>
                                                <li>
                                                    <div class="width60"><span class="bulletclrd clrg2"></span>Year to Date P/L</div>
                                                    <div class="width35 addyearpl"></div>
                                                </li>
                                                <li>
                                                    <div class="width60"><span class="bulletclrd clrg3"></span>Portfolio YTD %</div>
                                                    <div class="width35 addyearplperc"></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="inner-portlet">

                                    <div class="stats-info">
                                        <div class="dstatstrade">
                                            <ul>
                                                <li class="headerpart">
                                                    <div class="widthfull">Fund Transfers</div>
                                                </li>
                                                <li>
                                                    <div class="width60"><span class="bulletclrd clrb1"></span>Deposits</div>
                                                    <div class="width35 adddeposit"></div>
                                                </li>
                                                <li>
                                                    <div class="width60"><span class="bulletclrd clrb2"></span>Withdrawals</div>
                                                    <div class="width35 addwidthraw"></div>
                                                </li>
                                                <li>
                                                    <div class="width60"><span class="bulletclrd clrb3"></span>Equity</div>
                                                    <div class="width35 adddashequity"></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <br class="clear">
                </div>
            </div><br class="clear">
            <div class="box-portlet">
                <div class="box-portlet-header">
                    Monthly Performance
                </div>
                <div class="box-portlet-content" style="padding-right: 0;padding-bottom: 0;">
                    <div class="col-md-12" style="padding: 0px;">
                        <div id="chartdiv2"></div>
                    </div>
                    <br class="clear">
                </div>

            </div>
        </div>
        <div class="col-md-5">
            <div class="box-portlet" style="height:202px;">
                <div class="box-portlet-header" style="text-align:center;">
                    Current Allocation
                </div>
                <div class="box-portlet-content" style="padding:4px 14px 0">
                    <div class="row">
                        <div id="chartdiv1"></div>
                        <br class="clear">
                    </div>
                </div>

            </div><br class="clear">

            <div class="box-portlet">
                <div class="box-portlet-header" style="text-align:center;">
                    Trade Statistics
                    <?php
                        if($isjounalempty){
                            $iswin = 100;
                            $isloss = 60;
                            $totaltrade = 160;
                        }
                    ?>
                </div>
                <div class="chartarea col-md-12" style="margin-bottom: -3px;">
                    <div id="chartdiv4a"></div>
                </div>
                <div class="stats-info" style="padding: 0">

                    <div class="row" style="padding: 11px 12px 7px 12px;">
                        <div class="dstatstrade eqpad col-md-6" style="padding-right: 3px;">
                            <ul style="margin-bottom:0 !important;">

                                <li>
                                    <div class="width60"><span class="bulletclrd clrg1"></span> Wins</div>
                                    <div class="width35"><?php echo $iswin; ?></div>
                                </li>
                                <li>
                                    <div class="width60"><span class="bulletclrd clrr1"></span> Losses</div>
                                    <div class="width35"><?php echo $isloss; ?></div>
                                </li>

                            </ul>
                        </div>
                        <div class="dstatstrade eqpad col-md-6" style="padding-left: 3px;">
                            <ul style="margin-bottom:0 !important;">
                                <?php $totaltrade = $iswin + $isloss; ?>
                                <li>
                                    <div class="width60">Total Trades</div>
                                    <div class="width35"><?php echo $totaltrade; ?></div>
                                </li>
                                <li>
                                    <div class="width60"><strong>Win Rate</strong></div>
                                    <div class="width35"><strong><?php
                                        if ($iswin > 0) {
                                            echo number_format(($iswin / $totaltrade) * 100, 2, '.', ',');
                                        } else {
                                            echo '0.00';
                                        }
                                        ?>%</strong></div>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <br class="clear">

    <!-- BOF Strategy Statistics -->
    <!-- EOF Strategy Statistics -->
    <div class="row">
        <div class="col-md-12">
            <div class="box-portlet">
                <style>.dstatstrade ul li div {width: 16%;}</style>

                <div style="padding:5px 15px;" class="col-md-8">
                    <div class="col-md-12" style="padding:0 10px 0 0">

                        <div class="box-portlet-header" style="padding: 13px 0 17px 2px;">
                            Strategy Statistics
                        </div>
                        <?php
                            if($isjounalempty){
                                $stratsinfo = [
                                    'Bottom Picking' => [
                                        'trwin' => 15,
                                        'trloss' => 4,
                                        'total_trades' => 19,
                                    ],
                                    'Breakout Play' => [
                                        'trwin' => 9,
                                        'trloss' => 1,
                                        'total_trades' => 10,
                                    ],
                                    'Trend Following' => [
                                        'trwin' => 2,
                                        'trloss' => 8,
                                        'total_trades' => 10,
                                    ],
                                ];
                            }
                        ?>
                        <div class="stats-info">
                            <div class="dstatstrade">
                                <ul>
                                    <li class="headerpart">
                                        <div style="width:100%">
                                            <div style="width:150px;text-align:left;">Strategy</div>
                                            <div>Trades</div>
                                            <div>Wins</div>
                                            <div>Loses</div>
                                            <div>Win Rate</div>
                                        </div>
                                    </li>
                                    <?php
                                    foreach ($strats as $statskey => $statsvalue) {
                                        ?>
                                        <li>
                                            <div style="width:99%">
                                                <div style="width:150px;"><?php echo $statskey; ?></div>
                                                <!-- <span class="legend_circ"></span> -->
                                                <div style="text-align: center;"><?php echo $statsvalue['total_trades']; ?></div>
                                                <div style="text-align: center;"><?php echo $statsvalue['trwin']; ?></div>
                                                <div style="text-align: center;"><?php echo $statsvalue['trloss']; ?></div>
                                                <div style="text-align: center;"><?php echo ($statsvalue['trwin'] > 0 ? number_format(($statsvalue['trwin'] / ($statsvalue['trwin'] + $statsvalue['trloss'])) * 100, 2) : "0.0"); ?>%</div>
                                            </div>
                                        </li>
                                    <?php
                                    } ?>

                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12" style="padding: 0 12px 0 10px;">
                        <div id="chartdiv5" style="padding-left: 0;"></div>
                    </div>
                    <br class="clear">
                </div>
                <div class="col-md-4" style="padding-left:0;">
                        <div style="text-align:center;text-transform:uppercase;padding: 45px 0 0;margin-bottom: -6px;">
                            Win Allocations
                        </div>
                        <div class="chartarea">
                            <div id="chartdiv4b"></div>
                        </div>

                        <div class="dstatstrade eqpad">
                            <ul>

                                <li>
                                    <div class="width48"><span class="bulletclrd clrg1"></span> Winning Strategy</div>
                                    <div class="width48" style="text-align: right;"><?php echo $winningstarts; ?></div>
                                </li>
                                <li>
                                    <div class="width48"><span class="bulletclrd clrr1"></span> Losing Strategy</div>
                                    <div class="width48" style="text-align: right;"><?php echo $lossingstrats; ?></div>
                                </li>

                            </ul>
                        </div>

                    </div>
                
            </div>
        </div>
        <br class="clear">
    </div>
    <br class="clear">
    <!-- BoF Trade Statistics -->
    <!-- EoF Trade Statistics -->
    <div class="row">

        <div class="col-md-12">
            <div class="box-portlet">
                <div class="topstockgauge">
                    <div class="col-md-4" style="padding:20px 0 0">
                        <div style="text-align:center;padding-bottom: 5px;text-transform: uppercase;">Winners</div>
                        <div id="topstockswinners"></div>
                    </div>
                    <div class="col-md-4" style="padding-bottom: 15px;">
                        <div class="box-portlet-header" style="text-align:center;">
                            Top Stocks
                        </div>
                        <div class="inner-portlet" style="margin-top:20px;">
                                <div class="stats-info">
                                    <div class="dstatstrade">
                                        <ul style="overflow: hidden;border-radius: 5px;">
                                            <?php
                                            
                                            if($isjounalempty){
                                                $winningstocks = [
                                                    0 => [
                                                        'stock' => 'Stock 3',
                                                        'profit' => 123435
                                                    ],
                                                    1 => [
                                                        'stock' => 'Stock 2',
                                                        'profit' => 12343
                                                    ],
                                                    2 => [
                                                        'stock' => 'Stock 1',
                                                        'profit' => 1234
                                                    ],
                                                ];

                                                $loosingstocks = [
                                                    0 => [
                                                        'stock' => 'Stock 1',
                                                        'profit' => -1234
                                                    ],
                                                    1 => [
                                                        'stock' => 'Stock 2',
                                                        'profit' => -12343
                                                    ],
                                                    2 => [
                                                        'stock' => 'Stock 3',
                                                        'profit' => -123435
                                                    ],
                                                ];
                                            }

                                            foreach ($winningstocks as $key => $value) {
                                                $dinss = '<li style="background-color: '.($key == 0 ? '#0d785a' : ($key == 1 ? '#06af68' : ($key == 2 ? '#00e676' : ($key >= 3 ? '' : '#00e676')))).';display:'.($key >= 3 ? 'none' : '').';color: #b1e8ce;border: none;">';
                                                $dinss .= '<div class="width60">'. $value['stocks'] .'</div>';
                                                $dinss .= '<div class="width35">&#8369; '.number_format($value['profit'], 2, '.', ',').'</div>';
                                                $dinss .= '</li>';
                                                echo $dinss;
                                                if($key == 3){
                                                    break;
                                                }
                                            }

                                            foreach ($loosingstocks as $key => $value) {
                                                $dinss = '<li style="background-color: '.($key == 0 ? '#b91e45' : ($key == 1 ? '#732546' : ($key == 2 ? '#442946' : ($key >= 3 ? '' : '#b91e45')))).';display:'.($key >= 3 ? 'none' : '').';color: #132941;border: none;">';
                                                $dinss .= '<div class="width60">'.$value['stocks'].'</div>';
                                                $dinss .= '<div class="width35">&#8369; '.number_format($value['profit'], 2, '.', ',').'</div>';
                                                $dinss .= '</li>';
                                                echo $dinss;
                                                if($key == 3){
                                                    break;
                                                }
                                            }
                                                ?>
                                        </ul>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="padding:20px 0 0">
                        <div style="text-align:center;padding-bottom: 5px;text-transform: uppercase;">Losers</div>
                        <div id="topstocksLosers"></div>
                    </div>

                </div>

            </div>
        </div>

        <br class="clear">

    </div>
    <br class="clear">
    <div class="row">

        <div class="col-md-12">
            <div class="box-portlet">

                <div class="box-portlet-header" style="padding-bottom:13px;">
                    Emotional Statistics
                </div>
                <?php
                    if($isjounalempty){
                        $emotioninfo = [
                            'Neutral' => [
                                'emotion' => 'Neutral',
                                'trwin' => 3,
                                'trloss' => 4,
                                'total_trades' => 7
                            ],
                            'Greedy' => [
                                'emotion' => 'Greedy',
                                'trwin' => 2,
                                'trloss' => 3,
                                'total_trades' => 5
                            ],
                            'Fearful' => [
                                'emotion' => 'Fearful',
                                'trwin' => 6,
                                'trloss' => 1,
                                'total_trades' => 7
                            ],
                        ];
                    }
                ?>
                <div class="col-md-6" style="padding-right:0;">

                    <div class="chartarea">
                        <div id="chartdiv11"></div>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="stats-info">
                        <div class="dstatstrade dstatsemo">
                            <ul>
                                <li class="headerpart">
                                    <div>Emotions</div>
                                    <div>Trades</div>
                                    <div>Wins</div>
                                    <div>Losses</div>
                                    <div>Win Rate</div>
                                </li>
                                <?php //$demotsonchart = ''; ?>
                                <?php foreach ($tremo as $emtkey => $emtvalue) { ?>
                                    <li>
                                        <div><?php  echo $emtkey; ?></div>
                                        <div><?php  echo $emtvalue['total_trades']; ?></div>
                                        <div><?php  echo $emtvalue['trwin']; ?></div>
                                        <div><?php  echo $emtvalue['trloss']; ?></div>
                                        <div><?php  echo ($emtvalue['trwin'] > 0 ? number_format(($emtvalue['trwin'] / $emtvalue['total_trades']) * 100, 2, '.', '') : "0"); ?>%</div>
                                    </li>
                                <?php
                                } ?>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <br class="clear">

    </div>
    <br class="clear">

    <!-- BOF expenses report -->
    <!-- EOF expenses report -->
    <div class="expence-report">
            <div class="box-portlet">
                <div class="box-portlet-header">
                    Expense Report
                </div>
                <div class="box-portlet-content" style="padding-top: 0; padding-left:0; padding-bottom:0;">
                    <div class="col-md-4" style="padding-right:0;">
                            <?php
                                if($isjounalempty){
                                    $fees = [
                                        'commissions' => 111.2418925,
                                        'vat' => 13.3490271,
                                        'transfer' => 0.87229045,
                                        'sccp' => 1.7445809,
                                        'sell' => 104.674854,
                                    ];
                                }
                            ?>
                            <div class="inner-portlet" style="margin-top:20px;">
                                    <div class="stats-info">
                                        <div class="dstatstrade">
                                            <ul>
                                                <li class="headerpart">
                                                    <div class="widthfull">Breakdown Expenses</div>
                                                </li>
                                                <li>
                                                    <div class="width60">Commissions</div>
                                                    <div class="width35">&#8369;<?php echo number_format($fees['commissions'], 2, '.', ','); ?></div>
                                                </li>
                                                <li>
                                                    <div class="width60">Value Added Tax</div>
                                                    <div class="width35">&#8369;<?php echo number_format($fees['vat'], 2, '.', ','); ?></div>
                                                </li>
                                                <li>
                                                    <div class="width60">Transfer Fee</div>
                                                    <div class="width35">&#8369;<?php echo number_format($fees['transfer'], 2, '.', ','); ?></div>
                                                </li>
                                                <li>
                                                    <div class="width60">SCCP</div>
                                                    <div class="width35">&#8369;<?php echo number_format($fees['sccp'], 2, '.', ','); ?></div>
                                                </li>
                                                <li>
                                                    <div class="width60">Sales Tax</div>
                                                    <div class="width35">&#8369;<?php echo number_format($fees['sell'], 2, '.', ','); ?></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                            </div>

                    </div>
                    <div class="col-md-8" style="padding-right:0;">
                        <div id="chartdiv6"></div>
                    </div>
                    <br class="clear">
                </div>


            </div>
    </div>
    <br class="clear">
    <div class="row">
        <div class="col-md-6" style="padding-right: 0;">
            <div class="box-portlet">
                <div class="box-portlet-header">
                    Buy Volume<br />
                    <!--<span>For the last 20 trading days</span>-->
                    <span>Last 20 Trades</span>
                </div>
                <div class="box-portlet-content" style="padding-right:0;">
                    <div id="chartdiv7"></div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="box-portlet">
                <div class="box-portlet-header">
                    Buy Value<br />
                    <!--<span>For the last 20 trading days</span>-->
                    <span>Last 20 Trades</span>
                </div>
                <div class="box-portlet-content" style="padding-right:0;">
                    <div id="chartdiv8"></div>
                </div>

            </div>
        </div>
    </div>
    <br class="clear">
    <div class="row">
        <div class="col-md-5" style="padding-right: 0;">
            <div class="box-portlet">
                <div class="box-portlet-header">
                    Performance <br>
                    <span>By day of the week</span>
                </div>
                <div class="box-portlet-content" style="padding-right:0;">
                    <div id="chartdiv9"></div>
                </div>

            </div>
        </div>
        <div class="col-md-7">
            <div class="box-portlet">
                <div class="box-portlet-header">
                    Gross Profit & Loss<br />
                    <!--<span>Last 20 trading days</span>-->
                    <span>Last 20 Trades</span>
                </div>
                <div class="box-portlet-content" style="padding-right:0;">
                    <div id="chartdiv10"></div>
                </div>

            </div>
        </div>
    </div>