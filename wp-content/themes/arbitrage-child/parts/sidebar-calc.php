<div id="toghandle" class="add-postsis xazha" style="display: none;">

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<style type="text/css">
.arb_calcbox input[type="number"] {
	border: 0;
	border-radius: 4px;
	padding: 5px 6px;
	background-color: #4e6a85;
	border: 1px solid #4e6a85;
	color: #ecf0f1;
	font-family: 'Roboto', sans-serif;
	display: block;
	width: 90%;
	margin-top: 3px;
}

.arb_calcbox h3 {
	font-size: 17px;
	padding-bottom: 0;
	font-weight: normal;
}

.arb_calcbox h3 strong {
	text-transform: uppercase;
}

.arb_calcbox h4 {
	font-size: 15px;
	padding-bottom: 0;
	font-weight: normal;
}

.arb_calcbox h4 strong {
	text-transform: uppercase;
}

.arb_calcbox small {
	font-size: 11px;
	display: block;
}

.arb_clear {
	clear: both;
}

.arb_calcbox_lefting {
	float: left;
	width: 60%;
}

.arb_calcbox_righting {
	float: right;
	width: 40%;
	padding-top: 16px;
	padding-right: 5px;
}

.padbott {
	padding-bottom: 5px;
}

.arb_buyfees,
.arb_sellfees {
	position: relative;
}

.feedetails_sell,
.feedetails_buy {
	display: none;
}

.feedetails_sell,
.feedetails_buy {
	position: absolute;
	left: -1px;
	top: 0;
	padding: 12px;
	border-radius: 5px;
	background-color: #2b3d4f;
	width: 90%;
}

.smlinline {
	display: inline-block !important;
	vertical-align: text-top;
	cursor: pointer;
}

.clcbxttl {
	border-bottom: 1px solid #4e6a85;
	margin-top: -5px;
	margin-bottom: 5px;
	padding-bottom: 5px;
}

.arb_dvdr {
	border-bottom: 1px solid #1e3554 !important;
    width: 75%;
    margin: 8px 12px;
    padding-left: 10px;
}

.arb_breakeven {
	width: 100%;
	margin: 4px 0 0;
	border-radius: 4px;
	overflow: hidden;
}

.arbredtxt {
	color: #e64c3c;
}

.arbgreentxt {
	color: #25ae5f;
}

.alleft {
	float: left
}

.alright {
	float: right
}

.arbleveling {
	padding: 3px 7px 3px;
	line-height: 20px;
}

.banner-try {
	background: #142c46;
	border-radius: 5px;
	padding-bottom: 12px;
	margin-top: 15px;
	display: none;
}

.banner-try .to-top-title {
	padding-top: 10px !important;
	padding-left: 15px !important;
	padding-right: 15px !important;
	padding-bottom: 0 !important;
	margin-bottom: 5px !important;
}

.adsbygoogle .to-top-title {
	padding-top: 6px;
	padding-left: 13px;
	padding-right: 13px;
	padding-bottom: 0;
	margin-bottom: 5px;
}

.cont-try-premium {
	padding: 0 14px;
}

