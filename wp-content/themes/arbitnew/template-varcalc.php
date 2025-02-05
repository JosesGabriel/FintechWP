<?php /* Template Name: VAR Calculator */ ?>
<?php get_header("dashboard"); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<style type="text/css">
html, .home body.et_cover_background {
    background-color: #354960 !important;
}
/* Chart Default - do not copy */
.lockedd {
    position: relative;
}
.lockedd i.fa.fa-lock {
    top: 7px;
    position: absolute;
    right: 14px;
    font-size: 14px;
    color: #ecf0f1;
}

/* Default Calc Styles - do not copy */
.arb_calcbox {
	color:#FFFFFF;
	padding:35px;
	max-width:550px;
	width:100%;
	margin:0 auto;
	font-size:13px;
}
.arb_calcbox input[type="number"] {
	border:0;
	border-radius: 4px;
	padding: 5px 6px;
	background-color: #4e6a85;
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
    width: 90%;
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
.varcalc .arb_calcbox_left {
    line-height: 30px;
    background-color: #213f58;
    padding: 0 0 0 10px;
    border-radius: 5px 0 0 5px;
}
.varcalc input[type="number"] {
	margin-top:0;
	border-radius: 0 5px 5px 0;
	border: none;
	display:inline-block;
	padding: 5px 6px;
    line-height: 20px;
}
.varcalc input[type="text"] {
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
	background-color: #4e6a85;
}
.sublbl.before {
	display:inline-block;
	line-height: 30px;
	padding:0 0 0 7px;
	border-radius:0;
	background-color: #4e6a85;
}
.varcalc {
	max-width: 370px;
}
.varcalc .padbott {
	padding-bottom:5px;
}
.varcalc .allcaps {
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
</style>
<div class="arb_calcbox varcalc">

    <h3><strong>Value At Risk</strong> (VAR) Calculator</h3>
    
    <div class="allcaps varsecttl"><strong>Enter Stock Details</strong></div>
    
        <div class="arb_calcbox_left">Stock Name</div>
        <div class="arb_calcbox_right"><input name="stockname" id="stockname" type="text" value="BDO" style="width:95%;"></div>
        <div class="arb_clear smlspc"></div>
        
        <div class="arb_calcbox_left">Current Price</div>
        <div class="arb_calcbox_right"><input name="currentprice" id="currentprice" type="number" step="0.01" value="0" style="width:95%;" tabindex="1"></div>
        <div class="arb_clear smlspc"></div>
        
        <div class="padbott"></div>
    
    <div class="allcaps varsecttl"><strong>Portfolio Planning</strong></div>
    
        <div class="arb_calcbox_left">Portfolio Size</div>
        <div class="arb_calcbox_right"><input name="portsize" id="portsize" type="number" value="0" style="width:95%;" tabindex="2"></div>
        <div class="arb_clear smlspc"></div>
        
        <div class="arb_calcbox_left">Portfolio Allocation</div>
        <div class="arb_calcbox_right"><input name="portalloc" id="portalloc" type="number" value="0" style="width:79%; border-radius:0;" tabindex="3"><div class="sublbl after">%</div></div>
        <div class="arb_clear smlspc"></div>
        
        <div class="arb_calcbox_left">Position Size</div>
        <div class="arb_calcbox_right lockedd">
        	<input name="posisize" id="posisize" type="text" value="0" style="width:95%;">
        	<i class="fa fa-lock" aria-hidden="true"></i>
            </div>
        <div class="arb_clear smlspc"></div>
        
    	<div class="padbott"></div>
    
    <div class="allcaps varsecttl"><strong>Trade Planning</strong></div>
    
        <div class="arb_calcbox_left">Identified Entry Price</div>
        <div class="arb_calcbox_right"><input name="idenentryprice" id="idenentryprice" type="number" step="0.01" value="0" style="width:95%;" tabindex="4"></div>
        <div class="arb_clear smlspc"></div>
        
        <div class="arb_calcbox_left">Risk Tolerance</div>
        <div class="arb_calcbox_right"><input name="risktoler" id="risktoler" type="number" step="0.01" value="0" style="width:79%; border-radius:0;" tabindex="5"><div class="sublbl after">%</div></div>
        <div class="arb_clear smlspc"></div>
        
        <div class="arb_calcbox_left">Target Profit</div>
        <div class="arb_calcbox_right"><input name="targetprof" id="targetprof" type="number" step="0.01" value="0" style="width:79%; border-radius:0;" tabindex="6"><div class="sublbl after">%</div></div>
        <div class="arb_clear smlspc"></div>
        
        <div class="arb_calcbox_left">Stoploss</div>
        <div class="arb_calcbox_right lockedd">
        	<input name="stoploss" id="stoploss" type="text" value="0" style="width:57%; border-radius:0;"><div class="sublbl after" style="padding:0 27px 0 10px">%</div>
            <i class="fa fa-lock" aria-hidden="true"></i>
        </div>
        <div class="arb_clear smlspc"></div>
        
        <div class="arb_calcbox_left">Take Profit Price</div>
        <div class="arb_calcbox_right lockedd">
        	<input name="takeprofitprice" id="takeprofitprice" type="text" value="0" style="width:95%;">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </div>
        <div class="arb_clear smlspc"></div>
        
        <div class="arb_calcbox_left">Stoploss Price</div>
        <div class="arb_calcbox_right lockedd">
        	<input name="stoplossprice" id="stoplossprice" type="text" value="0" style="width:95%;">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </div>
        <div class="arb_clear smlspc"></div>
        
        <div class="arb_calcbox_left">Value at Risk</div>
        <div class="arb_calcbox_right lockedd">
        	<div class="sublbl before">₱</div><input name="valueatrisk" id="valueatrisk" type="text" value="0" style="width:80%;">
            <i class="fa fa-lock" aria-hidden="true"></i>
            </div>
        <div class="arb_clear smlspc"></div>
        
        <div class="arb_calcbox_left">Upside</div>
        <div class="arb_calcbox_right lockedd">
        	<div class="sublbl before">₱</div><input name="upside" id="upside" type="text" value="0" style="width:80%;">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </div>
        <div class="arb_clear smlspc"></div>
        
        <div class="padbott"></div>
    
    <div class="allcaps varsecttl"><strong>Position Sizing & RRR</strong></div>
    
        <div class="arb_calcbox_left">Board lot</div>
        <div class="arb_calcbox_right lockedd">
        	<input name="boardlot" id="boardlot" type="text" value="0" style="width:95%;">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </div>
        <div class="arb_clear smlspc"></div>
        
        <div class="arb_calcbox_left">No of Shares to Buy</div>
        <div class="arb_calcbox_right lockedd">
        	<input name="noofshare" id="noofshare" type="text" value="0" style="width:95%;">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </div>
        <div class="arb_clear smlspc"></div>
        
        <div class="arb_calcbox_left">Risk to Reward Ratio</div>
        <div class="arb_calcbox_right lockedd">
        	<input name="risktoreward" id="risktoreward" type="text" value="0" style="width:95%;">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </div>
        <div class="arb_clear smlspc"></div>
        
    	<div class="padbott"></div>
        
        <div style="display:none;">Boardlot (Tmp - dynamic on chart)
        <input name="inpt_data_boardlot_get_" id="inpt_data_boardlot_get_" type="number" value="30" style="width:100%;">
        </div>
        
    
</div>
<script language="javascript">
	jQuery(document).ready(function(){
		
		jQuery("#currentprice, #portalloc, #portsize, #risktoler, #targetprof, #idenentryprice, #targetprof, #noofshare").keyup(function(){exevarclc();});
		jQuery("#currentprice, #portalloc, #portsize, #risktoler, #targetprof, #idenentryprice, #targetprof, #noofshare").click(function(){exevarclc();});
		
		function exevarclc(){
			/* ENTER STOCK DETAILS */
			var vr_currentprice = jQuery('#currentprice').val(); // 12.5
			
			/* PORTFOLIO PLANNING */
			var vr_portsize = jQuery('#portsize').val(); // 100,000
			var vr_portalloc = jQuery('#portalloc').val(); // 30
			var vr_portallocdeci = Number(vr_portalloc) / 100; 
			var vr_posisizemin = Math.round(Number(vr_portallocdeci) * Number(vr_portsize));
			jQuery('#posisize').val(vr_posisizemin);
			
			/* TRADE PLANNING */
			var vr_idenentryprice = jQuery('#idenentryprice').val();
			var vr_risktoler = jQuery('#risktoler').val();
			var vr_targetprof = jQuery('#targetprof').val();
			var vr_stoploss = jQuery('#stoploss').val(vr_risktoler);
			
			var vr_takeprofitpricetot0 = Number(vr_targetprof) / 100;
			var vr_takeprofitpricetot1 = Number(vr_idenentryprice) * Number(vr_takeprofitpricetot0);
			var vr_takeprofitpricetot2 = Number(vr_idenentryprice) + Number(vr_takeprofitpricetot1);
			var vr_takeprofitprice = jQuery('#takeprofitprice').val(vr_takeprofitpricetot2.toFixed(2));
			
			var vr_stoplosspricetot1 = Number(vr_risktoler) / 100;
			var vr_stoplosspricetot2 = Number(vr_idenentryprice) - Number(vr_stoplosspricetot1);
			var vr_stoplossprice = jQuery('#stoplossprice').val(vr_stoplosspricetot2.toFixed(2));
			
			var vr_valueatrisk1 = Number(vr_risktoler) / 100;
			var vr_valueatrisk2 = Number(vr_posisizemin) * Number(vr_valueatrisk1)
			var vr_valueatrisk = jQuery('#valueatrisk').val(vr_valueatrisk2);
			
			var vr_upsidetot = Number(vr_posisizemin) * Number(vr_takeprofitpricetot0);
			var vr_upside = jQuery('#upside').val(vr_upsidetot);
			
			/* POSITION SIZING & RRR */
			var boardlotget_var = $("#inpt_data_boardlot_get_").val();
			var boardlotget_val
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
			var vr_boardlot = jQuery('#boardlot').val(boardlotget_val);
			
			var vr_noofsharetot1 = Number(vr_posisizemin) / Number(boardlotget_val);
			var vr_noofsharetot2 = Math.round(Number(vr_noofsharetot1) / Number(vr_idenentryprice));
			var vr_noofshare = jQuery('#noofshare').val(vr_noofsharetot2);
			
			var vr_risktorewardtot1 = Number(vr_valueatrisk2) / Number(vr_valueatrisk2);
			var vr_risktorewardtot2 = Number(vr_upsidetot) / Number(vr_valueatrisk2);
			var vr_risktorewardfmt = vr_risktorewardtot1 + ":" + vr_risktorewardtot2;
			var vr_risktoreward = jQuery('#risktoreward').val(vr_risktorewardfmt);	
			
		}
	});
</script>
<?php get_footer("dashboard"); ?>