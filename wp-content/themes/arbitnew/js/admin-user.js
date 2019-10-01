(function($) {
    jQuery(document).ready(function() {
//     	let r = Math.random().toString(36).substring(7);

		jQuery("#gencode").click(function(e){
			e.preventDefault();
			var rnum = Math.random().toString(36).substr(2, 8);

			jQuery(this).parents(".dgencode").find(".dcodegenerated").text(rnum).show('slow');
			jQuery(this).parents(".dgencode").find(".dcode").val(rnum);

			jQuery(this).parents(".dgencode").find(".subbuttons").show('slow');

		});

		jQuery(".dbox .innerbox").click(function(){
			if (jQuery(this).find('.stocknum').hasClass('hidedis')) {
				jQuery(this).find('.stocknum').removeClass('hidedis');
			} else {
				jQuery(this).find('.stocknum').addClass('hidedis');
			}

			if (jQuery(this).find('.stockperc').hasClass('hidedis')) {
				jQuery(this).find('.stockperc').removeClass('hidedis');
			} else {
				jQuery(this).find('.stockperc').addClass('hidedis');
			}
		});


    });
})(jQuery);