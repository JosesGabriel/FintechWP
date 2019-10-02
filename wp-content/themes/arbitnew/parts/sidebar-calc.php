<div id="toghandle" class="add-postsis xazha" style="display: none;">


<div class="arb_calcbox">
<div class="bkcalcbox">
	<span><span class="toborderbotcalc"><strong>Buy/Sell</strong> Calculator</span><i class="fas fa-times toclassclose"></i></span>
	<div style="padding-top: 10px;padding-bottom: 12px;">
		<div class="arb_calcbox_left">Number of Shares: </div>
		<div class="arb_calcbox_right">
			<input name="numofshares" id="numofshares" class="_fottns number" type="text" placeholder="0" style="width:100%;">
		</div>
	</div>
	<div class="arb_calcbox_lefting">
	<div class="arb_dvdr"></div>
		<div class="padbott"><span class=" bit_asda">
		<!-- <strong>Buy Price:</strong></span> <input name="buyprice" id="buyprice" class="_fottns" type="number" value="0"> -->
		<div class="arb_calcbox_left">Buy Price: </div>
		<div class="arb_calcbox_right">
			<input name="buyprice" id="buyprice" type="text" class="number" placeholder="0" style="width:80%;">
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
				<input name="sellprice" id="sellprice" class="_fottns number" type="text" style="width:80%;" placeholder="0">
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


</div>