
<div class="drefmencontent">
	<div class="drefmeninner">
		<div class="leftpart">
			<div class="innerleft">
				<div class="dcode"><?php echo $ismentorrefer; ?></div>
				<div class="dsidemenu">
					<div class="welcomenote">Hello Superadmin!</div>
					<ul>
						<li class="two"><a href="/chart/">Interactive Chart</a></li>
						<li class="three"><a href="/journal/">Trading Journal</a></li>
						<li class="five"><a href="#">Watcher & Alerts</a></li>
						<li class="one"><a href="#">Power Tools</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="rightpart">
			<div class="innerright">
				<div class="row">
					<div class="col-md-4 ditem">
						<div class="dtitle">Number of Members</div>
						<div class="dvalue">250</div>
					</div>
					<div class="col-md-4 ditem">
						<div class="dtitle">Number of Mentors</div>
						<div class="dvalue">9</div>
					</div>
					<div class="col-md-4 ditem">
						chart here
					</div>
					<br class="clear">
				</div>
				<div class="row">
					<div class="col-md-8 ditem">
						<div class="dtitle">Mentors</div>
						<div class="dlist">
							<div class="dlistinner dmentorblock">
								<ul>
									<li>
										<div class="duserperson">Name</div>
							    		<div class="dcomission">Followers</div>
							    		<div class="dcomission">Total Commission</div>
									</li>
									<?php
										// get userst hat have used the code
										$args = array(
										    'role'    => 'Administrator',
										    'orderby' => 'user_nicename',
										    'order'   => 'ASC'
										);
										$users = get_users( $args );
										foreach ($users as $user) {
										    $firstName = get_user_meta($user->ID, 'first_name', true);
										    $lastName = get_user_meta($user->ID, 'last_name', true);
										    $mentorrefcode = get_user_meta($user->ID, 'refformentor', true);

										    $args = array(
											    // 'role' => 'subscriber',
											    'meta_query' => array(
											        array(
											            'key' => 'refforuser',
											            'value' => $mentorrefcode,
											            'compare' => '=='
											        )
											    )
											);
											$users = get_users( $args );


										    ?>
										    	<li>
										    		<div class="duserperson">
										    			<a href="#" data-toggle="modal" data-target="#mentorx<?php echo $user->ID; ?>">
										    				<?php if ($firstName != "" || $lastName != ""): ?>
										    					<?php echo $firstName . ' ' . $lastName; ?>
										    				<?php else: ?>
										    					<?php echo $user->data->user_login; ?>
										    				<?php endif; ?>
									    				</a>
										    			<div class="modal fade dadminusermods" id="mentorx<?php echo $user->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLongTitle"><?php echo $firstName . ' ' . $lastName; ?></h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div class="innermods">
																			<div class="row">
																				<div class="col-md-4">
																					<div class="dprofilepic">
																						<div class="dprofpicinner">
																							<img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>">
																						</div>
																					</div>
																				</div>
																				<div class="col-md-8">
																					<div class="dprofiledata">
																						<div class="dprofdatainner">
																							<div class="dseparator">
																								<h3>Profile Information</h3>
																							</div>
																							<div class="dpditem">
																								<!-- <div class="dpdlabel">Email</div> -->
																								<div class="dpdvals">
																									<a href="mailto:<?php echo $user->user_email; ?>"><?php echo $user->user_email; ?></a>
																								</div>
																							</div>
																						</div>
																					</div>
																					<div class="dprofdatainner">
																						<div class="dseparator">
																							<h3>Reference Code</h3>
																						</div>
																						<div class="dpditem">
																							<div class="dpdlabel">Reference Code: <?php echo $mentorrefcode; ?></div>
																						</div>
																						<div class="row">
																							<div class="col-md-6">
																								<div class="dfollowsinner">
																									<div class="dtitle">Free Followers</div>
																									<div class="dvalue">100</div>
																								</div>
																							</div>
																							<div class="col-md-6">
																								<div class="dfollowsinner">
																									<div class="dtitle">Paid Followers</div>
																									<div class="dvalue">100</div>
																								</div>
																							</div>
																							<br class="clear">
																						</div>
																					</div>
																					<div class="dprofdatainner">
																						<div class="dseparator">
																							<h3>Comission Info</h3>
																						</div>
																						<div class="dpditem">
																							<!-- <div class="dpdlabel">Email</div> -->
																							<div class="dpditem">
																								<div class="dpdlabel">Last Billed Date</div>
																								<div class="dpdvals"></div>
																							</div>
																							<div class="dpditem">
																								<div class="dpdlabel">Last Billed Reciept</div>
																								<div class="dpdvals"></div>
																							</div>
																						</div>
																					</div>
																					</div>
																				</div>
																			</div>
																	
																		</div>
																	<!-- <div class="modal-footer">
																		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																		<button type="button" class="btn btn-primary">Save changes</button>
																	</div> -->
																</div>
															</div>
														</div>
										    		</div>
										    		<div class="dcomission">
										    			<a href="#" data-toggle="modal" data-target="#dmodfollows<?php echo $user->ID; ?>"><?php echo count($users); ?></a>
										    			<!-- Button trigger modal -->

														<!-- Modal -->
														<div class="modal fade dmentorfollowmodalb" id="dmodfollows<?php echo $user->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
															<div class="modal-dialog modal-dialog-centered" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<!-- <h5 class="modal-title" id="exampleModalLongTitle">
																			<?php echo count($users); ?> Follower(s)
																		</h5> -->
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																		<?php if (count($users) > 0): ?>
																			<ul>
																				<li>
																	    		<div class="duserperson">Name</div>
																	    		<div class="dactivesince">Registration Date</div>
																	    		<div class="dcomission">&nbsp;</div>
																	    	</li>
																			<?php
																				foreach ($users as $user) {
																				    $firstName = get_user_meta($user->ID, 'first_name', true);
																				    $lastName = get_user_meta($user->ID, 'last_name', true);
																				    $userlogin = get_user_meta($user->ID, 'user_login', true);
																				    ?>
																				    	<li>
																				    		<div class="duserperson">
																				    			<a href="/user/<?php echo $user->data->user_login; ?>"><?php echo $firstName . ' ' . $lastName; ?></a>
																				    		</div>
																				    		<div class="dactivesince"><?php echo date("F j, Y", strtotime($user->data->user_registered)); ?></div>
																				    		<div class="dcomission">Free User</div>
																				    	</li>
																				    <?php
																				    
																				}

																			?>
																			</ul>
																		<?php else: ?>
																			<h3 class="notifcenter">No Followers Yet</h3>
																		<?php endif ?>
																	</div>
																	<!-- <div class="modal-footer">
																		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																		<button type="button" class="btn btn-primary">Save changes</button>
																	</div> -->
																</div>
															</div>
														</div>
										    		</div>
										    		<div class="dcomission">Php 80,000</div>
										    	</li>
										    <?php
										    
										}

									?>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-4 ditem">
						stats here
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 ditem">
						stats here
					</div>
					<div class="col-md-6 ditem">
						<div class="dtitle">Members</div>
						<div class="dlist">
							<div class="dlistinner dmemberblock">
								<ul>
									<li>
										<div class="duserperson">Name</div>
							    		<!-- <div class="dactivesince">Reference Code</div> -->
							    		<div class="dcomission">Member since</div>
									</li>
									<?php
										// get userst hat have used the code
										$args = array(
										    'role'    => 'Subscriber',
										    'orderby' => 'user_registered',
										    'order'   => 'ASC'
										);
										$users = get_users( $args );
										foreach ($users as $user) {
										    $firstName = get_user_meta($user->ID, 'first_name', true);
										    $lastName = get_user_meta($user->ID, 'last_name', true);
										    $userrefcode = get_user_meta($user->ID, 'refforuser', true);
										    ?>
										    	<li>
										    		<div class="duserperson">
										    			<a href="#" data-toggle="modal" data-target="#userx<?php echo $user->ID; ?>"><?php echo $firstName . ' ' . $lastName; ?></a>
										    			<div class="modal fade dadminusermods" id="userx<?php echo $user->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLongTitle"><?php echo $firstName . ' ' . $lastName; ?></h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div class="innermods">
																			<div class="row">
																				<div class="col-md-4">
																					<div class="dprofilepic">
																						<div class="dprofpicinner">
																							<img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>">
																						</div>
																					</div>
																				</div>
																				<div class="col-md-8">
																					<div class="isfreerow">
																						<div class="isfreeinner">
																							<div class="dusertype">Premium</div>
																						</div>	
																					</div>
																					<div class="dprofiledata">
																						<div class="dprofdatainner">
																							<div class="dseparator">
																								<h3>Profile Information</h3>
																							</div>
																							<div class="dpditem">
																								<!-- <div class="dpdlabel">Email</div> -->
																								<div class="dpdvals">
																									<a href="mailto:<?php echo $user->user_email; ?>"><?php echo $user->user_email; ?></a>
																								</div>
																							</div>
																						</div>
																					</div>
																					<?php if ($userrefcode != ""): ?>
																						<div class="dprofdatainner">
																							<div class="dseparator">
																								<h3>Reference Code</h3>
																							</div>
																							<div class="dpditem">
																								<div class="dpdlabel">Reference Code: <?php echo $userrefcode; ?></div>
																							</div>
																							<div class="dpditem">
																								<div class="dpdlabel">Reference Name</div>
																								<div class="dpdvals"></div>
																							</div>
																						</div>
																					<?php endif ?>
																					<div class="dprofdatainner">
																						<div class="dseparator">
																							<h3>Billing Info</h3>
																						</div>
																						<div class="dpditem">
																							<!-- <div class="dpdlabel">Email</div> -->
																							<div class="dpditem">
																								<div class="dpdlabel">Last Billed Date</div>
																								<div class="dpdvals"></div>
																							</div>
																							<div class="dpditem">
																								<div class="dpdlabel">Last Billed Reciept</div>
																								<div class="dpdvals"></div>
																							</div>
																						</div>
																					</div>
																					</div>
																				</div>
																			</div>
																	
																		</div>
																	<!-- <div class="modal-footer">
																		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																		<button type="button" class="btn btn-primary">Save changes</button>
																	</div> -->
																</div>
															</div>
														</div>
										    		</div>
										    		<!-- <div class="dactivesince"><?php echo $userrefcode; ?></div> -->
										    		<div class="dcomission"><?php echo date("M. Y", strtotime($user->data->user_registered)); ?></div>
										    		
										    	</li>
										    <?php
										    
										}

									?>
								</ul>
							</div>
						</div>
					</div>
					<br class="clear">
				</div>
			</div>
		</div>
		<br class="clear">
	</div>
</div>