// BOF Trending Stocks
    jQuery(function(){

        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        };
        var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
        var dcount = 0;
        jQuery('.top-stocks .to-content-part ul .even span, .top-stocks .to-content-part ul .odd span').each(function(index,el){
            if (dcount == '10') {dcount = 0; }
            jQuery(el).css('border-color',colors[dcount]);
            dcount++;
        });
    });
    
    jQuery(document).ready(function(){
        jQuery(".stocks-hidden-content").click(function () {
            jQuery(".trend-content-hidden").toggle('slow');
            if(jQuery(".stocks-hidden-content").hasClass('isopen')){
                jQuery(".stocks-hidden-content").html('<i class="fas fa-sort-down" id="fa-up" style="bottom: 0px;top: -2px;position: relative;font-size: 16px;margin-right: 4px;vertical-align: initial;"></i><strong>Show more</strong>').removeClass('isopen').slideDown( "slow" );
                jQuery(".trend-content-hidden").slideUp( "slow" );
            }else {
                jQuery(".stocks-hidden-content").html('<i class="fas fa-sort-up" id="fa-up" style="bottom: 0;top: 4px;position: relative;font-size: 16px;margin-right: 4px;vertical-align: initial;"></i><strong>Hide</strong>').addClass('isopen');
                jQuery(".trend-content-hidden").slideDown( "slow" );
            }
        });
    });
// EOF Trending Stocks