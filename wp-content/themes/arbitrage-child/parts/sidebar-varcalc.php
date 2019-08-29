<div id="toghandlings" class="add-postsis makcsz" style="display: none;">



<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<style type="text/css">

/* Chart Default - do not copy */

.lockedd {

    position: relative;

}

/* .lockedd i.fa.fa-lock {

    top: 7px;

    position: absolute;

    right: 1px;

    font-size: 14px;

    color: #ecf0f1; */

}



/* Default Calc Styles - do not copy */

.arb_calcbox input[type="number"] {

	border:0;

	border-radius: 4px;

	padding: 5px 6px;

	background: #11273e !important;

    border: 1px solid #4e6a85;

	color: #ecf0f1;

    font-family: 'Roboto', sans-serif;

	display:block;

	width:90%;

	margin-top:3px;

}

.arb_calcbox h3 {

    font-size: 17px;

    padding-bottom: 0;

	font-weight:normal;

}

.arb_calcbox h3 strong {

    text-transform: uppercase;

}

.arb_calcbox h4 {

    font-size: 15px;

    padding-bottom: 0;

	font-weight:normal;

}

.arb_calcbox h4 strong {

    text-transform: uppercase;

}

.arb_calcbox small {

	font-size:11px;

	display:block;

}

.arb_clear {clear:both;}

.arb_calcbox_left {

	float:left;

	width:60%;

}

.arb_calcbox_right {

	float:right;

	width:40%;

}

.padbott {

	padding-bottom:5px;

}

.arb_buyfees, .arb_sellfees {position: relative;}

.feedetails_sell, .feedetails_buy {display:none;}

.feedetails_sell,

.feedetails_buy {

    position: absolute;

    left: -1px;

    top: 0;

    padding: 12px;

    border-radius: 5px;

    background-color: #2b3d4f;

	width:90%;

}

.smlinline {

    display: inline-block !important;

    vertical-align: text-top;

	cursor:pointer;

}

.clcbxttl {

    border-bottom: 1px solid #4e6a85;

    margin-top: -5px;

    margin-bottom: 5px;

    padding-bottom: 5px;

}

.arb_dvdr {

    border-bottom: 1px solid #4e6a85;

    width: 90%;

    margin: 8px 0 10px;

}

.arb_breakeven {

    width: 100%;

    margin: 4px 0 0;

    border-radius: 4px;

    overflow: hidden;

}

