<?php
	/*
	* Template Name: Email Pass Confirmation
	*/

// get_header();
// $setrand = rand(1,12);
// $get_bgfimage = "loginbg".$setrand.".jpg";
?>

<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

<div class="ondashboardpage_login">
	<div class="ondashboardpage_login_inner">
        <img src="<?php echo $homeurlgen; ?>/wp-content/themes/arbitrage-child/cd/img/Asset 4.png" style="width:102px;">
        <form id="email_pass_reset">

            <span>Please enter your email address below</span>
            <input type="email" required class="email-info" id="email_info">

            <input type="submit" value="Reset" id="email_btn_info">
        </form>
    </div>
</div>


<div class="arb_copy">Arbitrage &copy; <?php echo date("Y"); ?></div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#email_pass_reset").click(function(event){
                
                var hasemailinfo = jQuery("#email_info").val().length;
                var emailinfo = jQuery("#email_info").val();
                if( hasemailinfo >= 1 ) {
                    jQuery.ajax({
                        method: "POST",
                        url: "https://arbitrage.ph/apipge/?daction=email_pass_reset",
                        data: {
                            'mail' : emailinfo
                        },
                        success: function(data) {
                            alert("Sucess");
                        },
                        error: function(requestObject, error, errorThrown) {
                        }
                    });
                }
                event.preventDefault();
            });
	});
</script>

<?php //get_footer();