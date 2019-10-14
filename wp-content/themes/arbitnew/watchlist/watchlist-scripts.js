$(document).ready(function(){

  $(".button-toggle-content").click(function () {
    $(".watched-hidden-content").toggle('slow');
    if($(".button-toggle-content").hasClass('isopen')){
        $(".button-toggle-content").html('<i class="fas fa-sort-down" id="fa-up" style="bottom: 0px;top: -2px;position: relative;font-size: 16px;margin-right: 4px;vertical-align: initial;"></i><strong>Show more</strong>').removeClass('isopen').slideDown( "slow" );
        $(".watched-hidden-content").slideUp( "slow" );
    }else {
        $(".button-toggle-content").html('<i class="fas fa-sort-up" id="fa-up" style="bottom: 0;top: 4px;position: relative;font-size: 16px;margin-right: 4px;vertical-align: initial;"></i><strong>Hide</strong>').addClass('isopen');
        $(".watched-hidden-content").slideDown( "slow" );
    }
});

$.ajax({
    type:'POST',
    url:'/wp-json/data-api/v1/stocks/history/latest?exchange=PSE',
    dataType: 'json',
    //data: "stockss="+JSON.stringify(data),
    success: function(response) {
          $(".trendingpreloader").hide();
        // var myJSON = JSON.stringify(response);
          var stocks = [];
          var stocks2 = [];
          var i = 0;
          var d = new Date();
          var curr_date = d.getDate();
          var curr_month = d.getMonth() + 1; //Months are zero based
          var curr_year = d.getFullYear();
          var dt = curr_year + "-" + curr_month + "-" + curr_date;
          var cur_d;
          var cur_m;
          var cur_y;

         // console.log(dt);
          jQuery.each(response.data, function(i, val) {
              stocks[i] = [];
              stocks[i][0] = val.symbol;
              stocks[i][1] = val.changepercentage;
              stocks[i][2] = val.description;
              var ltime = val.lastupdatetime;
              var ltime2 = ltime.split('T');
              stocks[i][3] = new Date(ltime2[0]);                        
              i++;
          });

          stocks.sort(function(a, b){
              return b[3] - a[3];
          });

          var sdate = new Date(stocks[0][3]);
          var new_day = sdate.getDate();
          var new_mo = sdate.getMonth() + 1;
          var new_yr = sdate.getFullYear();
      
          var n = 0;

          do {
              cur_d = stocks[n][3].getDate();
              cur_m = stocks[n][3].getMonth() + 1;
              cur_y = stocks[n][3].getFullYear();
              stocks2[n] = [];
              stocks2[n][0] = stocks[n][0];
              stocks2[n][1] = stocks[n][1]; 
              stocks2[n][2] = stocks[n][2];  
              stocks2[n][3] = stocks[n][3]; 
              //console.log(stocks[n][3]);
              n++;
          }while(new_day == cur_d && new_mo == cur_m && new_yr == cur_y);

          stocks2.sort(function(a, b){
              return b[1] - a[1];
          });
          var colorsgainers = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5'];
          var colorslossers = ['#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
          for (var i = 0; i < 5; i++) {
              
              var list = '<li class="odd"> <span style="border-color:' + colorsgainers[i] + ';">' + stocks2[i][0] + '</span>';
                  list += '<a href="#">' + stocks2[i][2] + '<br><p style="color: #53b987 !important;">' + stocks2[i][1].toFixed(2) + '%</p></a>';
                  list += '</li>';

              jQuery(".gainers ul").append(list);
          }

          stocks2.sort(function(a, b){
              return a[1] - b[1];
          });

          for (var i = 0; i < 5; i++) {
              
              var list = '<li class="odd"> <span style="border-color:' + colorslossers[i] + ';">' + stocks2[i][0] + '</span>';
                  list += '<a href="#">' + stocks2[i][2] + '<br><p style="color: #eb4d5c !important;">' + stocks2[i][1].toFixed(2) + '%</p></a>';
                  list += '</li>';

              jQuery(".losers ul").append(list);
          }
      },
      error: function(response) {                 
      }
  });

 
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


    //jQuery('.addwatch').click(function(e){
    $('body').on('click touchstart','.addwatch',function(){
      //jQuery(".dtabcontent > div").removeClass('active').hide('slow');
      jQuery('.dclosetab').removeClass('active').hide('slow');
      jQuery(".dtabcontent .addwatchtab").addClass('active').show('slow');

            $.ajax({
                url: "/wp-json/data-api/v1/stocks/list",
                type: 'post',
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

     $('.logo-image').on('click', function(){
      $('.left-dashboard-part').css('left','0');
       $('.swipecenter-area-r').css('display','block');
      //$('.right-image').find('.close-leftsidebar').css('display','block');
    });

     $('.close-leftsidebar').on('click', function(){
      $('.left-dashboard-part').css('left','-100%');
    });

    $(".left-dashboard-part").swipe({
      swipeStatus:function(event, phase, direction, distance, duration, fingers)
          {
              
              if (phase=="move" && direction =="left") {
                  $('.left-dashboard-part').css('left','-100%');
                   $('.swipecenter-area-r').css('display','none');
                  $('.right-image').find('.close-leftsidebar').css('display','none');
                   return false;
              }
          }
    });

    $(".center-dashboard-part").swipe({
      swipeStatus:function(event, phase, direction, distance, duration, fingers)
          {
              if (phase=="move" && direction =="right") {
                   $('.left-dashboard-part').css('left','0');
                   $('.right-dashboard-part').css("right","-110%");
                    $('.swipecenter-area-r').css('display','block');
                   $('.right-image').find('.close-leftsidebar').css('display','block');
                   return false;
              }

              if (phase=="move" && direction =="left") {
                  jQuery('.right-dashboard-part').css("display","block");
                  jQuery('.right-dashboard-part').css("right","0%");
                  $('.left-dashboard-part').css('left','-100%');
                   $('.swipecenter-area-r').css('display','block');
                //$('#right-slider-icon').attr('src','/wp-content/themes/arbitnew/images/cancel.svg');
                  $('#right-slider-icon').attr('width','15px');
                  $('#right-menu').removeClass();
                   
                   return false;
              }
              
          }
    });

     $(".swipeleft-area-l").swipe({
      swipeStatus:function(event, phase, direction, distance, duration, fingers)
          {
              
              if (phase=="move" && direction =="left") {
                  $('.left-dashboard-part').css('left','-100%');
                  $('.right-image').find('.close-leftsidebar').css('display','none');
                   return false;
              }
          }
    });

    $(".swiperight-area-r").swipe({
      swipeStatus:function(event, phase, direction, distance, duration, fingers)
          {         
              if (phase=="move" && direction =="right") {
                jQuery('.right-dashboard-part').css("right","-110%");
          //$('#right-slider-icon').attr('src','/wp-content/themes/arbitnew/images/menu.svg');
          $('#right-slider-icon').attr('width','20px');
          $('#right-menu').addClass('right-slider-menu1');     
                   return false;
              }
          }
    });

    $(".swiperight-area-r2").swipe({
      swipeStatus:function(event, phase, direction, distance, duration, fingers)
          {         
              if (phase=="move" && direction =="right") {
                jQuery('.right-dashboard-part').css("right","-110%");
          $('#right-slider-icon').attr('width','20px');
          $('#right-menu').addClass('right-slider-menu1');     
                   return false;
              }
          }
    });

    $(".right-dashboard-part").swipe({
      swipeStatus:function(event, phase, direction, distance, duration, fingers)
          {         
              if (phase=="move" && direction =="right") {
                jQuery('.right-dashboard-part').css("right","-110%");
                $('.swipecenter-area-r').css('display','none');
                //$('#right-slider-icon').attr('src','/wp-content/themes/arbitnew/images/menu.svg');
                $('#right-slider-icon').attr('width','20px');
                $('#right-menu').addClass('right-slider-menu1');     
                   return false;
              }
          }
    });

     $(".swipecenterl").swipe({
      swipeStatus:function(event, phase, direction, distance, duration, fingers)
          {

              if (phase=="move" && direction =="left") {
                  jQuery('.right-dashboard-part').css("display","block");
            jQuery('.right-dashboard-part').css("right","0%");
            $('.swipecenter-area-r').css('display','block');
          //$('#right-slider-icon').attr('src','/wp-content/themes/arbitnew/images/cancel.svg');
          $('#right-slider-icon').attr('width','15px');
          $('#right-menu').removeClass();
                   
                   return false;
              }
              
          }
    });
    $(".swipecenterr").swipe({
      swipeStatus:function(event, phase, direction, distance, duration, fingers)
          {

              if (phase=="move" && direction =="right") {
                   $('.left-dashboard-part').css('left','0');
                     $('.swipecenter-area-r').css('display','block');
                     $('.right-image').find('.close-leftsidebar').css('display','block');  
                     return false;
              }
              
          }
    });

    $('.swipecenter-area-r').on('click touchstart', function(){

        if($('.left-dashboard-part').css('left') == '0px'){
          $('.left-dashboard-part').css('left','-100%');
          $('.swipecenter-area-r').css('display','none');
        }else {
          jQuery('.right-dashboard-part').css("right","-110%");
              $('.swipecenter-area-r').css('display','none');
        }

    });


    jQuery('.right-slider-menu').click(function(){

    if($('#right-menu').hasClass('right-slider-menu1')){
      jQuery('.right-dashboard-part').css("display","block");
      jQuery('.right-dashboard-part').css("right","0%");
      //$('#riht-slider-icon').attr('src','/wp-content/themes/arbitnew/images/cancel.svg');
      $('#right-slider-icon').attr('width','15px');
      $('#right-menu').removeClass();
    }else{
      jQuery('.right-dashboard-part').css("right","-110%");
      //$('#right-slider-icon').attr('src','/wp-content/themes/arbitnew/images/menu.svg');
      $('#right-slider-icon').attr('width','20px');
      $('#right-menu').addClass('right-slider-menu1');
    }
  });

  $(".um-activity-widget .um-activity-foot.status").mouseover(function(){
      $(".swipe-area-l").css("z-index", "-1");
    });

  $(".um-activity-widget .um-activity-foot.status").mouseout(function(){
     $(".swipe-area-l").css("z-index", "0");
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

// function newwatchlist(){
//         jQuery.ajax({
//             method: "get",
//             url: "/sidebar-api/?daction=get_user_metas",
//             dataType: 'json',
//             success: function(data){
//               var usermetas = data;
//               $.each(usermetas, function(index, dinfo){
//                 var stockname = dinfo.stockname;
//                 console.log("Stockname: " + stockname);
//                 jQuery.ajax({
//                   method: "post",
//                   url: "/wp-json/data-api/v1/stocks/history/latest?exchange=PSE&symbol=" + stockname,
//                   dataType: 'json',
//                   success: function(data){
//                     var stocklastdata = parseFloat(data.data.last);

//                     //compare now

//                     //Entry Price

//                       if (parseFloat(dinfo.dconnumber_entry_price) == stocklastdata.toFixed(2)) {
//                         var dslert = '<div class="noti-message">';
//                           dslert += '<div class="vertical-align">';
//                             dslert += '<a class="cont-logo">';
//                               dslert += '<span style="border: 2px solid #f44336 !important;">'+stockname+'</span>';
//                             dslert += '</a>';
//                             dslert += '<div class="md-rightside">';
//                               dslert += '<a class="cont-bodymessage">';
//                                 dslert += 'Buy Now! <br>';
//                                 dslert += '<span class="disc-text">Current price is now ₱'+stocklastdata.toFixed(2)+'</span>';

//                               dslert += '</a>';
//                               dslert += '<div class="op-btnchart">';
//                                 dslert += '<div class="btn-show"><a href="/chart/'+stockname+'">Show</a></div>';
//                                 dslert += '<div class="btn-close xclsbtn">Close</div>';
//                               dslert += '</div>';
//                             dslert += '</div>';
//                           dslert += '</div>';
//                         dslert += '</div>';
//                         jQuery(".alert-handler").append(dslert);

//                       }

//                     //stoplosspoint

//                       if (parseFloat(dinfo.dconnumber_stop_loss_point) > stocklastdata.toFixed(2)) {
//                         var dslert = '<div class="noti-message">';
//                           dslert += '<div class="vertical-align">';
//                             dslert += '<a class="cont-logo">';
//                               dslert += '<span style="border: 2px solid #f44336 !important;">'+stockname+'</span>';
//                             dslert += '</a>';
//                             dslert += '<div class="md-rightside">';
//                               dslert += '<a class="cont-bodymessage">';
//                                 dslert += 'Sell Now and Stop your loss! <br>';
//                                 dslert += '<span class="disc-text">Current price is now ₱'+stocklastdata.toFixed(2)+'</span>';

//                               dslert += '</a>';
//                               dslert += '<div class="op-btnchart">';
//                                 dslert += '<div class="btn-show"><a href="/chart/'+stockname+'">Show</a></div>';
//                                 dslert += '<div class="btn-close xclsbtn">Close</div>';
//                               dslert += '</div>';
//                             dslert += '</div>';
//                           dslert += '</div>';
//                         dslert += '</div>';
//                         jQuery(".alert-handler").append(dslert);
//                       }

//                     //takeprofit

//                       if (parseFloat(dinfo.dconnumber_take_profit_point) < stocklastdata.toFixed(2)) {
//                         var dslert = '<div class="noti-message">';
//                           dslert += '<div class="vertical-align">';
//                             dslert += '<a class="cont-logo">';
//                               dslert += '<span style="border: 2px solid #f44336 !important;">'+stockname+'</span>';
//                             dslert += '</a>';
//                             dslert += '<div class="md-rightside">';
//                               dslert += '<a class="cont-bodymessage">';
//                                 dslert += 'Sell Now and Secure your Profit! <br>';
//                                 dslert += '<span class="disc-text">Current price is now ₱'+stocklastdata.toFixed(2)+'</span>';

//                               dslert += '</a>';
//                               dslert += '<div class="op-btnchart">';
//                                 dslert += '<div class="btn-show"><a href="/chart/'+stockname+'">Show</a></div>';
//                                 dslert += '<div class="btn-close xclsbtn">Close</div>';
//                               dslert += '</div>';
//                             dslert += '</div>';
//                           dslert += '</div>';
//                         dslert += '</div>';
//                         jQuery(".alert-handler").append(dslert);
//                       }

//                   }
//                 });
//               });
//             }
//         });
// }


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
//   newwatchlist();

    $counts = 1;
    setInterval(function(){
        $counts++;
        removealerts();
        if ($counts <= 1) {
        // newwatchlist();
        }
    },30000);
}

//End Notifications ============================================================================================================================
});
