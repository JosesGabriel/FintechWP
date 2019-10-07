$(document).ready(function(){

    



function minichart(symbol, from, to){

 jQuery.ajax({
    url: "/wp-json/data-api/v1/charts/history?symbol=" + symbol + "&exchange=PSE&resolution=1D&from="+ from +"&to=" + to + "",
    type: 'GET',
    dataType: 'json',
    success: function(res) {

            var sdata = res.data.o;
            var counter = 0;
            var dhist = "";

        if(sdata.length != 0){

            for (var i = 0; i < sdata.length; i++) {
                dhist = '{"date": ' + (i + 1) + ', "open:" ' + res.data.o[i] + ', "high": ' + res.data.h[i] + ', "low": ' + res.data.l[i] + ', "close": ' + res.data.l[i] + '},' + dhist;
                counter++;
            }

        }

        jQuery('.minchart_' + symbol).val(dhist);

    },
    error: function (xhr, ajaxOptions, thrownError) {

    }

});

    }

 
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
              jQuery("#add-watchlist-param").submit();
              var isstock = jQuery(this).parents('#add-watchlist-param').find("#dstockname").val();
             //var countli = jQuery(".listofinfo li").length;
             //if (countli != 0) {
                console.log(isstock);

               if (isstock != "" && jQuery("#add-watchlist-param input:checkbox:checked").length > 0 ) {
                  jQuery("#add-watchlist-param").submit();
                  $('.chart-loader').css("display","block");
                  $(this).hide();
             }
              //}
           });

           
//Start Notifications ============================================================================================================================

function getval() {
  var currentTime = new Date()
  var hours = currentTime.getHours()
  var minutes = currentTime.getMinutes()

  if (minutes < 10) minutes = "0" + minutes;

  var suffix = "AM";
  if (hours >= 12) {
      suffix = "PM";
      hours = hours - 12;
  }
  if (hours == 0) {
      hours = 12;
  }
  var current_time = hours + ":" + minutes + " " + suffix;

  return current_time;
}

function get24Hr(time){
  var hours = Number(time.match(/^(\d+)/)[1]);
  var AMPM = time.match(/\s(.*)$/)[1];
  if(AMPM == "PM" && hours<12) hours = hours+12;
  if(AMPM == "AM" && hours==12) hours = hours-12;

  var minutes = Number(time.match(/:(\d+)/)[1]);
  hours = hours*100+minutes;
  return hours;
}

function newwatchlist(){
        jQuery.ajax({
            method: "get",
            url: "/sidebar-api/?daction=get_user_metas",
            dataType: 'json',
            success: function(data){
              var usermetas = data;
              $.each(usermetas, function(index, dinfo){
                var stockname = dinfo.stockname;
                console.log("Stockname: " + stockname);
                jQuery.ajax({
                  method: "get",
                  url: "/wp-json/data-api/v1/stocks/history/latest?exchange=PSE&symbol=" + stockname,
                  dataType: 'json',
                  success: function(data){
                    var stocklastdata = parseFloat(data.data.last);

                    //compare now

                    //Entry Price

                      if (parseFloat(dinfo.dconnumber_entry_price) == stocklastdata.toFixed(2)) {
                        var dslert = '<div class="noti-message">';
                          dslert += '<div class="vertical-align">';
                            dslert += '<a class="cont-logo">';
                              dslert += '<span style="border: 2px solid #f44336 !important;">'+stockname+'</span>';
                            dslert += '</a>';
                            dslert += '<div class="md-rightside">';
                              dslert += '<a class="cont-bodymessage">';
                                dslert += 'Buy Now! <br>';
                                dslert += '<span class="disc-text">Current price is now ₱'+stocklastdata.toFixed(2)+'</span>';

                              dslert += '</a>';
                              dslert += '<div class="op-btnchart">';
                                dslert += '<div class="btn-show"><a href="/chart/'+stockname+'">Show</a></div>';
                                dslert += '<div class="btn-close xclsbtn">Close</div>';
                              dslert += '</div>';
                            dslert += '</div>';
                          dslert += '</div>';
                        dslert += '</div>';
                        jQuery(".alert-handler").append(dslert);

                      }

                    //stoplosspoint

                      if (parseFloat(dinfo.dconnumber_stop_loss_point) > stocklastdata.toFixed(2)) {
                        var dslert = '<div class="noti-message">';
                          dslert += '<div class="vertical-align">';
                            dslert += '<a class="cont-logo">';
                              dslert += '<span style="border: 2px solid #f44336 !important;">'+stockname+'</span>';
                            dslert += '</a>';
                            dslert += '<div class="md-rightside">';
                              dslert += '<a class="cont-bodymessage">';
                                dslert += 'Sell Now and Stop your loss! <br>';
                                dslert += '<span class="disc-text">Current price is now ₱'+stocklastdata.toFixed(2)+'</span>';

                              dslert += '</a>';
                              dslert += '<div class="op-btnchart">';
                                dslert += '<div class="btn-show"><a href="/chart/'+stockname+'">Show</a></div>';
                                dslert += '<div class="btn-close xclsbtn">Close</div>';
                              dslert += '</div>';
                            dslert += '</div>';
                          dslert += '</div>';
                        dslert += '</div>';
                        jQuery(".alert-handler").append(dslert);
                      }

                    //takeprofit

                      if (parseFloat(dinfo.dconnumber_take_profit_point) < stocklastdata.toFixed(2)) {
                        var dslert = '<div class="noti-message">';
                          dslert += '<div class="vertical-align">';
                            dslert += '<a class="cont-logo">';
                              dslert += '<span style="border: 2px solid #f44336 !important;">'+stockname+'</span>';
                            dslert += '</a>';
                            dslert += '<div class="md-rightside">';
                              dslert += '<a class="cont-bodymessage">';
                                dslert += 'Sell Now and Secure your Profit! <br>';
                                dslert += '<span class="disc-text">Current price is now ₱'+stocklastdata.toFixed(2)+'</span>';

                              dslert += '</a>';
                              dslert += '<div class="op-btnchart">';
                                dslert += '<div class="btn-show"><a href="/chart/'+stockname+'">Show</a></div>';
                                dslert += '<div class="btn-close xclsbtn">Close</div>';
                              dslert += '</div>';
                            dslert += '</div>';
                          dslert += '</div>';
                        dslert += '</div>';
                        jQuery(".alert-handler").append(dslert);
                      }

                  }
                });
              });
            }
        });
}


  function removealerts() {
    jQuery(".alert-handler").find('div').fadeOut( "slow", function() {
      jQuery(this).remove();
    });
  }

  jQuery(".alert-handler").on("click", ".xclsbtn", function(){
    jQuery(this).parents('.noti-message').fadeOut( "slow", function() {
      jQuery(this).remove();
    });
  });



var startTime = '09:30 AM';
var endTime = '11:30 PM';
var curr_time = getval();
if (get24Hr(curr_time) > get24Hr(startTime) && get24Hr(curr_time) < get24Hr(endTime)) {
  newwatchlist();

    $counts = 1;
    setInterval(function(){
        $counts++;
        removealerts();
        if ($counts <= 1) {
        newwatchlist();
        }
    },30000);
}

//End Notifications ============================================================================================================================
});
