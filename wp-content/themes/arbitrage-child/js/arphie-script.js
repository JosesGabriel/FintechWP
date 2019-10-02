jQuery(document).ready(function(){
		jQuery(".bbs_bull, .bbs_bear").click(function(e){
			e.preventDefault();
			var pathname = window.location.pathname;
			if (!jQuery(this).parents('.bullbearsents').hasClass('clickedthis')) {
				

				jQuery(this).parents('.bullbearsents').addClass("clickedthis");

				var dclass = jQuery(this).attr('class');

				var dpathl = pathname.split("/");
				
				// dpathl = dpathl.filter(function(el) { return el; });
				// dpathl = dpathl[(parseInt(dpathl.length) - 1)];

				// jQuery.ajax({
				//  	method: "POST",
				// 	url: "<?php echo admin_url( 'admin-ajax.php' );?>",
				// 	dataType: 'json',
				// 	data: {
				// 		'action' : 'post_sentiment',
				// 		'stock' : dpathl,
				// 		'postid' : '<?php echo get_the_id(); ?>',
				// 		'userid' : '<?php echo $user_id; ?>'
				// 	},
				// 	success: function(data) {
				// 	}
				// });

			}
		});

		jQuery( ".bbs_bull, .bbs_bear" ).click(function() {
		  jQuery( ".bbs_bear_bar, .bbs_bull_bar" ).fadeIn("fast",function(){
		  		jQuery( ".bullbearsents_label" ).animate({marginBottom: "-9px"},"slow");
		  });
		  jQuery( ".bbs_bear_bar" ).animate({
			width: "40%",
			marginTop: "11px"
		  },500, function(){
				jQuery( ".bbs_bear_bar span" ).fadeIn("fast");
			});
		  jQuery( ".bbs_bull_bar" ).animate({
			width: "30%",
			marginTop: "11px"
		  },500, function(){
				jQuery( ".bbs_bull_bar span" ).fadeIn("fast");
			});
		  jQuery(".bullbearsents_label").html("Members sentiments");
		});
	});