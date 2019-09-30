<div id="toghandlings" class="add-postsis makcsz" style="display: none;">

<!-- 

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script> -->

<div class="arb_calcbox varcalc">
    <?php

        // function getfees($funmarketval, $funtype)
        // {
        //     // Commissions
        //     $dpartcommission = $funmarketval * 0.0025;
        //     $dcommission = ($dpartcommission > 20 ? $dpartcommission : 20);
        //     // TAX
        //     $dtax = $dcommission * 0.12;
        //     // Transfer Fee
        //     $dtransferfee = $funmarketval * 0.00005;
        //     // SCCP
        //     $dsccp = $funmarketval * 0.0001;
        //     $dsell = $funmarketval * 0.006;

        //     if ($funtype == 'buy') {
        //         $dall = $dcommission + $dtax + $dtransferfee + $dsccp;
        //     } else {
        //         $dall = $dcommission + $dtax + $dtransferfee + $dsccp + $dsell;
        //     }

        //     return $dall;
        // }

        // $getdstocks = get_user_meta(get_current_user_id(), '_trade_list', true);

        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, 'https://arbitrage.ph/charthisto/?g=sampleprice');
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // $gerdqoute = curl_exec($curl);
        // curl_close($curl);

        // $gerdqoute = json_decode($gerdqoute);

        // $dtradeingfo = [];
        // if ($getdstocks && $getdstocks != '') {
        //     foreach ($getdstocks as $dstockskey => $dstocksvalue) {
        //         $dstocktraded = get_user_meta(get_current_user_id(), '_trade_'.$dstocksvalue, true);
        //         if ($dstocktraded && $dstocktraded != '') {
        //             $dstockinfo = $gerdqoute->data->$dstocksvalue;
        //             $marketval = $dstockinfo->last * $dstocktraded['totalstock'];
        //             $dsellfees = getfees($marketval, 'sell');
        //             $dtotal = $marketval - $dsellfees;

        //             $dstocktraded['totalcost'] = $dtotal;
        //             $dstocktraded['stockname'] = $dstocksvalue;
        //             array_push($dtradeingfo, $dstocktraded);
        //         }
        //     }
        // }

        // $duseridmo = get_current_user_id();
        // $dledger = $wpdb->get_results('SELECT * FROM arby_ledger where userid = '.$duseridmo);

        // $buypower = 0;
        // foreach ($dledger as $getbuykey => $getbuyvalue) {
        //     if ($getbuyvalue->trantype == 'deposit' || $getbuyvalue->trantype == 'selling') {
        //         $buypower = $buypower + $getbuyvalue->tranamount;
        //     } else {
        //         $buypower = $buypower - $getbuyvalue->tranamount;
        //     }
        // }

        // $dequityp = $buypower;

        // if ($dtradeingfo) {
        //     foreach ($dtradeingfo as $trinfokey => $trinfovalue) {
        //         $dinforstocl = $trinfovalue['stockname'];
        //         $dstockinfo = $gerdqoute->data->$dinforstocl;
        //         $marketval = $dstockinfo->last * $dstocktraded['totalstock'];
        //         $dsellfees = getfees($marketval, 'sell');
        //         $dtotal = $marketval - $dsellfees;

        //         $dequityp += $dtotal;
        //         $currentalocinfo .= '{"category" : "'.$trinfovalue['stockname'].'", "column-1" : "'.number_format($trinfovalue['totalcost'], 2, '.', '').'"},';
        //         // $currentaloccolor .= '"'.$aloccolors[$trinfokey + 1].'",';
        //     }
        // }

        // $dequityp = 0;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/stocks/history/latest?exchange=PSE' );
        curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:34.92.99.210']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $dwatchinfo = curl_exec($curl);
        curl_close($curl);

        $dwatchinfo = json_decode($dwatchinfo);
        

    ?>

    <div class="bkcalcboxess container-fluid ">
    <span><span class="toborderbotvar"><strong>Value At Risk</strong> (VAR) Calculator</span><i class="fas fa-times toclassclosess"></i></span>
        <div class="row" style="display: flex;">
            
            <div class="col-md-6">
                <div class="halfts">
                    <div class="allcaps varsecttl"><strong>Enter Stock Details</strong></div>

                    

                        <div class="arb_calcbox_left">Stock Name</div>

                        <div class="arb_calcbox_right">

                            <!-- <input name="stockname" id="stockname" type="text" value="BDO" style="width: 85%; text-align: left;"> -->
                            <div class="dselecton">
                                <select name="stockname" id="stockname">
                                    <option value="0">Select a Stock</option>
                                    <?php 
                                        if ($dwatchinfo):
                                        foreach($dwatchinfo->data as $dwkey => $dwvalue): 
                                    ?>
                                        <option value="<?php echo $dwvalue->last; ?>"><?php echo $dwvalue->symbol; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="arb_clear smlspc"></div>

                        

                        <div class="arb_calcbox_left">Current Price</div>

                        <div class="arb_calcbox_right">

                            <input name="currentprice" id="currentprice" type="text" value="0" class="number" style="width: 85%;" tabindex="1" readonly>
                            <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>
                        </div>

                        <div class="arb_clear smlspc"></div>

                        

                        <div class="padbott"></div>

                    

                    <div class="allcaps varsecttl"><strong>Portfolio Planning</strong></div>

                    

                        <div class="arb_calcbox_left">Portfolio Size</div>

                        <div class="arb_calcbox_right">
                            <input name="portsize" id="portsize" class="number" type="text" value="<?php echo number_format($dequityp, 2, '.', ','); ?>" style="width: 85%;" tabindex="2" readonly>
                            <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>
                        </div>

                        <div class="arb_clear smlspc"></div>

                        

                        <div class="arb_calcbox_left">Portfolio Allocation</div>

                        <div class="arb_calcbox_right">

                            <input name="portalloc" id="portalloc" type="text" class="number" placeholder="0" style="width:85%; border-radius: 0 5px 5px 0; margin-right: 0;" tabindex="3">
                            <i class="fas fa-percentage" aria-hidden="true"></i>

                        </div>

                        <div class="arb_clear smlspc"></div>

                        

                        <div class="arb_calcbox_left">Position Size</div>

                        <div class="arb_calcbox_right lockedd">

                            <input class="input-locked number" name="posisize" id="posisize" type="text" value="0" style="width:85%;" disabled>

                            <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>

                            </div>

                        <div class="arb_clear smlspc"></div>

                        

                        <div class="padbott"></div>
                    
                    <div class="allcaps varsecttl"><strong>Position Sizing & RRR</strong></div>

                

                    <div class="arb_calcbox_left">Board Lot</div>

                    <div class="arb_calcbox_right lockedd">

                        <input class="input-locked number" name="boardlot" id="boardlot" type="text" value="0" style="width:85%;" disabled>

                        <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>

                    </div>

                    <div class="arb_clear smlspc"></div>

                    

                    <div class="arb_calcbox_left">No of Shares to Buy</div>

                    <div class="arb_calcbox_right lockedd">

                        <input class="input-locked number" name="noofshare" id="noofshare" type="text" value="0" style="width:85%;" disabled>

                        <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>

                    </div>

                    <div class="arb_clear smlspc"></div>

                    

                    <div class="arb_calcbox_left">Risk to Reward Ratio</div>

                    <div class="arb_calcbox_right lockedd">

                        <input class="input-locked number" name="risktoreward" id="risktoreward" type="text" value="0" style="width:85%;" disabled>

                        <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>

                    </div>

                    <div class="arb_clear smlspc"></div>

                    

                    <div class="padbott"></div>

                    

                    <div style="display:none;">Boardlot (Tmp - dynamic on chart)
