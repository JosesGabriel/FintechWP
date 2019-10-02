<div class="record_modal">
	<div class="record_main">
		<div class="record_header">
			<span class="record_head_label">Record A Trade<i class="fas fa-close to_closethis_rec"></i></span>
		</div>
		<form action="/journal" method="post">
			<div class="record_body row">
				<div class="col-md-6" style="border-right: 1px solid #1c2d3f;">
					<span class="label_thisleft">Bought</span>
					<div class="groupinput midd rec_label_date">
						<label>Enter Date</label><input type="date" name="boughtdate" class="inpt_data_boardlot_get buySell__date-picker" required="" id="" max="2019-09-16">
					</div>
					<div class="groupinput midd lockedd"><label>Stock</label>
						<!-- <input type="text" name="inpt_data_stock" id="inpt_data_stock" style="margin-left: -3px; text-align: left;" value="" readonly> -->
						<select name="inpt_data_stock_bought" id="inpt_data_stock_bought" style="margin-left: -4px; text-align: left;width: 138px;">
							<option value="">Select Stocks</option>
							<?php foreach($listosstocks as $dstkey => $dstvals): ?>
								<option value='<?php echo $dstvals->symbol; ?>'><?php echo $dstvals->symbol; ?></option>
							<?php endforeach; ?>
						</select>
						<input type="hidden" name="inpt_data_stock" id="dfinstocks">
						<!-- <i class="fa fa-lock" aria-hidden="true"></i> -->
					</div>
					<div class="groupinput midd"><label>Enter Price</label><input type="text" id="" name="inpt_data_price_bought" class="textfield-buyprice number" required></div>
					<div class="groupinput midd" style="margin-bottom: 5px;"><label>Quantity</label><input type="text" id="" name="inpt_data_qty_bought" class="textfield-quantity number" required></div>
					<div class="groupinput midd lockedd label_cost"><label>Total Cost: </label><input readonly="" type="text" class="number" name="inpt_data_total_bought_price" value="0.00"><i class="fa fa-lock" aria-hidden="true" style="display:none;"></i></div>
				</div>

				<div class="col-md-6">
					<span class="label_thisright">Sold</span>
					<div class="groupinput midd rec_label_date">
						<label>Enter Date</label><input type="date" name="solddate" class="inpt_data_boardlot_get buySell__date-picker" required="" id="" max="2019-09-16">
					</div>
					<div class="groupinput midd"><label>Enter Price</label><input type="text" id="" name="inpt_data_price_sold" class="textfield-buyprice number" required></div>
					<div class="groupinput midd" style="margin-bottom: 5px;"><label>Quantity</label><input type="text" id="" name="inpt_data_qty_sold" class="textfield-quantity number" required></div>
					<div class="groupinput midd lockedd label_cost"><label>Total Cost: </label><input readonly="" type="text" class="number" name="inpt_data_total_sold_price" value="0.00"><i class="fa fa-lock" aria-hidden="true" style="display:none;"></i></div>
					<div class="groupinput midd lockedd label_cost"><label>Profit/Loss: </label><input readonly="" type="text" class="number" name="inpt_data_total_sold_profitloss" value="0.00"><i class="fa fa-lock" aria-hidden="true" style="display:none;"></i></div>
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
								<option value="Neutral">Neutral</option>
								<option value="Greedy">Greedy</option>
								<option value="Fearful">Fearful</option>
							</select>
						</div>
					</div>
					<div class="groupinput">
						<textarea class="darktheme" name="inpt_data_tradingnotes" onClick="this.value = ''">Trading Notes</textarea>
						<!-- <div>this is it</div> -->
					</div>
					</div>
			</div>
			<div class="record_footer row">
				<div class="dbuttonrecord_onmodal">
					<form action="" method="post" class="recordform">
						<!-- <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none; float: right;margin-right: 10px;"> -->
						<input type="hidden" name="recorddata" value="record">
						<input type="hidden" name="inpt_data_status" value="record">
						<input type="submit" name="record" value="Record" class="record-data-btn recorddata">
					</form>
				</div>
			</div>
		</form>
	</div>
</div>