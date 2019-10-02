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
                url: "https://data-api.arbitrage.ph/api/v1/stocks/list",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                }
            });
                var i = 0;
                jQuery.each(stocklist.data, function(index, value) {
                   
                        jQuery('.listofstocks').append('<a class="datastock_' + i + '" href="#" data-dstock="'+value.symbol+'">'+value.symbol+'</a>');
                        i++;        
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



});