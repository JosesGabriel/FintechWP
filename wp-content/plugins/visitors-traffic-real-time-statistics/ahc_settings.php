<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script language="javascript" type="text/javascript">
    function imgFlagError(image) {
	image.onerror = "";
	image.src = "<?php echo plugins_url('/images/flags/noFlag.png', AHCFREE_PLUGIN_MAIN_FILE) ?>";
	return true;
    }
</script>
<style type="text/css">
    i{
	color:#999	
    }
</style>

<?php
ahcfree_include_scripts();$msg = '';
if (!empty($_POST['save'])) {
    if (ahcfree_savesettings()) {
		$msg = ('<br /><b style="color:green; margin-left:30px; float:left">settings saved successfully</b><br /><b style="float:left;  margin-left:30px;"><a href="admin.php?page=ahc_hits_counter_settings">back to settings</a> | <a href="admin.php?page=ahc_hits_counter_menu_free">back to dashboard</a></b>');
    }
}

$ahcfree_get_save_settings = ahcfree_get_save_settings();

$hits_days = $ahcfree_get_save_settings[0]->set_hits_days;
$ajax_check = ($ahcfree_get_save_settings[0]->set_ajax_check * 1000);
$set_ips = $ahcfree_get_save_settings[0]->set_ips;
$set_google_map = $ahcfree_get_save_settings[0]->set_google_map;
$delete_plugin_data = get_option('ahcfree_delete_plugin_data_on_uninstall');
?>
<div class="ahcfree_main_container" >

    <h1><img width="40px" src="<?php echo plugins_url('/images/logo.png', AHCFREE_PLUGIN_MAIN_FILE) ?>">&nbsp;Visitors Traffic Real Time Statistics  <a title="change settings" href="admin.php?page=ahc_hits_counter_settings"><img src="<?php echo plugins_url('/images/settings.jpg', AHCFREE_PLUGIN_MAIN_FILE) ?>" /></a></h1><br />
    <div class="panel">
        <h2 style="height:35px !important; font-size:13px !important">Settings</h2>
	<div class="panelcontent">

	    <form method="post"  enctype="multipart/form-data" name="myform">
		


		<div class="row">

				<div class="form-group col-md-6">
				
					<label for="exampleInput">show hits in last</label>
					<input type="text" value="<?php echo $hits_days ?>" class="form-control" id="set_hits_days" name="set_hits_days" placeholder="Enter number of days">
					<small id="Help" class="form-text text-muted">this will affect the chart in the statistics page. default: 30 day</small>
				</div>
				
				<div class="form-group col-md-6">
				<label for="exampleFormControlSelect1">Select Timezone</label>
					<select class="form-control" id="set_custom_timezone" name="set_custom_timezone">
					 
					<?php
				    $custom_timezone_offset = get_option('ahcfree_custom_timezone');
				    $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
				    foreach ($timezones as $key => $value) {
					?>
    				    <option value="<?php echo $value; ?>" <?php echo ( $value == $custom_timezone_offset ) ? 'selected' : ''; ?>><?php echo $value; ?></option>
					<?php
				    }
				    ?>
					</select>
				</div>
					
		</div>
			
			
				
			<div class="row">	
				
				
				
				<div class="form-group col-md-6">
					<label for="exampleInput">IP's to exclude</label>
					<textarea placeholder='192.168.0.1' name="set_ips" id="set_ips" rows="3"  class="form-control" ><?php echo $set_ips ?></textarea>
					<small id="Help" class="form-text text-muted">Excluded IPs will not be tracked by your counter, enter IP per line</small>
				</div>
				
				</div>
			<div class="row">								<div class="form-group col-md-6">					<label for="exampleInput">Stats Data</label>					<p> <label style="color:red"><input type="checkbox" value="1" name="delete_plugin_data" <?php echo ($delete_plugin_data == 1) ? 'checked=checked' : ''; ?> > If checked, all the stats will be deleted on deleting plugin. </label></p>			    <br />					</div>
			</div>			</div>
		    </div>
		    <input type="submit" name="save" value="save settings" style="font-size:15px" />
		    <input type="button" name="cancel" value="back to dashboard" onclick="javascript:window.location.href = 'admin.php?page=ahc_hits_counter_menu_free'" style="font-size:15px" />
		</div><?phpecho $msg;	?>
	    </form>
	