.to-top-create {
	float: right;
	color: #6583a8;
}
.bit_asda {
	padding-bottom: 3px;
    display: block;
}
.rightAlignCal {
	float: right;
	margin-right: 25px;
}
.amtdtls{
    float:right;
}
.lblbcl{
    margin-left:15px;
}
.number{
    font-size: 13px;
    text-align: right;
}
</style>
<div class="arb_calcbox">
<div class="bkcalcbox">
	<span><span class="toborderbotcalc"><strong>Buy/Sell</strong> Calculator</span><i class="fas fa-times toclassclose"></i></span>
	<div style="padding-top: 10px;padding-bottom: 12px;">
		<div class="arb_calcbox_left">Number of Shares: </div>
		<div class="arb_calcbox_right">
			<input name="numofshares" id="numofshares" class="_fottns number" type="text" value="0" style="width:100%;">
		</div>
	</div>
	<div class="arb_calcbox_lefting">
	<div class="arb_dvdr"></div>
		<div class="padbott"><span class=" bit_asda">
		<!-- <strong>Buy Price:</strong></span> <input name="buyprice" id="buyprice" class="_fottns" type="number" value="0"> -->
		<div class="arb_calcbox_left">Buy Price: </div>
		<div class="arb_calcbox_right">
			<input name="buyprice" id="buyprice" type="text" class="number" value="0" style="width:80%;">
		</div>
		</div>
		<div class="arb_buyvalue padbott" style="padding-top: 30px;">
			<span class="lblbcl">Value: </span>
			<span class="rightAlignCal">₱ <span id="buyvalue">0.00</span></span>
		</div>
		<div class="arb_buyfees padbott ">
			<span class="lblbcl">Fees: </span>
			<span class="rightAlignCal">
				<i class="fas fa-info-circle" title="view more..."  style="padding-right: 5px; cursor:pointer;"></i> ₱ <span id="buyfees">0.00</span>
			</span>
			
			<div class="feedetails_buy">
				<div class="clcbxttl">Fees<small class="smlinline" style="float:right;"><i class="fas fa-times-circle"></i></small></div>
				<small>Commission: <span class="amtdtls">₱<span id="buycommadjst">0.00</span></span></small>
				<small>Value Added Tax: <span class="amtdtls">₱<span id="buyvatfix">0.00</span></span></small>
				<small>Transfer Fee: <span class="amtdtls">₱<span id="buypsetffix">0.00</span></span></small>
				<small>SCCP: <span class="amtdtls">₱<span id="buysccpfix">0.00</span></span></small>
			</div>
		</div>
		<div class="arb_buytotal padbott ">
		<span class="lblbcl">Buy Total: </span>
		<span class="rightAlignCal" id="buytotal">0.00</span></div>
		<div class="arb_dvdr"></div>
		<div class="padbott"><span class=" bit_asda">
			<!-- <strong>Sell Price:</strong></span> <input name="sellprice" id="sellprice" class="_fottns" type="number" value="0"> -->
			<div class="arb_calcbox_left">Sell Price: </div>
			<div class="arb_calcbox_right">
				<input name="sellprice" id="sellprice" class="_fottns number" type="text" style="width:80%;" value="0">
			</div>
		</div>
		<div class="arb_sellvalue padbott " style="padding-top: 30px;">
			<span class="lblbcl">Value: </span>
				<span class="rightAlignCal">₱ <span id="sellvalue">0.00</span></div>
			</span>
		<div class="arb_sellfees padbott ">
			<span class="lblbcl">Fees: </span>
			<span class="rightAlignCal">
			<i class="fas fa-info-circle" title="view more..." style="padding-right: 5px; cursor:pointer;"></i> ₱ <span id="sellfees">0.00</span>
			</span>
			
			<div class="feedetails_sell">
				<div class="clcbxttl">Fees<small class="smlinline" style="float:right;"><i class="fas fa-times-circle"></i></small></div>
				<small>Commission: <span class="amtdtls">₱<span id="sellcommadjst">0.00</span></span></small>
				<small>Value Added Tax: <span class="amtdtls">₱<span id="sellvatfix">0.00</span></span></small>
				<small>Transfer Fee: <span class="amtdtls">₱<span id="sellpsetffix">0.00</span></span></small>
				<small>SCCP: <span class="amtdtls">₱<span id="sellsccpfix">0.00</span></span></small>
				<small>Sales Tax: <span class="amtdtls">₱<span id="sellsaletxfix">0.00</span></span></small>
			</div>
		</div>
		<div class="arb_selltotal ">
		<span class="lblbcl">Sell Total: </span>
		<span class="rightAlignCal" id="selltotal">0.00</span></div>
		<div class="arb_dvdr"></div>
		<div class="arbnetprofit padbott ">
			<span class="textchangecolor lblbcl"><strong>Net Profit: 
			<span class="rightAlignCal">
				₱<span id="arbnetprofitf">0.00</span> (<span id="arbperctg">0</span>%)</strong></span>
			</span>
		</div>
	</div>
	<div class="arb_calcbox_righting">
		<strong>Break-Even Analysis</strong>
		<div class="arb_breakeven">
			<div class="arbleveling" style="background-color: rgba(44, 174, 95, 1.0);">
				<div class="alleft">₱ <span id="brkevn200">0.00</span></div>
				<div class="alright">20.00%</div>
				<div class="arb_clear"></div>
			</div>
			<div class="arbleveling" style="background-color: rgba(44, 174, 95, 0.8);">
				<div class="alleft">₱ <span id="brkevn100">0.00</span></div>
				<div class="alright">10.00%</div>
				<div class="arb_clear"></div>
			</div>
			<div class="arbleveling" style="background-color: rgba(44, 174, 95, 0.6);">
				<div class="alleft">₱ <span id="brkevn75">0.00</span></div>
				<div class="alright">7.50%</div>
				<div class="arb_clear"></div>
			</div>
			<div class="arbleveling" style="background-color: rgba(44, 174, 95, 0.4);">
				<div class="alleft">₱ <span id="brkevn50">0.00</span></div>
				<div class="alright">5.00%</div>
				<div class="arb_clear"></div>
			</div>
			<div class="arbleveling" style="background-color: rgba(44, 174, 95, 0.2);">
				<div class="alleft">₱ <span id="brkevn25">0.00</span></div>
				<div class="alright">2.50%</div>
				<div class="arb_clear"></div>
			</div>
			<div class="arbleveling">
				<div class="alleft">₱ <span id="brkevnflat">0.00</span></div>
				<div class="alright">0.00%</div>
				<div class="arb_clear"></div>
			</div>
			<div class="arbleveling" style="background-color: rgba(230, 76, 60, 0.2);">
				<div class="alleft">₱ -<span id="negbrkevn25">0.00</span></div>
				<div class="alright">-2.50%</div>
				<div class="arb_clear"></div>
			</div>
			<div class="arbleveling" style="background-color: rgba(230, 76, 60, 0.4);">
				<div class="alleft">₱ -<span id="negbrkevn50">0.00</span></div>
				<div class="alright">-5.00%</div>
				<div class="arb_clear"></div>
			</div>
			<div class="arbleveling" style="background-color: rgba(230, 76, 60, 0.6);">
				<div class="alleft">₱ -<span id="negbrkevn75">0.00</span></div>
				<div class="alright">-7.50%</div>
				<div class="arb_clear"></div>
			</div>
			<div class="arbleveling" style="background-color: rgba(230, 76, 60, 0.8);">
				<div class="alleft">₱ -<span id="negbrkevn100">0.00</span></div>
				<div class="alright">-10.00%</div>
				<div class="arb_clear"></div>
			</div>
			<div class="arbleveling" style="background-color: rgba(230, 76, 60, 1.0);">
				<div class="alleft">₱ -<span id="negbrkevn200">0.00</span></div>
				<div class="alright">-20.00%</div>
				<div class="arb_clear"></div>
			</div>
		</div>
	</div>
	<div class="arb_clear padbott"></div>
