<?php
	/*
	* Template Name: Password Confirmation
	*/

// get_header();
// $setrand = rand(1,12);
// $get_bgfimage = "loginbg".$setrand.".jpg";
?>

<div class="ondashboardpage_login">
	<div class="ondashboardpage_login_inner">
        <img src="<?php echo $homeurlgen; ?>/wp-content/themes/arbitrage-child/cd/img/Asset 4.png" style="width:102px;">
        <form id="pass-reset">

            <Label>New Password</Label>
            <input type="text" required class="pass-info" id="new_old">

            <Label>Confirm New Password</Label>
            <input type="text" required class="pass-info" id="new_onf_old">

            <input type="submit" value="Update Password" id="pass_btn_info">
        </form>
    </div>
</div>


<div class="arb_copy">Arbitrage &copy; <?php echo date("Y"); ?></div>
<script type="text/javascript">
	$(document).ready(function(){
		// $("#pass_btn_info").submit(function(){
        //         var hasemail = jQuery("#email--input").val().length;
        //         var email = jQuery("#email--input").val();
        //         if( hasemail >= 1 ) {
        //             jQuery.ajax({
        //                 method: "POST",
        //                 url: "https://arbitrage.ph/apipge/?daction=password_reset",
        //                 data: {
        //                     'mail' : email
        //                 },
        //                 success: function(data) {
        //                     jQuery("#email__text").show();
        //                 },
        //                 error: function(requestObject, error, errorThrown) {
        //                 }
        //             });
        //         }
        //     });
	});
</script>

<?php //get_footer();