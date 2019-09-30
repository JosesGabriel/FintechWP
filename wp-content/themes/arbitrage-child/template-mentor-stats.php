<?php
	$ismentorrefer = get_user_meta(get_current_user_id(), 'refformentor', true);
?>
<?php if (isset($ismentorrefer)): ?>
	<div class="drefmencontent">
		<div class="drefmeninner">
			<div class="leftpart">
				<div class="innerleft">
					<div class="dcode"><?php echo $ismentorrefer; ?></div>
					<div class="dsidemenu">
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
					<div class="righttitle">
						List of Active Users
					</div>
					<ul class="listofcoms">
						<li>
				    		<div class="duserperson">Name</div>
				    		<div class="dactivesince">Registration Date</div>
				    		<div class="dcomission">Comission</div>
				    	</li>
						<?php
							// get userst hat have used the code
							$args = array(
							    // 'role' => 'subscriber',
							    'meta_query' => array(
							        array(
							            'key' => 'refforuser',
							            'value' => $ismentorrefer,
							            'compare' => '=='
							        )
							    )
							);
							$users = get_users( $args );
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
							    		<div class="dcomission">Php 80.00</div>
							    	</li>
							    <?php
							    
							}

						?>
					</ul>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>
<?php else: ?>
	<form action="" method="post">
		<div class="dgencode">
			<a href="#" id="gencode">Generate Reference Code</a>
			<div class="dcodegenerated" style="display: none;">&nbsp;</div>
			<input type="hidden" class="dcode" name="dcode">
			<input type="submit" class="subbuttons" name="subcode" value="Save Code" style="display: none;">
		</div>
	</form>
<?php endif; ?>