</div>
</div>

<script language="javascript">
jQuery(document).ready(function() {
	jQuery(".arb_sellfees").click(function() {
		jQuery(".feedetails_sell").slideToggle("fast");
	});
	jQuery(".arb_buyfees").click(function() {
		jQuery(".feedetails_buy").slideToggle("fast");
	});

	jQuery("#buyprice, #sellprice").keyup(function() {
		execlc();
	});
	jQuery("#buyprice, #sellprice").click(function() {
		execlc();
	});

	function execlc() {

		var vrnumofshares = document.getElementById("numofshares").value.replace(/[^0-9\.]/g, '');

		/* Buy */
		var vrbuyprice = document.getElementById("buyprice").value.replace(/[^0-9\.]/g, '');
		var vrbuyvalue = Math.round(vrnumofshares * vrbuyprice);
        jQuery("#buyvalue").html(numeral(vrbuyvalue).format('0,0.00'));

		/* Buy Fees */
		var vrbuycommcheck = vrbuyvalue * 0.0025;
		var vrbuycommadjst;
		if (vrbuycommcheck <= 20) {
			vrbuycommadjst = 20;
		} else {
			vrbuycommadjst = vrbuyvalue * 0.0025;
		}
		jQuery("#buycommadjst").html(numeral(vrbuycommadjst).format('0,0.00'));
		var vrbuyvatfix = vrbuycommadjst * 0.12;
		jQuery("#buyvatfix").html(numeral(vrbuyvatfix).format('0,0.00'));
		var vrbuypsetffix = vrbuyvalue * 0.00005;
		jQuery("#buypsetffix").html(numeral(vrbuypsetffix).format('0,0.00'));
		var vrbuysccpfix = vrbuyvalue * 0.0001;
		jQuery("#buysccpfix").html(numeral(vrbuysccpfix).format('0,0.00'));

		/* Buy Totals */
		var vrbuyfees = vrbuycommadjst + vrbuyvatfix + vrbuypsetffix + vrbuysccpfix;
		jQuery("#buyfees").html(numeral(vrbuyfees).format('0,0.00'));
		var vrbuytotal = vrbuyfees + vrbuyvalue;
		jQuery("#buytotal").html(numeral(vrbuytotal).format('0,0.00'));

        /* Sell */
        // var vrsellprice = document.getElementById("sellprice").value.replace(/\D/g,'');
		var vrsellprice = document.getElementById("sellprice").value.replace(/[^0-9\.]/g, '');

		var vrsellvalue = Math.round(vrnumofshares * vrsellprice);
		jQuery("#sellvalue").html(numeral(vrsellvalue).format('0,0.00'));

		/*Sell Fees*/
		var vrsellcommcheck = vrsellvalue * 0.0025;
		var vrsellcommadjst;
		if (vrsellcommcheck <= 20) {
			vrsellcommadjst = 20;
		} else {
			vrsellcommadjst = vrsellvalue * 0.0025;
		}
		jQuery("#sellcommadjst").html(numeral(vrsellcommadjst).format('0,0.00'));
		var vrsellvatfix = vrsellcommadjst * 0.12;
		jQuery("#sellvatfix").html(numeral(vrsellvatfix).format('0,0.00'));
		var vrsellpsetffix = vrsellvalue * 0.00005;
		jQuery("#sellpsetffix").html(numeral(vrsellpsetffix).format('0,0.00'));
		var vrsellsccpfix = vrsellvalue * 0.0001;
		jQuery("#sellsccpfix").html(numeral(vrsellsccpfix).format('0,0.00'));
		var vrsellsaletxfix = vrsellvalue * 0.006;
		jQuery("#sellsaletxfix").html(numeral(vrsellsaletxfix).format('0,0.00'));

		/* Sell Totals */
		var vrsellfees = vrsellcommadjst + vrsellvatfix + vrsellpsetffix + vrsellsccpfix + vrsellsaletxfix;
		jQuery("#sellfees").html(numeral(vrsellfees).format('0,0.00'));
		var vrselltotal = vrsellvalue - vrsellfees;
		jQuery("#selltotal").html(numeral(vrselltotal).format('0,0.00'));

		var vrarbnetprofitf = vrselltotal - vrbuytotal;
		jQuery("#arbnetprofitf").html(numeral(vrarbnetprofitf).format('0,0.00'));

		var vrarbperctg = vrarbnetprofitf / vrbuytotal * 100;
		jQuery("#arbperctg").html(numeral(vrarbperctg).format('0,0.00'));

		if (vrbuytotal > vrselltotal) {
			jQuery(".textchangecolor").addClass("arbredtxt");
			jQuery(".textchangecolor").removeClass("arbgreentxt");
		} else {
			jQuery(".textchangecolor").addClass("arbgreentxt");
			jQuery(".textchangecolor").removeClass("arbredtxt");
		}

		/*Breakeven*/

		var vrbrkevnflat1 = vrbuyprice * 0.011;
		var vrbrkevnflat2 = Number(vrbuyprice) + Number(vrbrkevnflat1);
		jQuery("#brkevnflat").html(numeral(vrbrkevnflat2).format('0,0.00'));

		var vrbrkevn2001 = Number(vrbrkevnflat2) * 0.2;
		var vrbrkevn2002 = Number(vrbrkevnflat2) + Number(vrbrkevn2001);
		jQuery("#brkevn200").html(numeral(vrbrkevn2002).format('0,0.00'));

		var vrbrkevn1001 = Number(vrbrkevnflat2) * 0.1;
		var vrbrkevn1002 = Number(vrbrkevnflat2) + Number(vrbrkevn1001);
		jQuery("#brkevn100").html(numeral(vrbrkevn1002).format('0,0.00'));

		var vrbrkevn751 = Number(vrbrkevnflat2) * 0.075;
		var vrbrkevn752 = Number(vrbrkevnflat2) + Number(vrbrkevn751);
		jQuery("#brkevn75").html(numeral(vrbrkevn752).format('0,0.00'));

		var vrbrkevn501 = Number(vrbrkevnflat2) * 0.05;
		var vrbrkevn502 = Number(vrbrkevnflat2) + Number(vrbrkevn501);
		jQuery("#brkevn50").html(numeral(vrbrkevn502).format('0,0.00'));

		var vrbrkevn251 = Number(vrbrkevnflat2) * 0.025;
		var vrbrkevn252 = Number(vrbrkevnflat2) + Number(vrbrkevn251);
		jQuery("#brkevn25").html(numeral(vrbrkevn252).format('0,0.00'));

		var vrnegbrkevn251 = Number(vrbrkevnflat2) * 0.025;
		var vrnegbrkevn252 = Number(vrbrkevnflat2) - Number(vrnegbrkevn251);
		jQuery("#negbrkevn25").html(numeral(vrnegbrkevn252).format('0,0.00'));

		var vrnegbrkevn501 = Number(vrbrkevnflat2) * 0.05;
		var vrnegbrkevn502 = Number(vrbrkevnflat2) - Number(vrnegbrkevn501);
		jQuery("#negbrkevn50").html(numeral(vrnegbrkevn502).format('0,0.00'));

		var vrnegbrkevn751 = Number(vrbrkevnflat2) * 0.075;
		var vrnegbrkevn752 = Number(vrbrkevnflat2) - Number(vrnegbrkevn751);
		jQuery("#negbrkevn75").html(numeral(vrnegbrkevn752).format('0,0.00'));

		var vrnegbrkevn1001 = Number(vrbrkevnflat2) * 0.1;
		var vrnegbrkevn1002 = Number(vrbrkevnflat2) - Number(vrnegbrkevn1001);
		jQuery("#negbrkevn100").html(numeral(vrnegbrkevn1002).format('0,0.00'));

		var vrnegbrkevn2001 = Number(vrbrkevnflat2) * 0.2;
		var vrnegbrkevn2002 = Number(vrbrkevnflat2) - Number(vrnegbrkevn2001);
		jQuery("#negbrkevn200").html(numeral(vrnegbrkevn2002).format('0,0.00'));

	}

    jQuery('input').on("keyup", ".number", function (event) {
        // side bar calc
        // skip for arrow keys
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