<script type="text/javascript">
    
    jQuery(window).on('load', function(){
        jQuery("#status, #status_txt").fadeOut();
        jQuery("#preloader").delay(400).fadeOut("slow");
        jQuery(".um-field-checkbox-option").html("");
        jQuery(".forgotpass-wrapper .um-button").val("Reset password");
    });
		
	jQuery(document).ready(function(){ 

        jQuery("#emailNotify__form").submit(function(){
            var hasemail = jQuery("#email--input").val().length;
            var email = jQuery("#email--input").val();
            if( hasemail >= 1 ) {
                jQuery.ajax({
                    method: "POST",
                    url: "/apipge/?daction=notify_me_email",
                    // url: 'https://api2.pse.tools/api/quotes',
                    data: {
                        'email' : email
                    },
                    success: function(data) {
                        jQuery("#email__text").show();
                    },
                    error: function(requestObject, error, errorThrown) {

                    }
                });
            }
        });

        jQuery('#um-submit-btn').val('Login');
        $( ".um-field-checkbox" ).append( "<span id='span_login_rememberme'>Remember Me</span>" );
        //$("div.um-col-alt").css("margin","0px");

		$(".login-form-wrapper a.um-button.um-alt.um-button-social.um-button-facebook").appendTo(".login-form-wrapper .ordash");
		$(".signup-form-wrapper a.um-button.um-alt.um-button-social.um-button-facebook").appendTo(".signup-form-wrapper .ordash");
		jQuery('a.um-button.um-alt.um-button-social.um-button-facebook').html('<i class="um-faicon-facebook"></i>');
		jQuery( '<div class="forgpasslnk"><span style="color: #949798;font-size: 11px;"></span><a href="<?php echo $homeurlgen; ?>/password-reset/?b=<?php echo $setrand; ?>" class="showpassreset">Forgot Password?</a></div>' ).insertAfter( ".um-login .um-field-c .um-field-checkbox" );
		jQuery(".um-register .um-field-type_password:last-child").addClass("confirmpasscls");
		jQuery("#user_password-9").addClass("arbtriggerpass");
		jQuery(".um-register .um-col-1").append("<div class='arb_accept'>By clicking Sign Up, you agree to our <a href='<?php echo get_home_url(); 
		?>/terms/' class='fancybox-iframe'>Terms</a> & <a href='<?php echo get_home_url(); ?>/policies/' class='fancybox-iframe'>Policies</a></div>");
		jQuery(".forgotpass-wrapper .um-field-block div").html("Please enter your email address below");
		jQuery(".forgotpass-wrapper #username_b").attr("placeholder", "Email Address");
		jQuery(".um-col-alt-b a.um-link-alt").hide();
		//jQuery("#loginform .um-form .um-row .um-col-1").append("<div class='tochecked_cont'><p class='forgetmenot'><label for='rememberme'><input name='rememberme' type='checkbox' id='rememberme' value='forever'  /> Remember Me | </label></p><span class='for_pass'> Forgot your password?</span></div>");
		// jQuery("#loginform .um-form .um-row .um-col-1").append("<div class='tochecked_cont'></span><span class='for_pass'>Forgot your password?</span></div>");
	
		
		jQuery(".hidepassreset").click(function(){
			jQuery(".forgotpass-wrapper").fadeOut(400, function(){
				jQuery(".hidefromreset").fadeIn(400);
			});
		});

		jQuery(".for_pass").click(function(){
			jQuery(".login-form").fadeOut(300, function(){
				jQuery(".email_pass_reset_cont").fadeIn(400);
			});
		});


		jQuery(".prtnr_login").click(function(){
			jQuery(".arb_circle_btns").fadeOut(400, function(){
				jQuery(".login-form").fadeIn(400, function(){
					jQuery(".ico_posbott_signup").fadeIn(400);
				});
			});
		});
		
		jQuery(".prtnr_signup").click(function(){
			jQuery(".arb_circle_btns").fadeOut(400, function(){
				jQuery(".signup-form").fadeIn(400, function(){
					jQuery(".ico_posbott_login").fadeIn(400);
				});
			});
		});
		
		jQuery("#switch_signup").click(function(){
			jQuery(".login-form").fadeOut(300, function(){
				jQuery(".signup-form").fadeIn(800);
			});
			
			jQuery(".email_pass_reset_cont").fadeOut(300, function(){
			});
			jQuery(".confirmed_cont").fadeOut(300, function(){
			});
			jQuery(".error_message").fadeOut(300, function(){
			});
			
			jQuery(".ico_posbott_signup").fadeOut(300, function(){
				jQuery(".ico_posbott_login").fadeIn(300);
			});
		});
        
		jQuery("#switch_login").click(function(){
			jQuery(".signup-form").fadeOut(300, function(){
				jQuery(".login-form").fadeIn(800);
			});
			
			jQuery(".ico_posbott_login").fadeOut(300, function(){
				jQuery(".ico_posbott_signup").fadeIn(300);
			});
		});
		
		jQuery(".arbtriggerpass").focusin(function(){
			jQuery(".um-register .um-field-type_password").animate({
				width: "50%",
			}, function(){
				jQuery(".confirmpasscls").animate({width: "50%"});
				jQuery(".confirmpasscls").append("<style>.um-register .um-field-type_password {width: 50% !important;}</style>");
			});	
		});
		
		if ( jQuery(".um-login .um-field div").hasClass("um-field-error") ){
			jQuery('.arb_circle_btns').css('display','none'); 
			jQuery('.prtnr_login').trigger('click'); 
			jQuery('.um-field:first-child .um-field-error').html('<span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>Please enter your email address')
		}
		
		if ( jQuery(".um-register .um-field div").hasClass("um-field-error") ){
			jQuery('.arb_circle_btns').css('display','none'); 
			jQuery('.prtnr_signup').trigger('click'); 
		}
		
		jQuery(".um-form-field.um-error").focusin(function(){
			jQuery(".um-field-error").fadeOut('fast');
		});
		
		jQuery(".um-button-social").attr('onClick','FBPopup(this.href); return false');
		function FBPopup(url) {
			popupWindow = window.open(url,'popUpWindow','height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
		}
		
	})
	.on('submit', '#email_pass_reset', function (e) {
            
            var email = jQuery("#email_info").val();
            var hasvalemail = jQuery("#email_info").val().length;

            var url = "<?php echo $homeurlgen; ?>/apipge/?daction=email_pass_reset&email="+email;
            jQuery.ajax({
                'url': url,
                'method': 'GET',
                'data': '',
                'dataType': 'json',
                'success': function (response) {
                    if (response.success) {
                        jQuery(".email_pass_reset_cont").hide();
                        jQuery(".confirmed_cont").show();
                        return;
                    }
                    jQuery('.error_message').show();
                    return;
                }
            })
            e.preventDefault();
		});
</script>
