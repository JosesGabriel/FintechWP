$(document).ready(function(){

    $(".gainers-title").click(function () {
        
        if($('.gainers').css('display') == 'none'){
            $('.gainers').slideDown();
        }else {
             $('.gainers').slideUp();
        }
    });


    $(".losers-title").click(function () {
        
        if($('.losers').css('display') == 'none'){
            $('.losers').slideDown();
        }else {
             $('.losers').slideUp();
        }
    });


    jQuery('.addwatch').click(function(e){
    jQuery(".dtabcontent > div").removeClass('active').hide('slow');
    jQuery(".dtabcontent .addwatchtab").addClass('active').show('slow');
            
            $.ajax({
                url: "/wp-json/data-api/v1/stocks/list",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                        
                    jQuery.each(res.data, function(index, value) {      
                            jQuery('.listofstocks').append('<a class="datastock_' + index + '" href="#" data-dstock="'+value.symbol+'">'+value.symbol+'</a>');
                            index++;        
                    });  

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                }
            });
               

    });

    jQuery('#canceladd').click(function(e){
        e.preventDefault();
        jQuery(".dtabcontent > div").removeClass('active').hide('slow');
        jQuery(".dtabcontent .watchtab").addClass('active').show('slow');
    });

    jQuery('#myDropdown').click(function(e){
                e.preventDefault();

                var dtyped = jQuery(this).val();
                
                if(jQuery(this).val().length < 1){
                    jQuery('.ddropbase').removeClass('opendrop').hide('slow');
                }

                if (jQuery(this).hasClass('disopen')) {
                    jQuery(this).removeClass('disopen');
                } else {
                    jQuery(this).addClass('disopen');
                    jQuery('.ddropbase').addClass('opendrop').show('slow');
                }

                jQuery('.stockerror.errorpop').remove();

    });


    jQuery( "#myDropdown" ).keyup(function(e) {
        e.preventDefault();

        var dtyped = jQuery(this).val();

        jQuery(".listofstocks > a").each(function(index){
            var istock = jQuery(this).attr('data-dstock');
            if (istock.toLowerCase().indexOf(dtyped) >= 0) {
                jQuery(this).show();
            } else {
                jQuery(this).hide();
            }
        });
    });

    jQuery(document).on('click','.ddropbase a',function(e){
        e.preventDefault();
        var dstock = jQuery(this).attr('data-dstock');

        jQuery('#myDropdown').val(dstock);
        jQuery('.ddropbase').removeClass('opendrop').hide('slow');

        jQuery(this).parents('.ddropbase').find('#dstockname').val(dstock);

       
    });

     jQuery('#submitmenow').click(function(e){
              e.preventDefault();

              var isstock = jQuery(this).parents('#add-watchlist-param').find("#dstockname").val();         
             //var countli = jQuery(".listofinfo li").length;
             //if (countli != 0) {
               if (isstock != "" && jQuery("#add-watchlist-param input:checkbox:checked").length > 0 ) {
                      jQuery("#add-watchlist-param").submit();
                  $('.chart-loader').css("display","block");
                  $(this).hide();
             }
              //}
           });


});