[]
                    <input name="inpt_data_boardlot_get_" id="inpt_data_boardlot_get_" type="text" class="number" value="30" style="width:100%;">

                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="halfts">
                    <div class="allcaps varsecttl"><strong>Trade Planning</strong></div>
                    <div class="arb_calcbox_left">Identified Entry Price</div>
                    <div class="arb_calcbox_right"><input name="idenentryprice" id="idenentryprice" type="text" class="number" placeholder="0" style="width:80%;" tabindex="4"></div>
                    <div class="arb_clear smlspc"></div>

                    <div class="arb_calcbox_left">Risk Tolerance</div>
                    <div class="arb_calcbox_right"><input name="risktoler" id="risktoler" type="text" class="number" placeholder="0" style="width:80%;" tabindex="5"><i class="fas fa-percentage" aria-hidden="true"></i></div>
                    <div class="arb_clear smlspc"></div>

                    <div class="arb_calcbox_left">Target Profit</div>
                    <div class="arb_calcbox_right"><input name="targetprof" id="targetprof" type="text" class="number" placeholder="0" style="width:80%;" tabindex="6"><i class="fas fa-percentage" aria-hidden="true"></i></div>


                    <div class="arb_clear smlspc"></div>
                    <div class="arb_calcbox_left">Take Profit Price</div>
                    <div class="arb_calcbox_right lockedd">
                        <input class="input-locked" name="takeprofitprice" id="takeprofitprice" type="text" class="number" value="0" style="width:80%;" disabled>
                        <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>
                    </div>

                    <div class="arb_clear smlspc"></div>

                    <div class="arb_calcbox_left">Stoploss Price</div>
                    <div class="arb_calcbox_right lockedd">
                        <input class="input-locked" name="stoplossprice" id="stoplossprice" type="text" class="number" value="0" style="width:80%;" disabled>
                        <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>
                    </div>

                    <div class="arb_clear smlspc"></div>

                    <div class="arb_calcbox_left">Value at Risk</div>
                    <div class="arb_calcbox_right lockedd">
                        <div class="sublbl before">₱</div><input class="input-locked number" name="valueatrisk" id="valueatrisk" type="text" value="0" style="width:66%;" disabled>
                        <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>
                        </div>

                    <div class="arb_clear smlspc"></div>

                    <div class="arb_calcbox_left">Upside</div>
                    <div class="arb_calcbox_right lockedd">
                        <div class="sublbl before" >₱</div><input class="input-locked number" name="upside" id="upside" type="text" value="0" style="width:66%;" disabled>
                        <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>
                    </div>

                    <div class="arb_clear smlspc"></div>
                    <div class="padbott"></div>
                </div>  
            </div>
        </div>
    </div>
</div>


</div>