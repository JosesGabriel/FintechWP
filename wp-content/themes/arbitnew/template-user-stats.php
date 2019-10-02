<?php
									

	function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' ) { 
		// date must be YYYY-MM-DD
		// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'
	    $interval = date_diff(date_create($date_1), date_create($date_2));
	    return $interval->format($differenceFormat);
	}
	$ismentorrefer = get_user_meta(get_current_user_id(), 'refforuser', true);
?>
<div class="dsubspage">
	<div class="dssinner">
		<div class="dleftpart">
			<div class="dsidemenu">
				<ul>
					<li class="two"><a href="/chart/">Interactive Chart</a></li>
					<li class="three"><a href="/journal/">Trading Journal</a></li>
					<li class="five"><a href="#">Watcher & Alerts</a></li>
					<li class="one"><a href="#">Power Tools</a></li>
				</ul>
			</div>
		</div>
		<div class="drightpart">
			<div class="duserinfo">
				<div class="ditem fullwid">
					<div class="ditinfolabel">Reference Code</div>
					<div class="ditinfovalue">	
						<?php echo $ismentorrefer;?>

						<a href="#" data-toggle="modal" data-target="#changecode">Change Reference Code</a>
						<!-- Modal -->
						<div class="modal fade" id="changecode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel" style="color: #333;">Change Reference code</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						        <div class="innermods">
						        	<form method="post" action="">
						        		<div class="dchangeitem">
						        			<input type="text" name="drefcodehere" value="<?php echo $ismentorrefer;?>">
						        		</div>
						        		<div class="dsubmit">
						        			<input type="hidden" name="dtype" value="change_from_user">
						        			<input type="submit" name="drefsubs" value="Submit">
						        		</div>
						        	</form>
						        	<div class=""></div>
						        </div>
						      </div>
						      <div class="modal-footer">
						        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						        <button type="button" class="btn btn-primary">Save changes</button> -->
						      </div>
						    </div>
						  </div>
						</div>
					</div>
				</div>
				<div class="ditem halfwid">
					<div class="ditinfolabel">Member for</div>
					<div class="ditinfovalue">
						<?php
							$dateregestered = date("Y-m-d", strtotime($user->data->user_registered));
							$dyear = dateDifference($currentdate,$dateregestered, '%y');
							$dmonth = dateDifference($currentdate,$dateregestered, '%m');
							$ddays = dateDifference($currentdate,$dateregestered, '%d');

							if ($ddays > 0) { echo $ddays.' Day(s) '; }
							if ($dmonth > 0) { echo $dmonth.' Month(s) '; }
							if ($dyear > 0) { echo $dyear.' Year(s) '; }
						?>
					</div>
				</div>
				<div class="ditem halfwid">
					<div class="ditinfolabel">Member Since</div>
					<div class="ditinfovalue">
						<?php echo date("F j, Y", strtotime($user->data->user_registered)); ?>
					</div>
				</div>
				<div class="ditem fullwid">
					<div class="ditinfolabel">Billing Statement</div>
					<div class="ditinfovalue">
						<div class="dbillitem dtitlebase">
							<div class="ddate">Date</div>
							<div class="drecieptnum">Reciept Number</div>
							<div class="dprice">&nbsp;</div>
						</div>
						<div class="dbillitem">
							<div class="ddate">January 20, 2018</div>
							<div class="drecieptnum">213ds3rrf</div>
							<div class="dprice">Php 400.00</div>
						</div>
						<div class="dbillitem">
							<div class="ddate">January 20, 2018</div>
							<div class="drecieptnum">213ds3rrf</div>
							<div class="dprice">Php 400.00</div>
						</div>
						<div class="dbillitem">
							<div class="ddate">January 20, 2018</div>
							<div class="drecieptnum">213ds3rrf</div>
							<div class="dprice">Php 400.00</div>
						</div>
						<div class="dbillitem">
							<div class="ddate">January 20, 2018</div>
							<div class="drecieptnum">213ds3rrf</div>
							<div class="dprice">Php 400.00</div>
						</div>
						<div class="dbillitem">
							<div class="ddate">January 20, 2018</div>
							<div class="drecieptnum">213ds3rrf</div>
							<div class="dprice">Php 400.00</div>
						</div>
						<div class="dbillitem">
							<div class="ddate">January 20, 2018</div>
							<div class="drecieptnum">213ds3rrf</div>
							<div class="dprice">Php 400.00</div>
						</div>
						<div class="dbillitem">
							<div class="ddate">January 20, 2018</div>
							<div class="drecieptnum">213ds3rrf</div>
							<div class="dprice">Php 400.00</div>
						</div>
						<div class="dbillitem">
							<div class="ddate">January 20, 2018</div>
							<div class="drecieptnum">213ds3rrf</div>
							<div class="dprice">Php 400.00</div>
						</div>
						<div class="dbillitem">
							<div class="ddate">January 20, 2018</div>
							<div class="drecieptnum">213ds3rrf</div>
							<div class="dprice">Php 400.00</div>
						</div>
						<div class="dbillitem">
							<div class="ddate">January 20, 2018</div>
							<div class="drecieptnum">213ds3rrf</div>
							<div class="dprice">Php 400.00</div>
						</div>
						<br class="clear">
					</div>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>
</div>