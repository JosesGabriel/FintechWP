jQuery(document).ready(function(){
    jQuery('.add-funds-show').show();
    jQuery('.add-funds-shows').hide();
    var x = 0;
    var y = 0;

    jQuery(".show-button2").click(function(e){
        e.preventDefault();
        jQuery('.add-funds-shows').hide();
        jQuery('.add-funds-show').show();
    });
    jQuery(".show-button1").click(function(e){
        e.preventDefault();
        jQuery('.add-funds-show').hide();
        jQuery('.add-funds-shows').show();
    });
    // jQuery('td[name=tcol1]')
    jQuery('.textfield-buyprice').keyup(function(){
        
        var inputVal = jQuery(this).val().length;													
        if(inputVal != 0){
            $('.confirmtrd').prop('disabled', false);
             x = 1;

        }else{
            $('.confirmtrd').prop('disabled', true);
        }
    });

    jQuery('.textfield-quantity').keyup(function(){
        var inputVal2 = jQuery(this).val().length;
        if(inputVal2 != 0){
            y = 1;
        }
    });

    $(".confirmtrd").click(function(e){

        console.log('==>');
        //if(x == 1 && y == 1) {
            $('.chart-loader').css("display","block");
            $(this).hide();
        //}
        
    });

});