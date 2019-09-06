<div class="dtanks">

	<h5>Top Players</h5>
	<hr class="style14 style15" style="width: 100% !important;margin-bottom: 5px !important;margin-top: 10px !important;">
		<div class="ranks">
			<!-- <h5>Ranks</h5> -->

							<?php

								$curl = curl_init();

								curl_setopt($curl, CURLOPT_URL, 'https://game.arbitrage.ph/api/getranking' );

								curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

								$dranks = curl_exec($curl);

								curl_close($curl);



								$dranks = json_decode($dranks, true);



								function sortrank($a, $b) {

								    return $b['dtotalbal'] - $a['dtotalbal'];

								}



								usort($dranks, 'sortrank');

							?>

							<ul class="topsect">
								<?php  $plcnt = 0; ?>

								<?php $isfive = array_slice($dranks, 0, 3); ?>
								<?php foreach ($isfive as $key => $value) { ?>
									<?php $plcnt++; ?>
									<li>
										<div class="hudbadge">
											<?php if($plcnt == 1) { ?>
												<img src="<?php echo get_home_url(); ?>/svg/top2.svg" alt="">
											<?php }else if($plcnt == 2) { ?>
												<img src="<?php echo get_home_url(); ?>/svg/top3.svg" alt="">
											<?php }else if($plcnt == 3) { ?>
												<img src="<?php echo get_home_url(); ?>/svg/top4.svg" alt="">
											<?php } ?>
									   	</div>

									    <div class="playerscontent">
											<div class="isname">
												<?php 
												//echo ucwords($value['dbsname']) 

													$uname = $value['dbsname'];
													if (strlen($uname) > 17){
												      		echo substr($uname, 0, 17) . "..."; 
												  		}else{
												  			echo $uname;
												  		}
																							

												?>
												
											</div>
												<div class="istotal"><?php 
													$totalvaluee = $value['dtotalbal'];
													$equityres = $totalvaluee - 100000;
													$resres = $equityres / 100000;
													$finalres = $resres * 100;

													?>
															<span class="value-t"><?php echo " ₱ " . number_format($totalvaluee, 2, '.', ','); ?></span>
															<span class="profit_loss" style="float:right;margin-left: 20px;"><?php echo " ₱ " . number_format($equityres, 2, '.', ','); ?></span>
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
											<div class="isname">

												<?php 
													$uname = $value['dbsname'];
													if (strlen($uname) > 17){
												      		echo substr($uname, 0, 17) . "..."; 
												  		}else{
												  			echo $uname;
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
													<?php  if($equityres != 0) { ?>
															<span class="profit_loss" style="float:right;margin-left: 20px;"><?php echo " ₱ " . number_format($equityres, 2, '.', ','); ?></span>
														<?php } ?>
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
						<script type="text/javascript">

							jQuery(".othersect").hide();
							jQuery(".viewmoreplayers").click(function(){
								jQuery(".othersect").toggle('1000');

								if( $(".viewmoreplayers").text() == "View more"){
									  $(".viewmoreplayers").text("Hide");
									}
								else{
									 $(".viewmoreplayers").text("View more");
								}	 							

							});
						</script>

					</div>