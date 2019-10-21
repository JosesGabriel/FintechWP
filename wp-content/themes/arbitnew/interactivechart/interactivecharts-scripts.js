$(document).ready(function(){
    var $dragging = null;
    $('body').on("mousedown", "#draggable_buysell", function(e) {
        $(this).attr('unselectable', 'on').addClass('draggable');
        var el_w = $('.draggable').outerWidth(),
            el_h = $('.draggable').outerHeight();
        $('body').on("mousemove", function(e) {
            if ($dragging) {
                $dragging.offset({
                    top: e.pageY - el_h / 2,
                    left: e.pageX - el_w / 2
                });
            }
        });
        $dragging = $(e.target);
    }).on("mouseup", ".draggable", function(e) {
        $dragging = null;
        $(this).removeAttr('unselectable').removeClass('draggable');
    });
    
    $(window).load(function() {
        $("#status, #status_txt").fadeOut("fast");
        $("#preloader").delay(400).fadeOut("slow");
    })
    $( ".bidaskbar_btn" ).click(function() {
      $( ".bidaskbar_opt" ).slideToggle("fast");
    }); 
    $(".bidaskbar_opt ul li a").click(function(e){
        e.preventDefault();
        var dtype = $(this).attr('data-istype');
        $(this).parents(".bidaskbar").find(".arb_bar").hide();
        $(this).parents(".bidaskbar").find("."+dtype).show();
        $(this).parents(".bidaskbar_opt").hide();
    });

    $( ".arb_buy" ).hover(function() {
        var boardlotget = $("#inpt_data_boardlot_get").val();
        if ( boardlotget >= 0.0001 && boardlotget <= 0.0099){
                $("#inpt_data_boardlot").val(1000000);
        } else if ( boardlotget >= 0.01 && boardlotget <= 0.049){
                $("#inpt_data_boardlot").val(100000);
        } else if ( boardlotget >= 0.05 && boardlotget <= 0.495){
                $("#inpt_data_boardlot").val(10000);
        } else if ( boardlotget >= 0.5 && boardlotget <= 4.99){
                $("#inpt_data_boardlot").val(1000);
        } else if ( boardlotget >= 5 && boardlotget <= 49.95){
                $("#inpt_data_boardlot").val(100);
        } else if ( boardlotget >= 50 && boardlotget <= 999.5){
                $("#inpt_data_boardlot").val(10);
        } else if ( boardlotget >= 1000){
                $("#inpt_data_boardlot").val(5);
        }
        var getthestocksym = $('#inpt_data_stock').val();
        $('#bidaskbox').prop('src', "/bidask-box/?stocksym="+getthestocksym);
    });

    if (_symbol == 'PSEI') {
        $('#bullbearframe').prop('src', "/pleaseselect.html");
        $( ".ng-scope" ).click(function() {
            var getthestocksym = $('#inpt_data_stock').val();
            $('#bullbearframe').prop('src', "/sentiments/"+getthestocksym);
        });
    } else {
        $('#bullbearframe').prop('src', "/sentiments/" + _symbol);
        $( ".ng-scope" ).click(function() {
            var getthestocksym = $('#inpt_data_stock').val();
            $('#bullbearframe').prop('src', "/sentiments/"+getthestocksym);
        });
    }

    jQuery(".ticker_enabler-dropdown").click(function(e){
        event.stopPropagation();
        var tickertog = jQuery(".ticker_enabler-dropdown > ul").hasClass("dropopen");

        if (tickertog) {
            jQuery(".ticker_enabler-dropdown > ul").hide().removeClass("dropopen");
        } else {
            jQuery(".ticker_enabler-dropdown > ul").show().addClass("dropopen");
        }
    });
    jQuery("ul.main-drops-chart").click(function(e){
        event.stopPropagation();
        var isopen = jQuery("ul.main-drops-chart > ul").hasClass("dropopen");

        if (isopen) {
            jQuery("ul.main-drops-chart > ul").hide().removeClass("dropopen");
        } else {
            jQuery("ul.main-drops-chart > ul").show().addClass("dropopen");
        }
    });
    jQuery(document).on("click", function () {
        jQuery(".ticker_enabler-dropdown").hide().removeClass("dropopen");
        jQuery("ul.main-drops-chart > ul").hide().removeClass("dropopen");
        jQuery("ul.main-drops > ul").hide().removeClass("dropopen");
        jQuery("ul.main-drops > ul").hide().removeClass("dropopen");
        jQuery(".opennotification .notifinnerbase .um-notification-live-feed").hide().removeClass("dropopen");
    });
    jQuery("ul.main-drops-chart > ul li:first-child").on("click", function () {
        event.stopPropagation();
         var openthis = jQuery("#showplease").hasClass("dropthiss");
         if ( openthis ) {
             jQuery("#toghandle").hide().removeClass("dropthiss");
        } else {
            jQuery("#toghandle").show().addClass("dropthiss");
        }
    });
    jQuery("ul.main-drops-chart > ul li:nth-child(2)").on("click", function () {
        event.stopPropagation();
        jQuery("#toghandlings").show().addClass("dropthiss");

    });
    jQuery("ul.main-drops-chart > ul li:nth-child(3)").on("click", function () {
        event.stopPropagation();
        jQuery("#toghandlingers").show().addClass("dropthiss");
    });
    jQuery(".toclassclose").on('click', function(){
        jQuery("#toghandle").hide().removeClass("dropthiss");
    });
    jQuery(".toclassclosess").on('click', function(){
        jQuery("#toghandlings").hide().removeClass("dropthiss");
    });
    jQuery(".toclasscloserss").on('click', function(){
        jQuery("#toghandlingers").hide().removeClass("dropthiss");
    });

    jQuery(".buySell__date-picker").attr('max', moment().format("YYYY-MM-DD"));

    var x = 0;
    var y = 0;

    function fees(marketval) {
        //commission
        var dpartcommission = marketval * 0.0025;
        var dcommission = (dpartcommission > 20 ? dpartcommission : 20);

        var dtax = dcommission * 0.12;
        var dtransferfee = marketval * 0.00005;
        var dsccp = marketval * 0.0001;

        return dcommission + dtax + dtransferfee + dsccp;
    }

    function format_number(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }

    $('.inpt_data_price, .inpt_data_qty').keyup(function() {
        var buyprice = $('.inpt_data_price').val().replace(/[^0-9\.]/g, '');
        var buyquanti = $('.inpt_data_qty').val().replace(/[^0-9\.]/g, '');

        if (parseFloat(buyprice) > 0 && parseFloat(buyquanti) > 0) {
            var marketvalx = parseFloat(buyprice) * parseFloat(buyquanti);
            var dfees = fees(marketvalx);

            var totalcost = marketvalx + dfees;

            $(".inpt_total_cost").val(format_number(totalcost));
        } else {
            $(".inpt_total_cost").val('00.00');
        }
        
    });

    $( ".closesidebar a" ).click(function(){
        $( ".mobileinithide" ).addClass("hidesidebar", function(){
            $(".closesidebar").fadeOut("fast", function(){
                $(".opensidebar").fadeIn();
            });
        });
    });
    
    $( ".opensidebar a" ).click(function(){
        $( ".mobileinithide" ).addClass("showsidebar", function(){
            $(".opensidebar").fadeOut("fast", function(){
                $( ".mobileinithide" ).removeClass("hidesidebar");
                $( ".closesidebar" ).fadeIn();
            });
        });
    });
    
    
    $( ".mobileinithide .fa-outdent" ).click(function(){
        $( ".mobileinithide" ).animate({right: "0px"},500, function(){
            $( ".chartlocker" ).fadeIn(500);
            $( ".mobileinithide .fa-outdent" ).fadeOut(500, function(){
                $( ".mobileinithide .fa-indent, .arb_buysell" ).fadeIn();
            });
        });
    });

    $( ".mobileinithide .fa-indent" ).click(function(){
        $( ".mobileinithide" ).animate({right: "-260px"},500, function(){
            $( ".mobileinithide .fa-indent" ).fadeOut(500, function(){
                $( ".mobileinithide .fa-outdent, .arb_buysell" ).fadeIn();
            });
            $( ".chartlocker" ).fadeOut(500);
        });
    });

    jQuery.ajax({
        method: "GET",
        url: "/apipge/?daction=checkifhavestock&symbol="+_symbol,
        dataType: 'json',
        data: {
            'action' : 'post_sentiment',
            'stock' : _symbol
        },
        success: function(data) {
            if(data.status == "yes_stock"){
                $("#sellvolume").val(data.data.volume);
                $("#sellavrprice").val(data.data.averageprice);
                $("#tradelogs").val(data.data.tradelog);
                $("#confirmsellparts").show();
            }
        }
    });
        
    $(".bbs_bull").click(function(e){
        e.preventDefault();
        if (!$(this).parents('.bullbearsents').hasClass('clickedthis')) {

            $(this).parents('.bullbearsents').addClass("clickedthis");

            var dbull = $(this).parents('.bullbearsents').attr('data-bull');
            var dbear = $(this).parents('.bullbearsents').attr('data-bear');

            var dclass = $(this).attr('class');

            jQuery.ajax({
                method: "POST",
                url: "/apipge/?daction=sentimentbull&stock="+_symbol+"&userid="+_user_id+"&dbasebull="+dbull+"&dbasebear="+dbear+"&dbuttonact="+dclass,
                dataType: 'json',
                data: {
                    'action' : 'post_sentiment',
                    'stock' : _symbol,
                    'postid' : _post_id,
                    'userid' : _user_id,
                    'dbasebull': dbull,
                    'dbasebear': dbear,
                    'dbuttonact' : dclass
                },
                success: function(data) {

                    $( ".dbaronchart" ).animate({
                        width: "70%"
                    },500, function(){
                        
                    });

                    $( ".bbs_bear_bar, .bbs_bull_bar" ).fadeIn("fast",function(){
                            $( ".bullbearsents_label" ).animate({marginTop: "6px"},"slow");
                    });

                    $( ".bullbearsents .bbs_bear, .bullbearsents .bbs_bull" ).addClass("bbbutton-sen");

                    $( ".bbs_bear_bar" ).animate({
                        width: data.dbear+"%"
                    },500, function(){
                        $( ".bbs_bear_bar span" ).text(data.dbear.toFixed(2)+"%");
                        $( ".bbs_bear_bar span" ).fadeIn("fast");
                    });

                    $( ".bbs_bull_bar" ).animate({
                        width: data.dbull+"%"
                    },500, function(){
                        $( ".bbs_bull_bar span" ).text(data.dbull.toFixed(2)+"%");
                        $( ".bbs_bull_bar span" ).fadeIn("fast");
                    });

                    $(".bullbearsents_label").html("Members sentiments");

                }
            });

        } 
    });

    $(".bbs_bear").click(function(e){
        e.preventDefault();
        if (!$(this).parents('.bullbearsents').hasClass('clickedthis')) {
            var pathname = window.location.pathname;

            $(this).parents('.bullbearsents').addClass("clickedthis");

            var dbull = $(this).parents('.bullbearsents').attr('data-bull');
            var dbear = $(this).parents('.bullbearsents').attr('data-bear');

            var dclass = $(this).attr('class');

            jQuery.ajax({
                method: "POST",
                url: "/apipge/?daction=sentimentbear&stock="+_symbol+"&userid="+_user_id+"&dbasebull="+dbull+"&dbasebear="+dbear+"&dbuttonact="+dclass,
                dataType: 'json',
                data: {
                    'action' : 'post_sentiment',
                    'stock' : _symbol,
                    'postid' : _post_id,
                    'userid' : _user_id,
                    'dbasebull': dbull,
                    'dbasebear': dbear,
                    'dbuttonact' : dclass
                },
                success: function(data) {

                    $( ".dbaronchart" ).animate({
                        width: "70%"
                    },500, function(){

                    });

                    $( ".bbs_bear_bar, .bbs_bull_bar" ).fadeIn("fast",function(){
                            $( ".bullbearsents_label" ).animate({marginTop: "6px"},"slow");
                    });

                    $( ".bullbearsents .bbs_bear, .bullbearsents .bbs_bull" ).addClass("bbbutton-sen");

                    $( ".bbs_bear_bar" ).animate({
                        width: data.dbear+"%"
                    },500, function(){
                        $( ".bbs_bear_bar span" ).text(data.dbear.toFixed(2)+"%");
                        $( ".bbs_bear_bar span" ).fadeIn("fast");
                    });

                    $( ".bbs_bull_bar" ).animate({
                        width: data.dbull+"%"
                    },500, function(){
                        $( ".bbs_bull_bar span" ).text(data.dbull.toFixed(2)+"%");
                        $( ".bbs_bull_bar span" ).fadeIn("fast");
                    });

                    $(".bullbearsents_label").html("Members sentiments");

                }
            });

        } 
    });

    jQuery('.inpt_data_price').keyup(function(){
        var inputVal = jQuery(this).val().length;
        if(inputVal != 0){
            y = 1
        }
    });
    jQuery('.inpt_data_qty').keyup(function(){
        var inputVal2 = jQuery(this).val().length;
        if(inputVal2 != 0){
            x = 1
        }
    });

    $(".confirmtrd").click(function(e){

        var dbuypower = $(".input_buy_power").attr('data-dbaseval');
        var dpurprice = $(".inpt_data_price").val().replace(/[^0-9\.]/g, '');
        var dpurqty = $(".inpt_data_qty").val().replace(/[^0-9\.]/g, '');		
        
        if (parseFloat(dbuypower) < (parseFloat(dpurprice) * parseFloat(dpurqty))) {
            e.preventDefault();
            $(".derrormes").text('You can only purchase a maximum of '+ numeral(dbuypower / dpurprice).format('0,0.00') +' stocks if the price is ₱'+ numeral(dpurprice).format('0,0.00')  );
        }else {
            if(x == 1 && y == 1){
                $('.chart-loader').css("display","block");
                $(this).hide();
            }
        }
    
    });

    jQuery('input.number').keyup(function (event) {
        // charts
        // skip for arrow keys
        if (event.which >= 37 && event.which <= 40) {
            event.preventDefault();
        }

        var currentVal = jQuery(this).val();
        var testDecimal = testDecimals(currentVal);
        if (testDecimal.length > 1) {
            currentVal = currentVal.slice(0, -1);
        }
        jQuery(this).val(replaceCommas(currentVal));

    });

    /* Start of WebTicker */
    /*$('#webTicker').webTicker({
        speed:100,
        height:"50px", 
        startEmpty:true,
        hoverpause:true, 
        transition: "linear",
    });*/ 

    // $(function () {
    //     $('.marquee').marquee({
    //         speed:2000,
    //         duplicated: true,
    //         allowCss3Support: true
    //     });
    // });

    jQuery('i#ticker_eye').click(function(){
        var el = jQuery(this)[0].className;
        if(el.includes('slash')===false){
            //console.log('stop');
          //  $("#webTicker").webTicker('stop');
        }else{
            //console.log('start');
          //  $("#webTicker").webTicker('cont');
        }
    });

    // jQuery(document).on("mouseenter", "#webTicker", function() {
    //     // hover starts code here
    //     console.log('hovered');
    // });
    /* End of WebTicker */

});

$(window).bind("resize", function () {
    viewHeight = $(window).height();
    viewWidth = $(window).width();
    if (viewWidth < 990) {
    $(".mobilefull").css({"height": (viewHeight - 295)});

    $(".closesidebar").hide();
    
    // $("div#tv_chart_container:before").on('toggle', function(){
    //     $("div#tv_chart_container:before").css({"left" : "0 !important", "width" : "100% !important"});
    // });
    }
}).trigger("resize");
    
function testDecimals(currentVal) {
    var count;
    currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
    return count;
}

function replaceCommas(yourNumber) {
    var components = yourNumber.toString().split(".");
    if (components.length === 1) 
        components[0] = yourNumber;
    components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if (components.length === 2)
        components[1] = components[1].replace(/\D/g, "");
    return components.join(".");
}