.arbredtxt {color: #e64c3c; }

.arbgreentxt {color: #25ae5f; }

.alleft {float:left}

.alright {float:right}

.arbleveling {

    padding: 3px 7px 3px;

    line-height: 20px;

}



/* VAR Calc Style */

.arb_calcbox .arb_calcbox_left {

    line-height: 30px;

    background-color: #34495e;

    padding: 0 0 0 10px;

    border-radius: 5px 0 0 5px;

}

.arb_calcbox input[type="number"] {

	margin-top:0;

	border-radius: 0 5px 5px 0;

	border: none;

	display:inline-block;

	padding: 5px 6px;

    line-height: 20px;

    background: #4e6a85 !important;

}

.arb_calcbox input[type="text"] {

	border:0;

	border-radius: 4px;

	padding: 5px 6px;

    line-height: 20px;

    background-color: #4e6a85;

    border: none;

	color: #ecf0f1;

    font-family: 'Roboto', sans-serif;

	display:inline-block;

	margin-top:0;

	border-radius: 0 5px 5px 0;

}

.sublbl.after {

	display:inline-block;

	line-height: 30px;

	padding:0 5px;

	border-radius: 0 5px 5px 0;

	background-color: #11273e;

}

.sublbl.before {

	display:inline-block;

	line-height: 30px;

	padding:0 0 0 7px;

	border-radius:0;

	background-color: #4e6a85;

}

.arb_calcbox .padbott {

	padding-bottom:5px;

}

.arb_calcbox .allcaps {

	text-transform: uppercase;

}

.smlspc {

	height: 4px;

}

.varsecttl {

	margin-bottom:8px;

}

.lockedd input {

	cursor:not-allowed;

}
.lockedd i.fa.fa-lock.lock__icon--position {
    right: 1px;
}

.number{
    font-size: 13px;
    text-align: right;
}

select#stockname {
    background: #4e6a85;
    color: #fff;
    height: 30px;
    border: 0 none;
    padding: 10px;
    display: inline-block;
    border-radius: 0 !important;
}

</style>

<div class="arb_calcbox varcalc">

<!-- <div class="bkcalcboxess">

    <span><span class="toborderbotvar"><strong>Value At Risk</strong> (VAR) Calculator</span><i class="fas fa-times toclassclosess"></i></span>
    
    <div class="halfts" style="width: 50%">
        <div class="allcaps varsecttl"><strong>Enter Stock Details</strong></div>

        

            <div class="arb_calcbox_left">Stock Name</div>

            <div class="arb_calcbox_right">

                <input name="stockname" id="stockname" type="text" value="BDO" style="width:95%;">

            </div>

            <div class="arb_clear smlspc"></div>

            

            <div class="arb_calcbox_left">Current Price</div>

            <div class="arb_calcbox_right">

                <input name="currentprice" id="currentprice" type="number" value="0" style="width:95%;" tabindex="1">

            </div>

            <div class="arb_clear smlspc"></div>

            

            <div class="padbott"></div>

        

        <div class="allcaps varsecttl"><strong>Portfolio Planning</strong></div>

        

            <div class="arb_calcbox_left">Portfolio Size</div>

            <div class="arb_calcbox_right"><input name="portsize" id="portsize" type="number" value="0" style="width:95%;" tabindex="2"></div>

            <div class="arb_clear smlspc"></div>

            

            <div class="arb_calcbox_left">Portfolio Allocation</div>

            <div class="arb_calcbox_right">

                <input name="portalloc" id="portalloc" type="number" value="0" style="width:85%; border-radius:0;" tabindex="3"><i class="fas fa-percentage" aria-hidden="true"></i>

            </div>

            <div class="arb_clear smlspc"></div>

            

            <div class="arb_calcbox_left">Position Size</div>

            <div class="arb_calcbox_right lockedd">

                <input name="posisize" id="posisize" type="text" value="0" style="width:85%;">

                <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>

                </div>

            <div class="arb_clear smlspc"></div>

            

            <div class="padbott"></div>
        
        <div class="allcaps varsecttl"><strong>Position Sizing & RRR</strong></div>

    

        <div class="arb_calcbox_left">Board lot</div>

        <div class="arb_calcbox_right lockedd">

        	<input name="boardlot" id="boardlot" type="text" value="0" style="width:85%;">

            <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>

        </div>

        <div class="arb_clear smlspc"></div>

        

        <div class="arb_calcbox_left">No of Shares to Buy</div>

        <div class="arb_calcbox_right lockedd">

        	<input name="noofshare" id="noofshare" type="text" value="0" style="width:85%;">

            <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>

        </div>

        <div class="arb_clear smlspc"></div>

        

        <div class="arb_calcbox_left">Risk to Reward Ratio</div>

        <div class="arb_calcbox_right lockedd">

        	<input name="risktoreward" id="risktoreward" type="text" value="0" style="width:85%;">

            <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>

        </div>

        <div class="arb_clear smlspc"></div>

        

    	<div class="padbott"></div>

        

        <div style="display:none;">Boardlot (Tmp - dynamic on chart)

        <input name="inpt_data_boardlot_get_" id="inpt_data_boardlot_get_" type="number" value="30" style="width:100%;">

        </div>

    </div>

    <div >
        <div class="allcaps varsecttl"><strong>Trade Planning</strong></div>
        <div class="arb_calcbox_left">Identified Entry Price</div>
        <div class="arb_calcbox_right"><input name="idenentryprice" id="idenentryprice" type="number" value="0" style="width:95%;" tabindex="4"></div>
        <div class="arb_clear smlspc"></div>

        <div class="arb_calcbox_left">Risk Tolerance</div>
        <div class="arb_calcbox_right"><input name="risktoler" id="risktoler" type="number" value="0" style="width:85%; border-radius:0;" tabindex="5"><i class="fas fa-percentage" aria-hidden="true"></i></div>
        <div class="arb_clear smlspc"></div>

        <div class="arb_calcbox_left">Target Profit</div>
        <div class="arb_calcbox_right"><input name="targetprof" id="targetprof" type="number" value="0" style="width:85%; border-radius:0;" tabindex="6"><i class="fas fa-percentage" aria-hidden="true"></i></div>
        <div class="arb_clear smlspc"></div>

        <div class="arb_calcbox_left">Stoploss</div>
        <div class="arb_calcbox_right lockedd">
        	<input name="stoploss" id="stoploss" type="text" value="0" style="width:75%; border-radius:0;"><i class="fas fa-percentage" aria-hidden="true"></i>
            <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>
        </div>

        <div class="arb_clear smlspc"></div>
        <div class="arb_calcbox_left">Take Profit Price</div>
        <div class="arb_calcbox_right lockedd">
        	<input name="takeprofitprice" id="takeprofitprice" type="text" value="0" style="width:85%;">
            <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>
        </div>

        <div class="arb_clear smlspc"></div>

        <div class="arb_calcbox_left">Stoploss Price</div>
        <div class="arb_calcbox_right lockedd">
        	<input name="stoplossprice" id="stoplossprice" type="text" value="0" style="width:85%;">
            <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>
        </div>

        <div class="arb_clear smlspc"></div>

        <div class="arb_calcbox_left">Value at Risk</div>
        <div class="arb_calcbox_right lockedd">
        	<div class="sublbl before">₱</div><input name="valueatrisk" id="valueatrisk" type="text" value="0" style="width:77%;">
            <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>
            </div>

        <div class="arb_clear smlspc"></div>

        <div class="arb_calcbox_left">Upside</div>
        <div class="arb_calcbox_right lockedd">
        	<div class="sublbl before">₱</div><input name="upside" id="upside" type="text" value="0" style="width:77%;">
            <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>
        </div>

        <div class="arb_clear smlspc"></div>
        <div class="padbott"></div>
    </div>        
</div> -->
    <?php

        function getfees($funmarketval, $funtype)
        {
            // Commissions
            $dpartcommission = $funmarketval * 0.0025;
            $dcommission = ($dpartcommission > 20 ? $dpartcommission : 20);
            // TAX
            $dtax = $dcommission * 0.12;
            // Transfer Fee
            $dtransferfee = $funmarketval * 0.00005;
            // SCCP
            $dsccp = $funmarketval * 0.0001;
            $dsell = $funmarketval * 0.006;

            if ($funtype == 'buy') {
                $dall = $dcommission + $dtax + $dtransferfee + $dsccp;
            } else {
                $dall = $dcommission + $dtax + $dtransferfee + $dsccp + $dsell;
            }

            return $dall;
        }

        $getdstocks = get_user_meta(get_current_user_id(), '_trade_list', true);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://arbitrage.ph/charthisto/?g=sampleprice');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $gerdqoute = curl_exec($curl);
        curl_close($curl);

        $gerdqoute = json_decode($gerdqoute);

        if ($getdstocks && $getdstocks != '') {
            $dtradeingfo = [];
            foreach ($getdstocks as $dstockskey => $dstocksvalue) {
                $dstocktraded = get_user_meta(get_current_user_id(), '_trade_'.$dstocksvalue, true);
                if ($dstocktraded && $dstocktraded != '') {
                    $dstockinfo = $gerdqoute->data->$dstocksvalue;
                    $marketval = $dstockinfo->last * $dstocktraded['totalstock'];
                    $dsellfees = getfees($marketval, 'sell');
                    $dtotal = $marketval - $dsellfees;

                    $dstocktraded['totalcost'] = $dtotal;
                    $dstocktraded['stockname'] = $dstocksvalue;
                    array_push($dtradeingfo, $dstocktraded);
                }
            }
        }

        $duseridmo = get_current_user_id();
        $dledger = $wpdb->get_results('SELECT * FROM arby_ledger where userid = '.$duseridmo);

        $buypower = 0;
        foreach ($dledger as $getbuykey => $getbuyvalue) {
            if ($getbuyvalue->trantype == 'deposit' || $getbuyvalue->trantype == 'selling') {
                $buypower = $buypower + $getbuyvalue->tranamount;
            } else {
                $buypower = $buypower - $getbuyvalue->tranamount;
            }
        }

        $dequityp = $buypower;

        if ($dtradeingfo) {
            foreach ($dtradeingfo as $trinfokey => $trinfovalue) {
                $dinforstocl = $trinfovalue['stockname'];
                $dstockinfo = $gerdqoute->data->$dinforstocl;
                $marketval = $dstockinfo->last * $dstocktraded['totalstock'];
                $dsellfees = getfees($marketval, 'sell');
                $dtotal = $marketval - $dsellfees;

                $dequityp += $dtotal;
                $currentalocinfo .= '{"category" : "'.$trinfovalue['stockname'].'", "column-1" : "'.number_format($trinfovalue['totalcost'], 2, '.', '').'"},';
                $currentaloccolor .= '"'.$aloccolors[$trinfokey + 1].'",';
            }
        }

        // $dequityp = 0;
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://data-api.arbitrage.ph/api/v1/stocks/history/latest?stock-exchange=PSE' );
        curl_setopt($curl, CURLOPT_RESOLVE, ['data-api.arbitrage.ph:443:104.25.248.104']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $dwatchinfo = curl_exec($curl);
        curl_close($curl);

        $dwatchinfo = json_decode($dwatchinfo);
        

    ?>
    <!-- <pre>
        <?php print_r($dwatchinfo); ?>
    </pre> -->
    <div class="bkcalcboxess container-fluid ">
    <span><span class="toborderbotvar"><strong>Value At Risk</strong> (VAR) Calculator</span><i class="fas fa-times toclassclosess"></i></span>
        <div class="row">
            
            <div class="col-6">
                <div class="halfts">
                    <div class="allcaps varsecttl"><strong>Enter Stock Details</strong></div>

                    

                        <div class="arb_calcbox_left">Stock Name</div>

                        <div class="arb_calcbox_right">

                            <!-- <input name="stockname" id="stockname" type="text" value="BDO" style="width: 85%; text-align: left;"> -->
                            <div class="dselecton">
                                <select name="stockname" id="stockname">
                                    <option value="0">Select a Stock</option>
                                    <?php foreach($dwatchinfo->data as $dwkey => $dwvalue): ?>
                                        <option value="<?php echo $dwvalue->last; ?>"><?php echo $dwvalue->symbol; ?></option>
                                    <?php endforeach; ?>
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

                            <input name="portalloc" id="portalloc" type="text" class="number" value="0" style="width:85%; border-radius:0; margin-right: 0;" tabindex="3">
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
            <div class="col-6">
                <div class="halfts">
                    <div class="allcaps varsecttl"><strong>Trade Planning</strong></div>
                    <div class="arb_calcbox_left">Identified Entry Price</div>
                    <div class="arb_calcbox_right"><input name="idenentryprice" id="idenentryprice" type="text" class="number" value="0" style="width:80%;" tabindex="4"></div>
                    <div class="arb_clear smlspc"></div>

                    <div class="arb_calcbox_left">Risk Tolerance</div>
                    <div class="arb_calcbox_right"><input name="risktoler" id="risktoler" type="text" class="number" value="0" style="width:80%;" tabindex="5"><i class="fas fa-percentage" aria-hidden="true"></i></div>
                    <div class="arb_clear smlspc"></div>

                    <div class="arb_calcbox_left">Target Profit</div>
                    <div class="arb_calcbox_right"><input name="targetprof" id="targetprof" type="text" class="number" value="0" style="width:80%;" tabindex="6"><i class="fas fa-percentage" aria-hidden="true"></i></div>
                    <!-- <div class="arb_clear smlspc"></div> -->

                    <!-- <div class="arb_calcbox_left">Stoploss</div>
                    <div class="arb_calcbox_right lockedd">
                        <input class="input-locked number" name="stoploss" id="stoploss" type="text" value="0" style="width:80%;" disabled><i class="fas fa-percentage" aria-hidden="true"></i>
                        <i class="fa fa-lock lock__icon--position" aria-hidden="true"></i>
                    </div> -->

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

<script language="javascript">

	jQuery(document).ready(function(){

        jQuery("#stockname").on('change', function() {
            console.log(this.value);
            jQuery("#currentprice").val(this.value);
        });
		

		jQuery("#currentprice, #portalloc, #portsize, #risktoler, #targetprof, #idenentryprice, #targetprof, #noofshare").keyup(function(){exevarclc();});

		jQuery("#currentprice, #portalloc, #portsize, #risktoler, #targetprof, #idenentryprice, #targetprof, #noofshare").click(function(){exevarclc();});

		

		function exevarclc(){

			/* ENTER STOCK DETAILS */

			var vr_currentprice = jQuery('#currentprice').val().replace(/[^0-9\.]/g, ''); // 12.5

	
			/* PORTFOLIO PLANNING */

			var vr_portsize = jQuery('#portsize').val().replace(/[^0-9\.]/g, ''); // 100,000

			var vr_portalloc = jQuery('#portalloc').val().replace(/[^0-9\.]/g, ''); // 30

			var vr_portallocdeci = Number(vr_portalloc) / 100; 

			var vr_posisizemin = Math.round(Number(vr_portallocdeci) * Number(vr_portsize));

			jQuery('#posisize').val(numeral(vr_posisizemin).format('0,0.00'));

			

			/* TRADE PLANNING */

            var vr_idenentryprice = jQuery('#idenentryprice').val().replace(/[^0-9\.]/g, '');

			var vr_risktoler = jQuery('#risktoler').val().replace(/[^0-9\.]/g, '');

			var vr_targetprof = jQuery('#targetprof').val().replace(/[^0-9\.]/g, '');

			var vr_stoploss = jQuery('#stoploss').val(numeral(vr_risktoler).format('0,0.00'));

			

			var vr_takeprofitpricetot0 = Number(vr_targetprof) / 100;

			var vr_takeprofitpricetot1 = Number(vr_idenentryprice) * Number(vr_takeprofitpricetot0);

			var vr_takeprofitpricetot2 = Number(vr_idenentryprice) + Number(vr_takeprofitpricetot1);

            var vr_takeprofitprice = jQuery('#takeprofitprice').val(numeral(vr_takeprofitpricetot2).format('0,0.00'));

			

			var vr_stoplosspricetot1 = Number(vr_risktoler) / 100;

			var vr_stoplosspricetot2 = Number(vr_idenentryprice) - Number(vr_stoplosspricetot1);

			var vr_stoplossprice = jQuery('#stoplossprice').val(numeral(vr_stoplosspricetot2).format('0,0.00'));
			

			var vr_valueatrisk1 = Number(vr_risktoler) / 100;

			var vr_valueatrisk2 = Number(vr_posisizemin) * Number(vr_valueatrisk1)

			var vr_valueatrisk = jQuery('#valueatrisk').val(numeral(vr_valueatrisk2).format('0,0.00'));

			

			var vr_upsidetot = Number(vr_posisizemin) * Number(vr_takeprofitpricetot0);

			var vr_upside = jQuery('#upside').val(numeral(vr_upsidetot).format('0,0.00'));

			

			/* POSITION SIZING & RRR */

     //       var boardlotget_var = $("#idenentryprice").val();
           
               var boardlotget_var = $("#idenentryprice").val().replace(/[^0-9\.]/g, '');
           
            //    console.log('emman sucks');
            // console.log(boardlotget_var);

               boardlotget_var = parseFloat(boardlotget_var);

            var boardlotget_val;

			if ( boardlotget_var >= 0.0001 && boardlotget_var <= 0.0099){

				boardlotget_val = 1000000

			} else if ( boardlotget_var >= 0.01 && boardlotget_var <= 0.049){

				boardlotget_val = 100000

			} else if ( boardlotget_var >= 0.05 && boardlotget_var <= 0.495){

				boardlotget_val = 10000

			} else if ( boardlotget_var >= 0.5 && boardlotget_var <= 4.99){

				boardlotget_val = 1000

			} else if ( boardlotget_var >= 5 && boardlotget_var <= 49.95){

				boardlotget_val = 100

			} else if ( boardlotget_var >= 50 && boardlotget_var <= 999.5){

				boardlotget_val = 10

			} else if ( boardlotget_var >= 1000){

				boardlotget_val = 5

			}			

 //         var vr_boardlot = jQuery('#boardlot').val().replace(/[^0-9\.]/g, '');			


            var vr_boardlot_tmp = jQuery('#boardlot').val(numeral(boardlotget_val).format('0,0.00'));			

            var vr_boardlot = boardlotget_val;

			var vr_noofsharetot1 = Number(vr_posisizemin) / Number(boardlotget_val);

            var vr_noofsharetot2 = Math.round(Number(vr_noofsharetot1) / Number(vr_idenentryprice));

                vr_noofsharetot2 = Number.isNaN(vr_noofsharetot2) ? 0 : vr_noofsharetot2;


            // var numofshares = vr_posisizemin / 
            
            var blots = parseFloat(boardlotget_val);
            var sharestobuy = Math.floor(vr_posisizemin / vr_idenentryprice);
            
            var slotmultiplier = Math.floor(sharestobuy / blots);
            var finalstocks = blots * slotmultiplier;

            console.log(sharestobuy);

                

			// var vr_noofshare = jQuery('#noofshare').val(numeral(vr_noofsharetot2).format('0,0.00'));
			var vr_noofshare = jQuery('#noofshare').val(numeral(finalstocks).format('0,0.00'));

            

			var vr_risktorewardtot1 = Number(vr_valueatrisk2) / Number(vr_valueatrisk2);

			var vr_risktorewardtot2 = Number(vr_upsidetot) / Number(vr_valueatrisk2);

            var vr_risktorewardfmt = vr_risktorewardtot1 + ":" + vr_risktorewardtot2;

                vr_risktorewardfmt = Number.isNaN(vr_risktorewardtot1) || Number.isNaN(vr_risktorewardtot2) ? 0 : vr_risktorewardfmt;

			var vr_risktoreward = jQuery('#risktoreward').val(vr_risktorewardfmt);	

			

        }
        

        jQuery('input.number').keyup(function (event) {
            // skip for arrow keys
                 // var calc
            if (event.which >= 37 && event.which <= 40) {
                event.preventDefault();
            }

            var currentVal = jQuery(this).val();
            var testDecimal = testDecimals(currentVal);
            if (testDecimal.length > 1) {
                console.log("You cannot enter more than one decimal point");
                currentVal = currentVal.slice(0, -1);
            }
            jQuery(this).val(replaceCommas(currentVal));
        });

        function testDecimals(currentVal) {
            var count;
            currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
            return count;
        }

        function replaceCommas(yourNumber) {
            var components = yourNumber.toString().split(".");
            if (components.length === 1) 
                components[0] = yourNumber;
            components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            if (components.length === 2)
                components[1] = components[1].replace(/\D/g, "");
            return components.join(".");
        }

	});

</script>

</div>