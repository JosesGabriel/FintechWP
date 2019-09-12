<?php

    function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n/1000000000000), 2).' Trillion';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).' Billion';
        elseif ($n > 1000000) return round(($n/1000000), 2).' Million';
        elseif ($n > 1000) return round(($n/1000), 2).' Thousand';

        return number_format($n);
    }


?>

<div class="dtanks">

	<h5>Top Players</h5>
	<hr class="style14 style15" style="width: 100% !important;margin-bottom: 5px !important;margin-top: 10px !important;">
		<div class="ranks">
			<!-- <h5>Ranks</h5> -->

			<?php

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, 'https://game.arbitrage.ph/api/getranking' );
				curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$dranks = curl_exec($curl);
				curl_close($curl);

				$dranks = json_decode($dranks, true);

				function sortrank($a, $b) { return $b['dtotalbal'] - $a['dtotalbal']; }

				usort($dranks, 'sortrank');

			?>

			<ul class="topsect">
				<?php  $plcnt = 0; ?>

				<?php $isfive = array_slice($dranks, 0, 3); ?>
				<?php foreach ($isfive as $key => $value) { ?>
					<?php $plcnt++; ?>
					<li>
						<div class="hudbadge">
							<img src="<?php echo get_home_url(); ?>/svg/<?php echo ($plcnt == 1 ? "top2" : ($plcnt == 2 ? "top3" : "top4")); ?>.svg" alt="">
						</div>

						<div class="playerscontent">
								<div class="isname" style="width: 102px;">
									<?php 
										$uname = $value['dbsname'];
										echo (strlen($uname) > 12 ? substr($uname, 0, 12) . ".." : ucwords($uname));
									?>
								</div>
								<div class="istotal">
									<?php 
										$totalvaluee = $value['dtotalbal'];
										$equityres = $totalvaluee - 100000;
										$resres = $equityres / 100000;
										$finalres = $resres * 100;
									?>
									<span class="value-t"><?php echo " ₱ " . nice_number($totalvaluee);//number_format($totalvaluee, 2, '.', ','); 

									?></span>
				<span class="profit_loss" style="color:#24a65d;float:right;margin-left: 3px;position: absolute;top: 7px;width: 100px;text-align: right;"><?php echo " ₱ " . nice_number($equityres); //number_format($equityres, 2, '.', ','); 

					?></span>
									<?php if($finalres == 0) { ?>
											<span class="value-p" style="color: #a2adb9;"><?php echo number_format($finalres, 2, '.', ',') . " % "; ?></span>
									<?php }elseif($finalres >= 0) {?>
											<span class="value-p" style="color: #25ae5f;"><i class="fas fa-caret-up caret"></i><?php if($finalres >= '200.00' ){$thisisit = $finalres - '100.00';$thisisit = $thisisit + '100.00';}elseif( $finalres <= '200.00' ){$thisisit = $finalres + '0';}echo number_format($thisisit, 2, '.', ',') . " % "; ?></span>
									<?php }elseif($finalres <= 0) { ?>
											<span class="value-p" style="color: #e64c3c;"><i class="fas fa-caret-down caret"></i><?php echo number_format($finalres, 2, '.', ',') . " % "; ?></span>
									<?php } ?>
								</div>
							<?php ?>
						</div>
					</li>

				<?php } ?>

			</ul>
			<ul class="othersect">
				<?php  $plcnt = 3; ?>

				<?php $isfive = array_slice($dranks, 3, 2); ?>
				<?php foreach ($isfive as $key => $value) { ?>
					<?php $plcnt++; ?>
					<li>
						<div class="hudbadge">
							<?php if($plcnt == 4) { ?>
								<img src="<?php echo get_home_url(); ?>/svg/top5.svg" alt="">
							<?php }else if($plcnt == 5) { ?>
								<img src="<?php echo get_home_url(); ?>/svg/top5.svg" alt="">
							<?php } ?>
						</div>

						<div class="playerscontent">
							<div class="isname" style="width: 102px;">

								<?php 
									$uname = $value['dbsname'];
									if (strlen($uname) > 13){
											echo substr($uname, 0, 13) . ".."; 
										}else{
											echo ucwords($uname);
										}
									//echo ucwords($value['dbsname']) 

								?>
								
							</div>
								<div class="istotal"><?php 
									$totalvaluee = $value['dtotalbal'];
									$equityres = $totalvaluee - 100000;
									$resres = $equityres / 100000;
									$finalres = $resres * 100;
									?>
									<span class="value-t"><?php echo " ₱ " . number_format($totalvaluee, 2, '.', ','); ?></span>
											<span class="profit_loss" style="color:#24a65d;float:right;margin-left: 3px;position: absolute;top: 7px; text-align: right;width: 100px;"><?php echo " ₱ " . number_format($equityres, 2, '.', ','); ?></span>
									<?php if($finalres == 0) { ?>
											<span class="value-p" style="color: #a2adb9;"><?php echo number_format($finalres, 2, '.', ',') . " % "; ?></span>
									<?php }elseif($finalres >= 0) {?>
											<span class="value-p" style="color: #25ae5f;"><i class="fas fa-caret-up caret"></i><?php if($finalres >= '200.00' ){$thisisit = $finalres - '100.00';$thisisit = $thisisit + '100.00';}elseif( $finalres <= '200.00' ){$thisisit = $finalres + '0';}echo number_format($thisisit, 2, '.', ',') . " % "; ?></span>
									<?php }elseif($finalres <= 0) { ?>
											<span class="value-p" style="color: #e64c3c;"><i class="fas fa-caret-down caret"></i><?php echo number_format($finalres, 2, '.', ',') . " % "; ?></span>
									<?php } ?>
								</div>
							<?php ?>
						</div>
					</li>

				<?php } ?>

			</ul>
			<a class="viewmoreplayers">View more</a>
		</div>

	</div>